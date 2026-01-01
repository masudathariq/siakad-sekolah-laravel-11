<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuruJabatan extends Model
{
    protected $fillable = [
        'guru_id',
        'jabatan',
        'bidang'
    ];

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }
}
