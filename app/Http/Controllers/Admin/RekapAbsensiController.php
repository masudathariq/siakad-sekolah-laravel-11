<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rombel;
use App\Models\RekapAbsensi;
use App\Models\TahunAjaran;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class RekapAbsensiController extends Controller
{
    public function index(Request $request)
    {
        $rombelId = $request->rombel_id;

        if (!$rombelId) {
            abort(404, 'Rombel belum dipilih');
        }

        $rombel = Rombel::with('siswas')->findOrFail($rombelId);
        $tahunAjaran = TahunAjaran::where('aktif', 1)->first();

        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');

        $rekap = RekapAbsensi::where('rombel_id', $rombelId)
            ->where('tahun_ajaran_id', $tahunAjaran->id)
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->get()
            ->keyBy('siswa_nisn');

        // AMBIL HARI EFEKTIF DARI DATABASE (Jika ada)
        // Kita ambil dari data pertama karena satu rombel hari efektifnya pasti sama
        $savedHariEfektif = $rekap->first() ? $rekap->first()->hari_efektif : 25;

        return view('admin.rekap-absensi.index', compact(
            'rombel',
            'tahunAjaran',
            'bulan',
            'tahun',
            'rekap',
            'savedHariEfektif' // Kirim nilai yang tersimpan ke view
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'rombel_id'    => 'required',
            'bulan'        => 'required',
            'tahun'        => 'required',
            'hari_efektif' => 'required|integer|min:1', // Validasi input hari efektif
            'absensi'      => 'required|array',
        ]);

        $tahunAjaran = TahunAjaran::where('aktif', 1)->first();

        foreach ($request->absensi as $nisn => $data) {
            RekapAbsensi::updateOrCreate(
                [
                    'siswa_nisn'      => $nisn,
                    'rombel_id'       => $request->rombel_id,
                    'tahun_ajaran_id' => $tahunAjaran->id,
                    'bulan'           => $request->bulan,
                    'tahun'           => $request->tahun,
                ],
                [
                    'hadir'        => $data['hadir'] ?? 0,
                    'izin'         => $data['izin'] ?? 0,
                    'sakit'        => $data['sakit'] ?? 0,
                    'alpha'        => $data['alpha'] ?? 0,
                    'bolos'        => $data['bolos'] ?? 0,
                    'hari_efektif' => $request->hari_efektif, // SIMPAN HARI EFEKTIF KE DB
                ]
            );
        }

        return redirect()
            ->route('admin.rekap-absensi.index', [
                'rombel_id'    => $request->rombel_id,
                'bulan'        => $request->bulan,
                'tahun'        => $request->tahun,
                'hari_efektif' => $request->hari_efektif,
            ])
            ->with('success', 'Rekap absensi & hari efektif berhasil disimpan');
    }

    public function cetakPdf(Request $request)
    {
        $rombel = Rombel::with('siswas')->findOrFail($request->rombel_id);

        $bulan = (int) $request->bulan;
        $tahun = (int) $request->tahun;
        
        // Menangkap hari_efektif dari request JavaScript saat cetak
        $hariEfektif = $request->hari_efektif; 
        
        $namaBulan = \Carbon\Carbon::create()
            ->month($bulan)
            ->translatedFormat('F');

        $rekap = RekapAbsensi::where('rombel_id', $rombel->id)
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->get()
            ->keyBy('siswa_nisn');

        $pdf = PDF::loadView('admin.rekap-absensi.pdf', compact(
            'rombel',
            'rekap',
            'bulan',
            'tahun',
            'namaBulan',
            'hariEfektif' 
        ))->setPaper([0, 0, 595.28, 935.43], 'portrait');

        $pdfOutput = $pdf->output();
        $pdfBase64 = base64_encode($pdfOutput);

        return response()->json([
            'filename' => 'rekap-absensi-' . $rombel->nama_kelas . '.pdf',
            'mime'     => 'application/pdf',
            'base64'   => $pdfBase64,
        ]);
    }
}