<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rombel;

class AbsenTemplateController extends Controller
{
    public function cetak(Rombel $rombel)
    {
        $rombel->load('siswas', 'tingkat', 'waliKelas');
        $bulan = date('m');
        $tahun = date('Y');
        $daysInMonth = \Carbon\Carbon::create($tahun, $bulan)->daysInMonth;

        return view('admin.absen.cetak', compact('rombel','bulan','tahun','daysInMonth'));
    }
}
