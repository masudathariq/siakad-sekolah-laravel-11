<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Siswa extends Model
{
    protected $table = 'siswas';

    // Primary Key NISN
    protected $primaryKey = 'nisn';
    public $incrementing = false;
    protected $keyType = 'string';

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
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function rombel()
    {
        return $this->belongsTo(Rombel::class);
    }

    public function getUmurAttribute()
    {
        if (!$this->tanggal_lahir) {
            return null;
        }

        return Carbon::parse($this->tanggal_lahir)->age;
    }

    public function rekapAbsensis()
{
    return $this->hasMany(RekapAbsensi::class, 'siswa_nisn', 'nisn');
}



}
