<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuruMapel extends Model
{
    protected $fillable = [
        'guru_id',
        'nama_mapel'
    ];

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }
}

