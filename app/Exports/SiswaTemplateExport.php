<?php


namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;

class SiswaTemplateExport implements FromArray
{
    public function array(): array
    {
        return [
            [
                'nisn',
                'nis',
                'nama_siswa',
                'tempat_lahir',
                'tanggal_lahir',
                'jenis_kelamin',
                'ayah',
                'ibu',
                'wali',
                'alamat',
                'sekolah_asal'
            ],
            [
                '1234567890',
                '1001',
                'CONTOH SISWA',
                'Lampung Selatan',
                '2010-05-12',
                'L',
                'Nama Ayah',
                'Nama Ibu',
                '',
                'Jl. Contoh No. 1',
                'SD Negeri 1 Natar'
            ]
        ];
    }
}
