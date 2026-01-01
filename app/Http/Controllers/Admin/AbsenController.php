<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rombel;
use App\Models\TahunAjaran;
use PDF; // DomPDF

class AbsenController extends Controller
{
    // Form pilih rombel
public function index()
{
    // Ambil tahun ajaran yang aktif
    $tahunAktif = TahunAjaran::where('aktif', 1)->first();

    // Pengaman jika belum ada tahun ajaran aktif
    if (!$tahunAktif) {
        return back()->with('error', 'Tahun ajaran aktif belum ditentukan');
    }

    // Ambil rombel hanya dari tahun ajaran aktif + DIURUTKAN
    $rombels = Rombel::with('tingkat')
        ->where('tahun_ajaran_id', $tahunAktif->id)
        ->orderBy('tingkat_id')   // 7 → 8 → 9
        ->orderBy('kode_kelas')   // A → B → C
        ->get();

    return view('admin.absen.index', compact('rombels','tahunAktif'));
}

    // Submit form → preview PDF
    public function cetak(Request $request)
    {
        $tahunAktif = TahunAjaran::where('aktif', 1)->first();

if (!$tahunAktif) {
    return back()->with('error', 'Tahun ajaran aktif belum ditentukan');
}

        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $semester = $request->semester;

        $daysInMonth = \Carbon\Carbon::create($tahun, $bulan)->daysInMonth;

        // 1️⃣ Tanggal merah default (Minggu)
        $tanggalMerah = [];
        for ($d = 1; $d <= $daysInMonth; $d++) {
            $tgl = \Carbon\Carbon::create($tahun, $bulan, $d)->toDateString();
            if (\Carbon\Carbon::create($tahun, $bulan, $d)->isSunday()) {
                $tanggalMerah[$tgl] = 'Minggu';
            }
        }

        // 2️⃣ Tanggal merah manual
        $tanggalMerahManual = [];
        if ($request->filled('tanggal_merah')) {
            foreach ($request->tanggal_merah as $line) {
                $line = trim($line);
                if (!empty($line) && str_contains($line, ':')) {
                    [$tgl, $ket] = explode(':', $line, 2);
                    $tgl = trim($tgl);
                    $ket = trim($ket);
                    if ($tgl && $ket) {
                        $tanggalMerahManual[$tgl] = $ket;
                        $tanggalMerah[$tgl] = $ket;
                    }
                }
            }
        }

// 3️⃣ Ambil data rombel
if ($request->rombel_id === 'semua') {
    $rombels = Rombel::with([
        'siswas' => function($q) {
            $q->orderBy('nama_siswa', 'asc');
        },
        'tingkat',
        'waliKelas'
    ])->get();

    $view = view('admin.absen.cetak-semua', compact(
        'rombels','bulan','tahun','daysInMonth','semester','tanggalMerah','tanggalMerahManual','tahunAktif'
    ));
} else {
    $rombel = Rombel::with([
        'siswas' => function($q) {
            $q->orderBy('nama_siswa', 'asc');
        },
        'tingkat',
        'waliKelas'
    ])->findOrFail($request->rombel_id);

    $view = view('admin.absen.cetak', compact(
        'rombel','bulan','tahun','daysInMonth','semester','tanggalMerah','tanggalMerahManual','tahunAktif'
    ));
}


        // 4️⃣ Render PDF dan preview di browser
        $pdf = PDF::loadHTML($view->render())
          ->setPaper('legal', 'landscape');


        return response($pdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="absensi.pdf"'); // preview, bukan download
    }

    public function preview(Request $request)
    {
        $tahunAktif = TahunAjaran::where('aktif', 1)->first();

if (!$tahunAktif) {
    return back()->with('error', 'Tahun ajaran aktif belum ditentukan');
}

        // Ambil data sama seperti cetak
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $semester = $request->semester;
    
        $daysInMonth = \Carbon\Carbon::create($tahun, $bulan)->daysInMonth;
    
        $tanggalMerah = [];
        for ($d = 1; $d <= $daysInMonth; $d++) {
            $tgl = \Carbon\Carbon::create($tahun, $bulan, $d)->toDateString();
            if (\Carbon\Carbon::create($tahun, $bulan, $d)->isSunday()) {
                $tanggalMerah[$tgl] = 'Minggu';
            }
        }
    
        $tanggalMerahManual = [];
        if ($request->filled('tanggal_merah')) {
            foreach ($request->tanggal_merah as $line) {
                $line = trim($line);
                if (!empty($line) && str_contains($line, ':')) {
                    [$tgl, $ket] = explode(':', $line, 2);
                    $tgl = trim($tgl);
                    $ket = trim($ket);
                    if ($tgl && $ket) {
                        $tanggalMerahManual[$tgl] = $ket;
                        $tanggalMerah[$tgl] = $ket;
                    }
                }
            }
        }
    
        // Ambil rombel atau semua
        if ($request->rombel_id == 'semua') {
            $rombels = Rombel::with('siswas','tingkat','waliKelas')->get();
            $view = view('admin.absen.cetak-semua', compact(
                'rombels','bulan','tahun','daysInMonth','semester','tanggalMerah','tanggalMerahManual','tahunAktif'
            ));
        } else {
            $rombel = Rombel::with('siswas','tingkat','waliKelas')->findOrFail($request->rombel_id);
            $view = view('admin.absen.cetak', compact(
                'rombel','bulan','tahun','daysInMonth','semester','tanggalMerah','tanggalMerahManual','tahunAktif'
            ));
        }
    
        $pdf = PDF::loadHTML($view->render());
        $pdfBase64 = base64_encode($pdf->output());
    
        return view('admin.absen.preview', compact('pdfBase64'));
    }
    
}
