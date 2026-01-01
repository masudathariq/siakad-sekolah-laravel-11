<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tingkat extends Model
{
    protected $fillable = ['nama', 'urutan'];

    public function rombels()
{
    return $this->hasMany(Rombel::class);
}

}


