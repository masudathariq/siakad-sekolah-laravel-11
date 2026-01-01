<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rombel extends Model
{
    protected $fillable = [
        'tahun_ajaran_id',
        'tingkat_id',
        'kode_kelas',
        'nama_kelas',
        'wali_kelas_id',
        'jenis_rombel',
    ];

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }

    public function tingkat()
    {
        return $this->belongsTo(Tingkat::class);
    }


    public function siswas()
    {
        return $this->hasMany(Siswa::class);
    }

    public function waliKelas()
    {
        return $this->belongsTo(Guru::class, 'wali_kelas_id');
    }

    public function rekapAbsensis()
{
    return $this->hasMany(RekapAbsensi::class);
}



    


}
