<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rombel;
use App\Models\TahunAjaran;
use App\Models\Tingkat;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Alumni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\RombelExport;
use Maatwebsite\Excel\Facades\Excel;

class RombelController extends Controller
{
    /* =======================
     * LIST ROMBEL
     * ======================= */
public function index(Request $request)
{
    // 1. Ambil ID dari URL (jika admin sedang memfilter manual)
    $tahunAjaranId = $request->tahun_ajaran;

    // 2. Jika tidak sedang memfilter (klik dari sidebar), cari Tahun Ajaran yang AKTIF (1)
    if (!$tahunAjaranId) {
        $aktif = TahunAjaran::where('aktif', 1)
                            ->orderBy('nama', 'asc') // Urutkan berdasarkan nama (misal 2025/2026)
                            ->first();
        
        $tahunAjaranId = $aktif ? $aktif->id : null;
    }

    // 3. Validasi: Jika di DB tidak ada satupun yang aktif=1
    if (!$tahunAjaranId) {
        return redirect()->route('admin.tahun-ajaran.index')
            ->with('error', 'Tidak ditemukan Tahun Ajaran yang berstatus Aktif.');
    }

    // 4. Ambil data tahun ajaran terpilih
    $tahunAjaran = TahunAjaran::findOrFail($tahunAjaranId);
    $tahunAjaranAktif = $tahunAjaran;

    // 5. Ambil SEMUA Rombel yang terikat ke ID Tahun Ajaran ini
    $rombels = Rombel::with(['tingkat', 'waliKelas', 'siswas'])
        ->where('tahun_ajaran_id', $tahunAjaranId)
        ->orderBy('tingkat_id', 'asc')
        ->get();

    return view('admin.rombel.index', compact('rombels', 'tahunAjaran', 'tahunAjaranAktif'));
}
    /* =======================
     * FORM TAMBAH ROMBEL
     * ======================= */
    public function create(Request $request)
    {
        $tahunAjaranId = $request->tahun_ajaran;

        if (!$tahunAjaranId) {
            abort(404, 'Tahun ajaran tidak dipilih');
        }

        $tahunAjaran = TahunAjaran::findOrFail($tahunAjaranId);
        $tahunAjaranAktif = $tahunAjaran; // Sinkronisasi
        
        $tingkats    = Tingkat::orderBy('urutan')->get();
        $gurus       = Guru::where('status', true)->orderBy('nama')->get();

        return view('admin.rombel.create', compact('tahunAjaran', 'tingkats', 'gurus', 'tahunAjaranAktif'));
    }

    /* =======================
     * SIMPAN ROMBEL
     * ======================= */
    public function store(Request $request)
    {
        $request->validate([
            'tahun_ajaran_id' => 'required|exists:tahun_ajarans,id',
            'tingkat_id'      => 'required|exists:tingkats,id',
            'wali_kelas_id'   => 'nullable|exists:gurus,id',
            'kode_kelas'      => 'required|string|max:5',
            'nama_kelas'      => 'nullable|string|max:50',
            'jenis_rombel'    => 'required|in:reguler,pondok',
        ]);

        Rombel::create([
            'tahun_ajaran_id' => $request->tahun_ajaran_id,
            'tingkat_id'      => $request->tingkat_id,
            'wali_kelas_id'   => $request->wali_kelas_id,
            'kode_kelas'      => strtoupper($request->kode_kelas),
            'nama_kelas'      => $request->nama_kelas,
            'jenis_rombel'    => $request->jenis_rombel,
        ]);

        return redirect()->route('admin.rombel.index', ['tahun_ajaran' => $request->tahun_ajaran_id])
                         ->with('success', 'Rombel berhasil dibuat');
    }

    /* =======================
     * DETAIL ROMBEL
     * ======================= */
    public function show(Rombel $rombel)
    {
        $rombel->load(['tahunAjaran', 'tingkat', 'waliKelas', 'siswas']);

        $tahunTujuan = TahunAjaran::where('aktif', true)
            ->where('id', '!=', $rombel->tahun_ajaran_id)
            ->first();

        // KUNCI: Agar klik detail tidak error Undefined Variable $tahunAjaranAktif
        $tahunAjaranAktif = $rombel->tahunAjaran;

        return view('admin.rombel.show', compact('rombel', 'tahunTujuan', 'tahunAjaranAktif'));
    }

    /* =======================
     * KELOLA SISWA
     * ======================= */
    public function siswa(Rombel $rombel)
    {
        $siswas = Siswa::whereNull('rombel_id')
            ->orderBy('nama_siswa')
            ->get();
        
        $tahunAjaranAktif = $rombel->tahunAjaran; // Sinkronisasi

        return view('admin.rombel.siswa', compact('rombel', 'siswas', 'tahunAjaranAktif'));
    }

    public function simpanSiswa(Request $request, Rombel $rombel)
    {
        $request->validate([
            'siswa'   => 'required|array',
            'siswa.*' => 'exists:siswas,nisn',
        ]);

        Siswa::whereIn('nisn', $request->siswa)
            ->update(['rombel_id' => $rombel->id]);

        return redirect()->route('admin.rombel.show', $rombel->id)
                         ->with('success', 'Siswa berhasil dimasukkan ke rombel');
    }

    public function keluarkanSiswa(Rombel $rombel, Siswa $siswa)
    {
        if ($siswa->rombel_id !== $rombel->id) {
            return back()->with('error', 'Siswa bukan anggota rombel ini');
        }

        $siswa->update(['rombel_id' => null]);

        return back()->with('success', 'Siswa berhasil dikeluarkan');
    }

    /* =======================
     * PINDAH SISWA
     * ======================= */
    public function formPindahSiswa(Rombel $rombel, Siswa $siswa)
    {
        $rombels = Rombel::where('id', '!=', $rombel->id)
            ->with(['tahunAjaran', 'tingkat'])
            ->get();
        
        $tahunAjaranAktif = $rombel->tahunAjaran; // Sinkronisasi

        return view('admin.rombel.pindah-siswa', compact('rombel', 'siswa', 'rombels', 'tahunAjaranAktif'));
    }

    public function pindahSiswa(Request $request, Rombel $rombel, Siswa $siswa)
    {
        $request->validate([
            'rombel_id' => 'required|exists:rombels,id'
        ]);

        $siswa->update([
            'rombel_id' => $request->rombel_id
        ]);

        return redirect()->route('admin.rombel.show', $request->rombel_id)
                         ->with('success', 'Siswa berhasil dipindahkan');
    }

    /* =======================
     * NAIK KELAS
     * ======================= */
    public function formNaikKelas(Rombel $rombel)
    {
        if ($rombel->tingkat->urutan >= 3) {
            return back()->with('error', 'Rombel kelas terakhir tidak bisa naik');
        }

        $tahunTujuan = TahunAjaran::where('aktif', true)
            ->where('id', '!=', $rombel->tahun_ajaran_id)
            ->first();

        if (!$tahunTujuan) {
            return back()->with('error', 'Tahun ajaran tujuan belum tersedia');
        }

        $tingkatTujuan = Tingkat::where('urutan', $rombel->tingkat->urutan + 1)->first();

        $rombelsTujuan = Rombel::where('tahun_ajaran_id', $tahunTujuan->id)
            ->where('tingkat_id', $tingkatTujuan->id)
            ->get();
        
        $tahunAjaranAktif = $rombel->tahunAjaran; // Sinkronisasi

        return view('admin.rombel.naik-kelas', compact('rombel', 'rombelsTujuan', 'tahunTujuan', 'tahunAjaranAktif'));
    }

    public function prosesNaikKelas(Request $request, Rombel $rombel)
    {
        $request->validate([
            'rombel_tujuan_id' => 'required|exists:rombels,id'
        ]);

        DB::transaction(function () use ($rombel, $request) {
            Siswa::where('rombel_id', $rombel->id)
                ->update(['rombel_id' => $request->rombel_tujuan_id]);
        });

        return redirect()->route('admin.rombel.show', $request->rombel_tujuan_id)
                         ->with('success', 'Siswa berhasil naik kelas');
    }

    /* =======================
     * LULUSKAN
     * ======================= */
    public function luluskan($rombelId)
    {
        $rombel = Rombel::with('siswas', 'tahunAjaran')->findOrFail($rombelId);

        foreach ($rombel->siswas as $siswa) {
            Alumni::updateOrCreate(
                ['nisn' => $siswa->nisn],
                [
                    'nis'            => $siswa->nis,
                    'nama_siswa'     => $siswa->nama_siswa,
                    'jenis_kelamin'  => $siswa->jenis_kelamin,
                    'tempat_lahir'   => $siswa->tempat_lahir,
                    'tanggal_lahir'  => $siswa->tanggal_lahir,
                    'ayah'           => $siswa->ayah,
                    'ibu'            => $siswa->ibu,
                    'wali'           => $siswa->wali,
                    'alamat'         => $siswa->alamat,
                    'sekolah_asal'   => $siswa->sekolah_asal,
                    'rombel_id'      => $siswa->rombel_id,
                    'tahun_ajaran_id'=> $rombel->tahun_ajaran_id,
                ]
            );
        }

        $rombel->siswas()->update(['rombel_id' => null]);

        return redirect()->back()->with('success', 'Siswa berhasil diluluskan dan masuk ke daftar alumni.');
    }

    /* =======================
     * EDIT & UPDATE ROMBEL
     * ======================= */
    public function edit($id)
    {
        $rombel   = Rombel::with('tahunAjaran')->findOrFail($id);
        $tingkats = Tingkat::orderBy('urutan')->get();
        $gurus    = Guru::where('status', true)->orderBy('nama')->get();
        
        $tahunAjaranAktif = $rombel->tahunAjaran; // Sinkronisasi

        return view('admin.rombel.edit', compact('rombel', 'tingkats', 'gurus', 'tahunAjaranAktif'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tingkat_id'      => 'required|exists:tingkats,id',
            'kode_kelas'      => 'required|string|max:5',
            'nama_kelas'      => 'nullable|string|max:50',
            'jenis_rombel'    => 'required|in:reguler,pondok',
            'wali_kelas_id'   => 'nullable|exists:gurus,id',
        ]);

        $rombel = Rombel::findOrFail($id);

        $rombel->update([
            'tingkat_id'    => $request->tingkat_id,
            'kode_kelas'    => strtoupper($request->kode_kelas),
            'nama_kelas'    => $request->nama_kelas,
            'jenis_rombel'  => $request->jenis_rombel,
            'wali_kelas_id' => $request->wali_kelas_id,
        ]);

        return redirect()->route('admin.rombel.index', ['tahun_ajaran' => $rombel->tahun_ajaran_id])
                         ->with('success', 'Rombel berhasil diperbarui');
    }

    /* =======================
     * CETAK & EXPORT
     * ======================= */
    public function cetak(Rombel $rombel)
    {
        $rombel->load(['tahunAjaran', 'tingkat', 'waliKelas', 'siswas']);
        $pdf = Pdf::loadView('admin.rombel.cetak', compact('rombel'))->setPaper('A4', 'portrait');
        return $pdf->stream('Rombel-' . $rombel->tingkat->nama . '-' . $rombel->kode_kelas . '.pdf');
    }

    public function preview(Rombel $rombel)
    {
        $rombel->load(['tahunAjaran', 'tingkat', 'waliKelas', 'siswas']);
        $pdf = Pdf::loadView('admin.rombel.cetak', compact('rombel'))->setPaper('A4', 'portrait');
        
        $pdfContent = $pdf->output();
        $pdfBase64  = base64_encode($pdfContent);
        $tahunAjaranAktif = $rombel->tahunAjaran; // Sinkronisasi

        return view('admin.rombel.preview', compact('pdfBase64', 'rombel', 'tahunAjaranAktif'));
    }

    public function exportExcel($id)
    {
        $rombel = Rombel::with('siswas', 'tingkat')->findOrFail($id);
        $fileName = str_replace(' ', '_', $rombel->tingkat->nama . '-' . $rombel->kode_kelas . '-' . $rombel->nama_kelas . '.xlsx');
        return Excel::download(new RombelExport($rombel), $fileName);
    }




// Menampilkan form cetak daftar hadir siswa
public function formCetakDaftarHadirSiswa()
{
    // Ambil tahun ajaran aktif
    $tahunAktif = TahunAjaran::where('aktif', 1)->first();

    // Jika tidak ada tahun ajaran aktif, rombel dikosongkan
    if (!$tahunAktif) {
        $rombels = collect(); // collection kosong
    } else {
        // Ambil rombel yang ada di tahun ajaran aktif, beserta relasi tingkat, urut berdasarkan tingkat
        $rombels = Rombel::with('tingkat')
                    ->where('tahun_ajaran_id', $tahunAktif->id)
                    ->get()
                    ->sortBy(function($r) {
                        return $r->tingkat->nama;
                    })
                    ->values(); // reset index
    }

    return view('admin.rombel.cetak-daftarhadir-siswa-form', compact('rombels'));
}

// Proses cetak daftar hadir siswa
public function cetakDaftarHadirSiswa(Request $request)
{
    $request->validate([
        'rombel_id'    => 'required|exists:rombels,id',
        'judul_atas'   => 'required|string|max:255',
        'judul_bawah'  => 'required|string|max:255',
    ]);

    $rombel = Rombel::with('siswas')->findOrFail($request->rombel_id);

    $judulAtas  = strtoupper($request->judul_atas);
    $judulBawah = strtoupper($request->judul_bawah);

    // Tahun ajaran aktif
    $tahunAjaranAktif = TahunAjaran::where('aktif', 1)->first();

    $pdf = Pdf::loadView(
        'admin.rombel.cetak-daftarhadir-siswa',
        compact(
            'rombel',
            'judulAtas',
            'judulBawah',
            'tahunAjaranAktif'
        )
    )->setPaper('legal', 'portrait');

    return $pdf->stream('daftar-hadir-siswa.pdf');
}


}