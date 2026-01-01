<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratMasuk extends Model
{
    use HasFactory;

    protected $table = 'surat_masuk';

    protected $fillable = [
        'nomor_surat', 
        'tanggal_surat', 
        'tanggal_diterima',
        'pengirim',
        'perihal',
        'sifat',
        'kategori',
        'tujuan',
        'keterangan',
        'file'
    ];
}
