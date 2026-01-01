<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Guru extends Model
{
    protected $fillable = [
        'id_guru',
        'nama',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'nbm',
        'nuptk',
        'status_kepegawaian',
        'pendidikan',
        'jurusan',
        'status_sertifikasi',
        'status',
        'tmt',
        'ditugaskan_sebagai',
        'waka_bidang'
    ];

    protected $casts = [
        'tmt' => 'date',
        'tanggal_lahir' => 'date',
        'status' => 'boolean',
    ];

    // 🔥 HITUNG MASA KERJA (TAHUN • BULAN • HARI)
    public function getMasaKerjaAttribute()
    {
        if (!$this->tmt) {
            return '-';
        }

        $diff = $this->tmt->diff(now());

        return "{$diff->y} Tahun {$diff->m} Bulan {$diff->d} Hari";
    }

    // Relasi ke Jabatan
    public function jabatans()
    {
        return $this->hasMany(GuruJabatan::class, 'guru_id');
    }

    // Relasi ke Mapel
    public function mapels()
    {
        return $this->hasMany(GuruMapel::class, 'guru_id');
    }
}
