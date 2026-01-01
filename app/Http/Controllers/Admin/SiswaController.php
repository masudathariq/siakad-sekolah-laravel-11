<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Imports\SiswaImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Exports\SiswaTemplateExport;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf; // pastikan sudah install barryvdh/laravel-dompdf




class SiswaController extends Controller
{
    public function index(Request $request)
{
    $query = Siswa::query();

    // 🔍 Cari NISN / Nama
    if ($request->filled('q')) {
        $query->where(function ($q) use ($request) {
            $q->where('nisn', 'like', '%' . $request->q . '%')
              ->orWhere('nama_siswa', 'like', '%' . $request->q . '%');
        });
    }

    // 🚻 Filter Jenis Kelamin
    if ($request->filled('jk')) {
        $query->where('jenis_kelamin', $request->jk);
    }

    $siswa = $query
        ->orderBy('nama_siswa')
        ->get();

        // Pagination 20 per halaman
    $siswa = $query->orderBy('nama_siswa')->paginate(30)->withQueryString();


    return view('admin.siswa.index', compact('siswa'));
}


    public function create()
    {
        return view('admin.siswa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nisn'           => 'required|unique:siswas,nisn',
            'nis'            => 'required|unique:siswas,nis',
            'nama_siswa'     => 'required|string|max:255',
            'jenis_kelamin'  => 'required|in:L,P',
            'tempat_lahir'   => 'required|string|max:100',
            'tanggal_lahir'  => 'required|date',
        ]);

        Siswa::create([
            'nisn'            => $request->nisn,
            'nis'             => $request->nis,
            'nama_siswa'      => $request->nama_siswa,
            'jenis_kelamin'   => $request->jenis_kelamin,
            'tempat_lahir'    => $request->tempat_lahir,
            'tanggal_lahir'   => $request->tanggal_lahir,
            'ayah'            => $request->ayah,
            'ibu'             => $request->ibu,
            'wali'            => $request->wali,
            'alamat'          => $request->alamat,
            'sekolah_asal'    => $request->sekolah_asal,
        ]);

        return redirect()
            ->route('admin.siswa.index')
            ->with('success', 'Data siswa berhasil ditambahkan');
    }

    public function show($nisn)
    {
        $siswa = Siswa::findOrFail($nisn);
        return view('admin.siswa.show', compact('siswa'));
    }

    public function edit($nisn)
    {
        $siswa = Siswa::findOrFail($nisn);
        return view('admin.siswa.edit', compact('siswa'));
    }

    public function update(Request $request, $nisn)
    {
        $siswa = Siswa::findOrFail($nisn);

        $request->validate([
            'nis'            => 'required|unique:siswas,nis,' . $nisn . ',nisn',
            'nama_siswa'     => 'required|string|max:255',
            'jenis_kelamin'  => 'required|in:L,P',
            'tempat_lahir'   => 'required|string|max:100',
            'tanggal_lahir'  => 'required|date',
        ]);

        $siswa->update([
            'nis'             => $request->nis,
            'nama_siswa'      => $request->nama_siswa,
            'jenis_kelamin'   => $request->jenis_kelamin,
            'tempat_lahir'    => $request->tempat_lahir,
            'tanggal_lahir'   => $request->tanggal_lahir,
            'ayah'            => $request->ayah,
            'ibu'             => $request->ibu,
            'wali'            => $request->wali,
            'alamat'          => $request->alamat,
            'sekolah_asal'    => $request->sekolah_asal,
        ]);

        return redirect()
            ->route('admin.siswa.index')
            ->with('success', 'Data siswa berhasil diupdate');
    }

    public function destroy($nisn)
    {
        Siswa::destroy($nisn);

        return redirect()
            ->route('admin.siswa.index')
            ->with('success', 'Data siswa berhasil dihapus');
    }

public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls'
    ]);

    $import = new \App\Imports\SiswaImport;

    Excel::import($import, $request->file('file'));

    $failed = $import->failedRows;

    if (count($failed)) {
        $messages = [];
        foreach ($failed as $f) {
            $messages[] = "NISN: {$f['nisn']}, Nama: {$f['nama']}, Kolom: {$f['attribute']}, Kesalahan: ".implode(', ', $f['errors']);
        }

        return back()
            ->with('success', 'Data valid berhasil diimport, namun ada beberapa baris gagal.')
            ->with('import_errors', implode('<br>', $messages));
    }

    return back()->with('success', 'Semua data siswa berhasil diimport');
}



// =========================
    // DOWNLOAD TEMPLATE EXCEL
    // =========================
    public function downloadTemplate()
    {
        return Excel::download(
            new SiswaTemplateExport,
            'template-siswa-lengkap.xlsx'
        );
    }

    // =========================
// HAPUS SEMUA SISWA
// =========================
public function hapusSemua()
{
    DB::transaction(function () {
        DB::table('rombel_siswa')->delete(); // hapus relasi dulu
        DB::table('siswas')->delete();       // baru hapus siswa
    });

    return redirect()
        ->route('admin.siswa.index')
        ->with('success', 'Semua data siswa berhasil dihapus');
}

public function cetakPDF(Request $request)
{
    $request->validate([
        'nisn' => 'required'
    ]);

    $siswa = Siswa::where('nisn', $request->nisn)->firstOrFail();

    $pdf = Pdf::loadView('admin.siswa.cetak_pdf', compact('siswa'));

    return response()->json([
        'mime'   => 'application/pdf',
        'base64' => base64_encode($pdf->output()),
    ]);
}


}
