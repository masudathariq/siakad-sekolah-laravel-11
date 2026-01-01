<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\Rombel;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class AlumniController extends Controller
{
    /* ================== LIST & FILTER ALUMNI ================== */
    public function index(Request $request)
    {
        $query = Alumni::select('alumnis.*')
            ->join('tahun_ajarans', 'alumnis.tahun_ajaran_id', '=', 'tahun_ajarans.id');

        // 🔹 FILTER TAHUN AJARAN
        if ($request->filled('tahun_ajaran_id')) {
            $query->where('alumnis.tahun_ajaran_id', $request->tahun_ajaran_id);
        }

        $alumnis = $query
            ->orderByDesc('tahun_ajarans.nama')
            ->orderBy('alumnis.nama_siswa')
            ->get();

        // 🔹 Data dropdown filter
        $tahunAjarans = TahunAjaran::orderByDesc('nama')->get();

        return view('admin.alumni.index', compact('alumnis', 'tahunAjarans'));
    }

    /* ================== CETAK DATA ALUMNI ================== */
    public function cetak(Request $request)
    {
        $query = Alumni::with('tahunAjaran')
            ->join('tahun_ajarans', 'alumnis.tahun_ajaran_id', '=', 'tahun_ajarans.id');

        if ($request->filled('tahun_ajaran_id')) {
            $query->where('alumnis.tahun_ajaran_id', $request->tahun_ajaran_id);
        }

        $alumnis = $query
            ->orderByDesc('tahun_ajarans.nama')
            ->orderBy('alumnis.nama_siswa')
            ->get();

        $tahunAjaran = null;
        if ($request->filled('tahun_ajaran_id')) {
            $tahunAjaran = TahunAjaran::find($request->tahun_ajaran_id);
        }

        $pdf = Pdf::loadView('admin.alumni.cetak', [
                'alumnis' => $alumnis,
                'tahunAjaran' => $tahunAjaran
            ])
            ->setPaper('A4', 'landscape');

        return $pdf->stream('data-alumni.pdf');
    }

    /* ================== PROSES LULUSKAN ================== */
    public function luluskan(Rombel $rombel)
    {
        $tahunAktif = TahunAjaran::where('aktif', true)->firstOrFail();

        DB::transaction(function () use ($rombel, $tahunAktif) {

            $siswas = $rombel->siswas;

            foreach ($siswas as $siswa) {

                Alumni::updateOrCreate(
                    ['nisn' => $siswa->nisn],
                    [
                        'nis'             => $siswa->nis,
                        'nama_siswa'      => $siswa->nama_siswa,
                        'jenis_kelamin'   => $siswa->jenis_kelamin,
                        'tempat_lahir'    => $siswa->tempat_lahir,
                        'tanggal_lahir'   => $siswa->tanggal_lahir,
                        'ayah'            => $siswa->ayah,
                        'ibu'             => $siswa->ibu,
                        'wali'            => $siswa->wali,
                        'alamat'          => $siswa->alamat,
                        'sekolah_asal'    => $siswa->sekolah_asal,
                        'rombel_id'       => $siswa->rombel_id,
                        'tahun_ajaran_id' => $tahunAktif->id,
                    ]
                );
            }

            // Lepas siswa dari rombel
            $rombel->siswas()->update(['rombel_id' => null]);
        });

        return redirect()
            ->route('admin.alumni.index')
            ->with('success', 'Siswa berhasil diluluskan dan masuk data alumni');
    }

    /* ================== HAPUS ALUMNI ================== */
    public function hapus(Alumni $alumni)
    {
        DB::transaction(function () use ($alumni) {

            // Hapus data siswa jika masih ada
            Siswa::where('nisn', $alumni->nisn)->delete();

            // Hapus alumni
            $alumni->delete();
        });

        return redirect()
            ->route('admin.alumni.index')
            ->with('success', 'Data alumni berhasil dihapus');
    }
}
