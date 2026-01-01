<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\GuruJabatan;
use App\Models\GuruMapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\TahunAjaran;


class GuruController extends Controller
{
public function index()
{
    $guru = Guru::with(['jabatans', 'mapels'])
    ->orderBy('id_guru', 'asc') // ⬅️ INI PENTING
        ->get();
    

    // Statistik dasar
    $statistik = [
        // Total
        'total' => $guru->count(),

        // Jenis kelamin
        'laki' => $guru->where('jenis_kelamin', 'L')->count(),
        'perempuan' => $guru->where('jenis_kelamin', 'P')->count(),

        // Status kepegawaian
        'gty' => [
            'total' => $guru->where('status_kepegawaian', 'GTY')->count(),
            'l' => $guru->where('status_kepegawaian', 'GTY')->where('jenis_kelamin', 'L')->count(),
            'p' => $guru->where('status_kepegawaian', 'GTY')->where('jenis_kelamin', 'P')->count(),
        ],
        'gtty' => [
            'total' => $guru->where('status_kepegawaian', 'GTTY')->count(),
            'l' => $guru->where('status_kepegawaian', 'GTTY')->where('jenis_kelamin', 'L')->count(),
            'p' => $guru->where('status_kepegawaian', 'GTTY')->where('jenis_kelamin', 'P')->count(),
        ],

        // Sertifikasi
        'sertifikasi' => [
            'total' => $guru->where('status_sertifikasi', 'sertifikasi')->count(),
            'l' => $guru->where('status_sertifikasi', 'sertifikasi')->where('jenis_kelamin', 'L')->count(),
            'p' => $guru->where('status_sertifikasi', 'sertifikasi')->where('jenis_kelamin', 'P')->count(),
        ],
        'ppg' => [
            'total' => $guru->where('status_sertifikasi', 'ppg')->count(),
            'l' => $guru->where('status_sertifikasi', 'ppg')->where('jenis_kelamin', 'L')->count(),
            'p' => $guru->where('status_sertifikasi', 'ppg')->where('jenis_kelamin', 'P')->count(),
        ],
        'belum' => [
            'total' => $guru->where('status_sertifikasi', 'belum')->count(),
            'l' => $guru->where('status_sertifikasi', 'belum')->where('jenis_kelamin', 'L')->count(),
            'p' => $guru->where('status_sertifikasi', 'belum')->where('jenis_kelamin', 'P')->count(),
        ],
    ];

    // Statistik pendidikan
    $pendidikanList = ['SMA','D I','D II','D III','D III4','D IV','S1','S2','S3'];
    $statistik['pendidikan'] = [];
    foreach ($pendidikanList as $pd) {
        $statistik['pendidikan'][$pd] = [
            'total' => $guru->where('pendidikan', $pd)->count(),
            'l' => $guru->where('pendidikan', $pd)->where('jenis_kelamin', 'L')->count(),
            'p' => $guru->where('pendidikan', $pd)->where('jenis_kelamin', 'P')->count(),

            // GTY per pendidikan
            'gty_total' => $guru->where('pendidikan', $pd)->where('status_kepegawaian', 'GTY')->count(),
            'gty_l' => $guru->where('pendidikan', $pd)->where('status_kepegawaian', 'GTY')->where('jenis_kelamin', 'L')->count(),
            'gty_p' => $guru->where('pendidikan', $pd)->where('status_kepegawaian', 'GTY')->where('jenis_kelamin', 'P')->count(),

            // GTTY per pendidikan
            'gtty_total' => $guru->where('pendidikan', $pd)->where('status_kepegawaian', 'GTTY')->count(),
            'gtty_l' => $guru->where('pendidikan', $pd)->where('status_kepegawaian', 'GTTY')->where('jenis_kelamin', 'L')->count(),
            'gtty_p' => $guru->where('pendidikan', $pd)->where('status_kepegawaian', 'GTTY')->where('jenis_kelamin', 'P')->count(),
        ];
    }

    return view('admin.guru.index', compact('guru', 'statistik'));
}

    public function create()
    {
        return view('admin.guru.create');
    }

public function store(Request $request)
{
    DB::transaction(function () use ($request) {

        // 1️⃣ SIMPAN GURU
        $guru = Guru::create($request->only([
            'id_guru',
            'nama',
            'jenis_kelamin',
            'status_kepegawaian',
            'tempat_lahir',
            'tanggal_lahir',
            'nbm',
            'nuptk',
            'pendidikan',
            'jurusan',
            'status_sertifikasi',
            'tmt',
        ]));

        // 2️⃣ SIMPAN JABATAN
        if ($request->has('jabatan')) {
            foreach ($request->jabatan as $index => $jabatan) {

                if (!$jabatan) continue;

                GuruJabatan::create([
                    'guru_id' => $guru->id,
                    'jabatan' => $jabatan,
                    'bidang'  => $request->bidang[$index] ?? null,
                ]);
            }
        }

        // 3️⃣ SIMPAN MAPEL
        if ($request->has('mapel')) {
            foreach ($request->mapel as $mapel) {
                if ($mapel) {
                    GuruMapel::create([
                        'guru_id' => $guru->id,
                        'nama_mapel' => $mapel,
                    ]);
                }
            }
        }

    });

    return redirect()
        ->route('admin.guru.index')
        ->with('success', 'Data guru berhasil disimpan');
}


    public function edit($id)
    {
        $guru = Guru::with(['jabatans', 'mapels'])->findOrFail($id);
        return view('admin.guru.edit', compact('guru'));
    }

public function update(Request $request, $id)
{
    $guru = Guru::findOrFail($id);

    // Validasi
    $request->validate([
        'id_guru'            => 'required|unique:gurus,id_guru,' . $guru->id,
        'nama'               => 'required|string|max:255',
        'jenis_kelamin'      => 'required|in:L,P',
        'status_kepegawaian' => 'required|in:GTY,GTTY',
        'pendidikan'         => 'required|in:SMA,D I,D II,D III,D IV,S1,S2,S3',
        'jurusan'            => 'nullable|string|max:100',
        'status_sertifikasi' => 'required|in:belum,sertifikasi,ppg',
        'tanggal_lahir'      => 'nullable|date',
        'tmt'                => 'required|date',
        'jabatan'            => 'required|array',
        'jabatan.*'          => 'required|string|in:kepala_madrasah,wakil_kepala,kepala_tu,staff_tu,bendahara,guru_mapel',
        'bidang'             => 'nullable|string|max:100',
        'mapel'              => 'nullable|array',
        'mapel.*'            => 'nullable|string|max:100',
    ]);

    DB::transaction(function() use ($request, $guru) {
        // Update data utama guru
        $guru->update($request->only([
            'id_guru','nama','jenis_kelamin','tempat_lahir','tanggal_lahir',
            'nbm','nuptk','status_kepegawaian','pendidikan','jurusan',
            'status_sertifikasi','tmt'
        ]));

        // Hapus jabatan lama & simpan baru
        GuruJabatan::where('guru_id', $guru->id)->delete();
        foreach ($request->jabatan as $jabatan) {
            GuruJabatan::create([
                'guru_id' => $guru->id,
                'jabatan' => $jabatan,
                'bidang'  => $jabatan === 'wakil_kepala' ? $request->bidang : null,
            ]);
        }

        // Hapus mapel lama & simpan baru
        GuruMapel::where('guru_id', $guru->id)->delete();
        if ($request->mapel) {
            foreach ($request->mapel as $mapel) {
                $mapel = trim($mapel);
                if ($mapel) {
                    GuruMapel::create([
                        'guru_id'    => $guru->id,
                        'nama_mapel' => $mapel,
                    ]);
                }
            }
        }
    });

    return redirect()->route('admin.guru.index')
                     ->with('success', 'Data guru berhasil diperbarui!');
}




    public function toggleStatus($id)
    {
        $guru = Guru::findOrFail($id);
        $guru->status = !$guru->status;
        $guru->save();
        return back();
    }

public function destroy($id)
{
    DB::transaction(function () use ($id) {
        // Pastikan guru ada
        $guru = Guru::findOrFail($id);

        // Hapus data relasi dulu
        GuruJabatan::where('guru_id', $id)->delete();
        GuruMapel::where('guru_id', $id)->delete();

        // Hapus guru
        $guru->delete();
    });

    return redirect()
        ->back()
        ->with('success', 'Data guru berhasil dihapus');
}


    public function show($id)
    {
        $guru = Guru::with(['jabatans', 'mapels'])->findOrFail($id);
        return view('admin.guru.show', compact('guru'));
    }

public function cetakPdfBase64(Request $request, $id)
{
    $guru = Guru::with(['jabatans','mapels'])->findOrFail($id);

    $pdf = PDF::loadView('admin.guru.pdf', compact('guru'))
              ->setPaper('A4', 'portrait');

    return response()->json([
        'success' => true,
        'guru'    => $guru->nama,
        'mime'    => 'application/pdf',
        'base64'  => base64_encode($pdf->output()),
    ]);
}

public function cetak()
{
    $guru = Guru::orderBy('nama')->get();

    $pdf = Pdf::loadView('admin.guru.cetak', compact('guru'))
        ->setPaper('A4', 'landscape');

    return $pdf->stream('data-guru.pdf');
}

public function formCetakDaftarHadir()
{
    return view('admin.guru.cetak-daftarhadir-form');
}

public function cetakDaftarHadir(Request $request)
{
    $request->validate([
        'judul_atas'  => 'required|string|max:255',
        'judul_bawah' => 'required|string|max:255',
    ]);

    $judulAtas  = strtoupper($request->judul_atas);
    $judulBawah = strtoupper($request->judul_bawah);

    // Tahun ajaran aktif
    $tahunAjaranAktif = TahunAjaran::where('aktif', 1)->first();

    $guru = Guru::orderBy('id_guru', 'asc')->get();

    $pdf = Pdf::loadView(
        'admin.guru.cetak-daftarhadir',
        compact(
            'guru',
            'judulAtas',
            'judulBawah',
            'tahunAjaranAktif'
        )
    )->setPaper('legal', 'portrait');

    return $pdf->stream('daftar-hadir-guru.pdf');
}





}
