<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekapAbsensi extends Model
{
    use HasFactory;

    protected $table = 'rekap_absensis';

    protected $fillable = [
        'siswa_nisn',
        'rombel_id',
        'tahun_ajaran_id',
        'bulan',
        'tahun',
        'hadir',
        'izin',
        'sakit',
        'alpha',
        'bolos',
        'hari_efektif',
    ];

    /* ======================
     * RELASI
     * ====================== */

    // Rekap → Siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_nisn', 'nisn');
    }

    // Rekap → Rombel
    public function rombel()
    {
        return $this->belongsTo(Rombel::class);
    }

    // Rekap → Tahun Ajaran
    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }
}
