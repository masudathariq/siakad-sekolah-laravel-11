<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SuratKeluar;
use App\Models\TahunAjaran;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class SuratKeluarController extends Controller
{
// 1. Daftar surat keluar dengan Fitur Pencarian & List Tahun Ajaran
    public function index(Request $request)
    {
        $query = SuratKeluar::query();

        // Fitur Pencarian
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function($s) use ($q) {
                $s->where('nomor_surat', 'like', "%$q%")
                  ->orWhere('tujuan', 'like', "%$q%")
                  ->orWhere('perihal', 'like', "%$q%");
            });
        }

        // Ambil list untuk dropdown filter di Blade
        $listTahunAjaran = TahunAjaran::orderBy('nama', 'desc')->get();

        // Ambil data dengan pagination
        $suratKeluar = $query->orderBy('tanggal_surat', 'desc')->paginate(10);

        // Menjaga parameter pencarian tetap ada saat pindah halaman (pagination)
        $suratKeluar->appends(['q' => $request->q]);

        // PERBAIKAN: Masukkan listTahunAjaran ke dalam compact agar bisa dibaca oleh Blade
        return view('admin.surat.surat_keluar.index', compact('suratKeluar', 'listTahunAjaran'));
    }
    // 2. Form tambah
    public function create()
    {
        return view('admin.surat.surat_keluar.create');
    }

    // 3. Simpan surat keluar
    public function store(Request $request)
    {
        $request->validate([
            'nomor_surat'   => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'tujuan'        => 'required|string|max:255',
            'perihal'       => 'required|string|max:255',
            'sifat'         => 'required|string|max:50',
            'file'          => 'nullable|mimes:pdf|max:2048',
        ]);

        $data = $request->except('file');

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = 'surat_keluar_' 
                        . str_replace(['/', '\\'], '-', $request->nomor_surat) . '_'
                        . date('Ymd', strtotime($request->tanggal_surat)) . '_'
                        . preg_replace('/\s+/', '_', $request->tujuan)
                        . '.' . $file->getClientOriginalExtension();

            $data['file'] = $file->storeAs('surat_keluar', $filename, 'public');
        }

        SuratKeluar::create($data);

        return redirect()->route('admin.surat-keluar.index')
                         ->with('success', 'Surat keluar berhasil ditambahkan.');
    }

    // 4. Detail
    public function show($id)
    {
        $surat = SuratKeluar::findOrFail($id);
        return view('admin.surat.surat_keluar.show', compact('surat'));
    }

    // 5. Form edit
    public function edit($id)
    {
        $surat = SuratKeluar::findOrFail($id);
        return view('admin.surat.surat_keluar.edit', compact('surat'));
    }

    // 6. Update
    public function update(Request $request, $id)
    {
        $request->validate([
            'nomor_surat'   => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'tujuan'        => 'required|string|max:255',
            'perihal'       => 'required|string|max:255',
            'sifat'         => 'required|string|max:50',
            'file'          => 'nullable|mimes:pdf|max:2048',
        ]);

        $surat = SuratKeluar::findOrFail($id);
        $data = $request->except('file');

        if ($request->hasFile('file')) {
            // Hapus file lama jika ada
            if ($surat->file && Storage::disk('public')->exists($surat->file)) {
                Storage::disk('public')->delete($surat->file);
            }

            $file = $request->file('file');
            $filename = 'surat_keluar_' 
                        . str_replace(['/', '\\'], '-', $request->nomor_surat) . '_'
                        . date('Ymd', strtotime($request->tanggal_surat)) . '_'
                        . preg_replace('/\s+/', '_', $request->tujuan)
                        . '.' . $file->getClientOriginalExtension();

            $data['file'] = $file->storeAs('surat_keluar', $filename, 'public');
        }

        $surat->update($data);

        return redirect()->route('admin.surat-keluar.index')
                         ->with('success', 'Surat keluar berhasil diperbarui.');
    }

    // 7. Hapus
    public function destroy($id)
    {
        $surat = SuratKeluar::findOrFail($id);

        if ($surat->file && Storage::disk('public')->exists($surat->file)) {
            Storage::disk('public')->delete($surat->file);
        }

        $surat->delete();

        return redirect()->route('admin.surat-keluar.index')
                         ->with('success', 'Surat keluar berhasil dihapus.');
    }

    // 8. Preview File PDF Upload-an
    public function previewPdf($id)
    {
        $surat = SuratKeluar::findOrFail($id);

        if (!$surat->file || !Storage::disk('public')->exists($surat->file)) {
            abort(404, 'File PDF tidak ditemukan.');
        }

        $path = storage_path('app/public/' . $surat->file);
        $pdfContent = file_get_contents($path);
        $pdfBase64 = base64_encode($pdfContent);

        return view('admin.surat.surat_keluar.preview', compact('pdfBase64', 'surat'));
    }

    // 9. Cetak Rekap dengan Filter (Preview Base64)
public function cetakPdf(Request $request)
{
    $query = SuratKeluar::query();

    // 1. Filter berdasarkan Tahun (WAJIB jika ingin data per tahun)
    if ($request->filled('tahun')) {
        $query->whereYear('tanggal_surat', $request->tahun);
    }

    // 2. Filter berdasarkan Bulan
    if ($request->filled('bulan')) {
        $query->whereMonth('tanggal_surat', $request->bulan);
    }

    // 3. Filter berdasarkan Hari (Tanggal Spesifik)
    if ($request->filled('hari')) {
        $query->whereDay('tanggal_surat', $request->hari);
    }

    // Ambil data hasil filter
    $suratKeluar = $query->orderBy('tanggal_surat', 'desc')->get();
    
    // 4. Ambil Tahun Ajaran (Hanya untuk keperluan TEXT JUDUL di header PDF)
    // Jika user pilih Tahun Ajaran di dropdown, kita ambil namanya agar tampil di PDF
    $tahunAktif = \App\Models\TahunAjaran::find($request->tahun_ajaran_id) ?? 
                  \App\Models\TahunAjaran::where('aktif', 1)->first();

    // Render ke View PDF
    $view = view('admin.surat.surat_keluar.cetak', compact('suratKeluar', 'tahunAktif'));
    
    // Konfigurasi DomPDF
    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($view->render())
                ->setPaper('a4', 'potrait');
    
    // Output ke Preview Base64
    $pdfBase64 = base64_encode($pdf->output());
    return view('admin.absen.preview', compact('pdfBase64'));
}
}