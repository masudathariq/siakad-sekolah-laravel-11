<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class TahunAjaranController extends Controller
{
    // 📄 List tahun ajaran
    public function index()
{
    $tahunAjarans = TahunAjaran::orderBy('nama', 'desc')->get();

    return view('admin.tahun-ajaran.index', compact('tahunAjarans'));
}


    // ➕ Form tambah
    public function create()
    {
        return view('admin.tahun-ajaran.create');
    }

    // 💾 Simpan data
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|unique:tahun_ajarans,nama',
        ]);

        // 🔥 Jika diset aktif, nonaktifkan yang lain
        if ($request->aktif) {
            TahunAjaran::where('aktif', true)->update(['aktif' => false]);
        }

        TahunAjaran::create([
            'nama'  => $request->nama,
            'aktif' => $request->has('aktif'),
        ]);

        return redirect()
            ->route('admin.tahun-ajaran.index')
            ->with('success', 'Tahun ajaran berhasil ditambahkan');
    }

    // ✏️ Form edit
    public function edit($id)
    {
        $tahunAjaran = TahunAjaran::findOrFail($id);
        return view('admin.tahun-ajaran.edit', compact('tahunAjaran'));
    }

    // 🔄 Update data
public function update(Request $request, $id)
{
    $tahunAjaran = TahunAjaran::findOrFail($id);

    $request->validate([
        'nama' => 'required|unique:tahun_ajarans,nama,' . $id,
    ]);

    // Ambil status aktif (true jika dicentang, false jika tidak)
    $statusAktif = $request->has('aktif');

    // 🔥 Logika Penting:
    // Jika user mencentang 'aktif', maka nonaktifkan SEMUA yang lain.
    if ($statusAktif) {
        TahunAjaran::where('id', '!=', $id)->update(['aktif' => false]);
    }

    // Update data
    $tahunAjaran->update([
        'nama'  => $request->nama,
        'aktif' => $statusAktif, // Ini akan mengirim true atau false ke DB
    ]);

    return redirect()
        ->route('admin.tahun-ajaran.index')
        ->with('success', 'Tahun ajaran berhasil diperbarui');
}
}

