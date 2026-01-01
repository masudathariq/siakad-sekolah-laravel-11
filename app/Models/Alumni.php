<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alumni extends Model
{
    protected $fillable = [
        'nisn',
        'nis',
        'nama_siswa',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'ayah',
        'ibu',
        'wali',
        'alamat',
        'sekolah_asal',
        'rombel_id',
        'tahun_ajaran_id',
    ];


        // CAST tanggal_lahir menjadi instance Carbon
    protected $casts = [
        'tanggal_lahir' => 'date',
    ];
    public function rombel()
    {
        return $this->belongsTo(Rombel::class);
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id');
    }
}
