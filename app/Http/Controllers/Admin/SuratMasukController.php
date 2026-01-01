<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SuratMasuk;
use App\Models\TahunAjaran;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class SuratMasukController extends Controller
{
    // Menampilkan daftar surat masuk
    public function index(Request $request)
    {
        $query = SuratMasuk::query();

        // Filter pencarian (q)
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function($s) use ($q) {
                $s->where('nomor_surat', 'like', "%$q%")
                  ->orWhere('pengirim', 'like', "%$q%")
                  ->orWhere('perihal', 'like', "%$q%");
            });
        }

        // Ambil list tahun ajaran untuk dropdown di blade
        $listTahunAjaran = TahunAjaran::orderBy('nama', 'desc')->get();

        // Pagination
        $suratMasuk = $query->orderBy('tanggal_diterima', 'desc')->paginate(20);
        
        // Mempertahankan query string saat pindah halaman pagination
        $suratMasuk->appends(['q' => $request->q]);

        return view('admin.surat.surat_masuk.index', compact('suratMasuk', 'listTahunAjaran'));
    }

    // --- (Fungsi create, store, show, edit, update, destroy tetap sama seperti sebelumnya) ---

    public function create()
    {
        return view('admin.surat.surat_masuk.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_surat' => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'tanggal_diterima' => 'required|date',
            'pengirim' => 'required|string|max:255',
            'perihal' => 'required|string|max:255',
            'sifat' => 'required|string|max:50',
            'file' => 'nullable|mimes:pdf|max:2048',
        ]);

        $data = $request->except('file');
        if ($request->hasFile('file')) {
            $data['file'] = $request->file('file')->store('surat_masuk', 'public');
        }

        SuratMasuk::create($data);
        return redirect()->route('admin.surat-masuk.index')->with('success', 'Surat masuk berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $surat = SuratMasuk::findOrFail($id);
        return view('admin.surat.surat_masuk.edit', compact('surat'));
    }

    public function update(Request $request, $id)
    {
        $surat = SuratMasuk::findOrFail($id);
        $data = $request->except('file');

        if ($request->hasFile('file')) {
            if ($surat->file && Storage::disk('public')->exists($surat->file)) {
                Storage::disk('public')->delete($surat->file);
            }
            $data['file'] = $request->file('file')->store('surat_masuk', 'public');
        }

        $surat->update($data);
        return redirect()->route('admin.surat-masuk.index')->with('success', 'Surat masuk berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $surat = SuratMasuk::findOrFail($id);
        if ($surat->file && Storage::disk('public')->exists($surat->file)) {
            Storage::disk('public')->delete($surat->file);
        }
        $surat->delete();
        return redirect()->route('admin.surat-masuk.index')->with('success', 'Surat masuk berhasil dihapus.');
    }

    // Preview File PDF
    public function previewPdf($id)
    {
        $surat = SuratMasuk::findOrFail($id);
        if (!$surat->file || !Storage::disk('public')->exists($surat->file)) {
            abort(404, 'File PDF tidak ditemukan.');
        }
        $path = storage_path('app/public/' . $surat->file);
        $pdfBase64 = base64_encode(file_get_contents($path));
        return view('admin.surat.surat_masuk.preview', compact('pdfBase64', 'surat'));
    }

    /**
     * Cetak Rekap Surat Masuk dengan Filter Tanggal
     */
    public function cetakSemua(Request $request)
    {
        $query = SuratMasuk::query();

        // Filter Berdasarkan Tanggal Diterima (Menggunakan data yang sudah ada di DB)
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_diterima', $request->tahun);
        }
        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_diterima', $request->bulan);
        }
        if ($request->filled('hari')) {
            $query->whereDay('tanggal_diterima', $request->hari);
        }

        $suratMasuk = $query->orderBy('tanggal_diterima', 'desc')->get();
        
        // Ambil info Tahun Ajaran untuk Judul Header di PDF
        $tahunAktif = TahunAjaran::find($request->tahun_ajaran_id) ?? 
                      TahunAjaran::where('aktif', 1)->first();

        // Render HTML ke PDF
        $view = view('admin.surat.surat_masuk.cetak_all', compact('suratMasuk', 'tahunAktif'));
        
        // Gunakan landscape agar tabel yang lebar tidak terpotong
        $pdf = Pdf::loadHTML($view->render())->setPaper('a4', 'potrait');

        $pdfBase64 = base64_encode($pdf->output());

        return view('admin.absen.preview', compact('pdfBase64'));
    }
}