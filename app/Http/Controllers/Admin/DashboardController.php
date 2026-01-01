<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Siswa;
use App\Models\Guru;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // =====================================================
        // 1️⃣ JUMLAH SISWA PER TINGKAT (TOTAL)
        // =====================================================
        $jumlahSiswaPerTingkat = DB::table('siswas')
            ->join('rombels', 'rombels.id', '=', 'siswas.rombel_id')
            ->join('tingkats', 'tingkats.id', '=', 'rombels.tingkat_id')
            ->join('tahun_ajarans', 'tahun_ajarans.id', '=', 'rombels.tahun_ajaran_id')
            ->where('tahun_ajarans.aktif', 1)
            ->select(
                'tingkats.id',
                'tingkats.nama',
                DB::raw('COUNT(siswas.nisn) as jumlah_siswa'),
                DB::raw("SUM(CASE WHEN siswas.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlah_laki"),
                DB::raw("SUM(CASE WHEN siswas.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlah_perempuan")
            )
            ->groupBy('tingkats.id', 'tingkats.nama')
            ->orderBy('tingkats.id')
            ->get();

        // =====================================================
        // 2️⃣ JUMLAH SISWA PER TINGKAT (REGULER & PONDOK)
        // =====================================================
        $jumlahSiswaPerTingkatJenis = DB::table('siswas')
            ->join('rombels', 'rombels.id', '=', 'siswas.rombel_id')
            ->join('tingkats', 'tingkats.id', '=', 'rombels.tingkat_id')
            ->join('tahun_ajarans', 'tahun_ajarans.id', '=', 'rombels.tahun_ajaran_id')
            ->where('tahun_ajarans.aktif', 1)
            ->select(
                'tingkats.id',
                'tingkats.nama as tingkat',
                'rombels.jenis_rombel',
                DB::raw('COUNT(siswas.nisn) as jumlah_siswa'),
                DB::raw("SUM(CASE WHEN siswas.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlah_laki"),
                DB::raw("SUM(CASE WHEN siswas.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlah_perempuan")
            )
            ->groupBy('tingkats.id', 'tingkats.nama', 'rombels.jenis_rombel')
            ->orderBy('tingkats.id')
            ->get()
            ->groupBy('tingkat');

        // =====================================================
        // 3️⃣ TOTAL REGULER & PONDOK (SEMUA TINGKAT)
        // =====================================================
        $regulerLaki = $regulerPerempuan = $pondokLaki = $pondokPerempuan = 0;

        foreach ($jumlahSiswaPerTingkatJenis as $items) {
            $reguler = $items->firstWhere('jenis_rombel', 'reguler');
            $pondok  = $items->firstWhere('jenis_rombel', 'pondok');

            $regulerLaki += $reguler->jumlah_laki ?? 0;
            $regulerPerempuan += $reguler->jumlah_perempuan ?? 0;

            $pondokLaki += $pondok->jumlah_laki ?? 0;
            $pondokPerempuan += $pondok->jumlah_perempuan ?? 0;
        }

        $regulerTotal = $regulerLaki + $regulerPerempuan;
        $pondokTotal  = $pondokLaki + $pondokPerempuan;

        // =====================================================
        // 4️⃣ JUMLAH SISWA PER ROMBEL
        // =====================================================
        $jumlahSiswaPerRombel = DB::table('siswas')
            ->join('rombels', 'rombels.id', '=', 'siswas.rombel_id')
            ->join('tingkats', 'tingkats.id', '=', 'rombels.tingkat_id')
            ->join('tahun_ajarans', 'tahun_ajarans.id', '=', 'rombels.tahun_ajaran_id')
            ->where('tahun_ajarans.aktif', 1)
            ->select(
                'tingkats.id as tingkat_id',
                'tingkats.nama as tingkat_nama',
                'rombels.id as rombel_id',
                DB::raw("COALESCE(rombels.nama_kelas, CONCAT(tingkats.nama,' ',rombels.kode_kelas)) as rombel_nama"),
                DB::raw('COUNT(siswas.nisn) as jumlah_siswa'),
                DB::raw("SUM(CASE WHEN siswas.jenis_kelamin = 'L' THEN 1 ELSE 0 END) as jumlah_laki"),
                DB::raw("SUM(CASE WHEN siswas.jenis_kelamin = 'P' THEN 1 ELSE 0 END) as jumlah_perempuan")
            )
            ->groupBy(
                'tingkats.id',
                'tingkats.nama',
                'rombels.id',
                'rombels.nama_kelas',
                'rombels.kode_kelas'
            )
            ->orderBy('tingkats.id')
            ->orderBy('rombels.kode_kelas')
            ->get()
            ->groupBy('tingkat_nama');

        // =====================================================
        // 5️⃣ TAHUN AJARAN AKTIF
        // =====================================================
        $tahunAjaranAktif = DB::table('tahun_ajarans')
            ->where('aktif', 1)
            ->first();

        // =====================================================
        // 6️⃣ SISWA PER UMUR
        // =====================================================
        $siswaPerTingkatUmur = Siswa::with('rombel.tingkat')
            ->whereNotNull('tanggal_lahir')
            ->get()
            ->map(function ($siswa) {
                $siswa->umur = Carbon::parse($siswa->tanggal_lahir)->age;
                return $siswa;
            })
            ->groupBy(function ($siswa) {
                return optional(optional($siswa->rombel)->tingkat)->nama ?? 'Tidak Diketahui';
            })
            ->map(function ($items) {
                return $items->groupBy('umur')->map->count();
            });

// =====================================================
// 7️⃣ STATISTIK GURU (SESUI GURU CONTROLLER)
// =====================================================
$guru = Guru::with(['jabatans','mapels'])->get();

$statistik = [
    'total' => $guru->count(),
    'laki' => $guru->where('jenis_kelamin', 'L')->count(),
    'perempuan' => $guru->where('jenis_kelamin', 'P')->count(),

    'gty' => [
        'total' => $guru->where('status_kepegawaian','GTY')->count(),
        'l' => $guru->where('status_kepegawaian','GTY')->where('jenis_kelamin','L')->count(),
        'p' => $guru->where('status_kepegawaian','GTY')->where('jenis_kelamin','P')->count(),
    ],
    'gtty' => [
        'total' => $guru->where('status_kepegawaian','GTTY')->count(),
        'l' => $guru->where('status_kepegawaian','GTTY')->where('jenis_kelamin','L')->count(),
        'p' => $guru->where('status_kepegawaian','GTTY')->where('jenis_kelamin','P')->count(),
    ],

    'sertifikasi' => [
        'total' => $guru->where('status_sertifikasi','sertifikasi')->count(),
        'l' => $guru->where('status_sertifikasi','sertifikasi')->where('jenis_kelamin','L')->count(),
        'p' => $guru->where('status_sertifikasi','sertifikasi')->where('jenis_kelamin','P')->count(),
    ],
    'ppg' => [
        'total' => $guru->where('status_sertifikasi','ppg')->count(),
        'l' => $guru->where('status_sertifikasi','ppg')->where('jenis_kelamin','L')->count(),
        'p' => $guru->where('status_sertifikasi','ppg')->where('jenis_kelamin','P')->count(),
    ],
    'belum' => [
        'total' => $guru->where('status_sertifikasi','belum')->count(),
        'l' => $guru->where('status_sertifikasi','belum')->where('jenis_kelamin','L')->count(),
        'p' => $guru->where('status_sertifikasi','belum')->where('jenis_kelamin','P')->count(),
    ],
];

// Statistik pendidikan (sesuai GuruController)
$pendidikanList = ['SMA','D I','D II','D III','D III4','D IV','S1','S2','S3'];
$statistik['pendidikan'] = [];
foreach ($pendidikanList as $pd) {
    $statistik['pendidikan'][$pd] = [
        'total' => $guru->where('pendidikan', $pd)->count(),
        'l' => $guru->where('pendidikan', $pd)->where('jenis_kelamin','L')->count(),
        'p' => $guru->where('pendidikan', $pd)->where('jenis_kelamin','P')->count(),
        'gty_total' => $guru->where('pendidikan', $pd)->where('status_kepegawaian','GTY')->count(),
        'gty_l' => $guru->where('pendidikan', $pd)->where('status_kepegawaian','GTY')->where('jenis_kelamin','L')->count(),
        'gty_p' => $guru->where('pendidikan', $pd)->where('status_kepegawaian','GTY')->where('jenis_kelamin','P')->count(),
        'gtty_total' => $guru->where('pendidikan', $pd)->where('status_kepegawaian','GTTY')->count(),
        'gtty_l' => $guru->where('pendidikan', $pd)->where('status_kepegawaian','GTTY')->where('jenis_kelamin','L')->count(),
        'gtty_p' => $guru->where('pendidikan', $pd)->where('status_kepegawaian','GTTY')->where('jenis_kelamin','P')->count(),
    ];
}

$totalGuru = $guru->count();
$totalL = $guru->where('jenis_kelamin','L')->count();
$totalP = $guru->where('jenis_kelamin','P')->count();

        // =====================================================
        // 8️⃣ KIRIM SEMUA KE VIEW
        // =====================================================
        return view('admin.dashboard', compact(
            'tahunAjaranAktif',
            'jumlahSiswaPerTingkat',
            'jumlahSiswaPerTingkatJenis',
            'jumlahSiswaPerRombel',
            'siswaPerTingkatUmur',
            'regulerTotal',
            'regulerLaki',
            'regulerPerempuan',
            'pondokTotal',
            'pondokLaki',
            'pondokPerempuan',
            'statistik',
            'totalGuru',
            'totalL',
            'totalP'
        ));
    }
}
