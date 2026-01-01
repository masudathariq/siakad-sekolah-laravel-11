<?php

namespace App\Exports;

use App\Models\Rombel;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RombelExport implements FromCollection, WithHeadings
{
    protected $rombel;

    public function __construct(Rombel $rombel)
    {
        $this->rombel = $rombel;
    }

    public function collection()
    {
        return $this->rombel->siswas
            ->sortBy('nama_siswa')
            ->map(function ($siswa) {

                $tanggalLahir = $siswa->tanggal_lahir
                    ? Carbon::parse($siswa->tanggal_lahir)
                    : null;

                return [
                    'nisn'           => $siswa->nisn,
                    'nis'            => $siswa->nis,
                    'nama_siswa'     => $siswa->nama_siswa,
                    'tempat_lahir'   => $siswa->tempat_lahir,
                    'tanggal_lahir'  => $tanggalLahir
                        ? $tanggalLahir->format('Y-m-d')
                        : '',
                    'jenis_kelamin'  => $siswa->jenis_kelamin, // L / P
                    'ayah'           => $siswa->ayah ?? '',
                    'ibu'            => $siswa->ibu ?? '',
                    'wali'           => $siswa->wali ?? '',
                    'alamat'         => $siswa->alamat ?? '',
                    'sekolah_asal'   => $siswa->sekolah_asal ?? '',
                    'umur'           => $tanggalLahir
                        ? $tanggalLahir->age
                        : '',
                ];
            });
    }

    public function headings(): array
    {
        return [
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
            'sekolah_asal',
            'umur',
        ];
    }
}
