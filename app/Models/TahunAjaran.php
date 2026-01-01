<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    protected $fillable = ['nama', 'aktif'];

    public function rekapAbsensis()
{
    return $this->hasMany(RekapAbsensi::class);
}
}


