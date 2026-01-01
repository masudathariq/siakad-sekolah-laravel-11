<?php

namespace App\Imports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class SiswaImport implements ToModel, WithHeadingRow
{
    // Simpan daftar baris gagal
    public $failedRows = [];

    public function model(array $row)
    {
        try {
            $tanggal_lahir = null;
            if (!empty($row['tanggal_lahir'])) {
                $tanggal_lahir = is_numeric($row['tanggal_lahir'])
                    ? Date::excelToDateTimeObject($row['tanggal_lahir'])->format('Y-m-d')
                    : date('Y-m-d', strtotime($row['tanggal_lahir']));
            }

            $jk = strtoupper($row['jenis_kelamin'] ?? '');

            // Validasi jenis kelamin
            if (!in_array($jk, ['L', 'P'])) {
                $this->failedRows[] = [
                    'nisn' => $row['nisn'] ?? '-',
                    'nama' => $row['nama_siswa'] ?? '-',
                    'attribute' => 'jenis_kelamin',
                    'errors' => ['Jenis kelamin harus L atau P']
                ];
                return null; // skip baris ini
            }

            return Siswa::updateOrCreate(
                ['nisn' => $row['nisn']],
                [
                    'nis'           => $row['nis'],
                    'nama_siswa'    => $row['nama_siswa'],
                    'tempat_lahir'  => $row['tempat_lahir'] ?? null,
                    'tanggal_lahir' => $tanggal_lahir,
                    'jenis_kelamin' => $jk,
                    'ayah'          => $row['ayah'] ?? null,
                    'ibu'           => $row['ibu'] ?? null,
                    'wali'          => $row['wali'] ?? null,
                    'alamat'        => $row['alamat'] ?? null,
                    'sekolah_asal'  => $row['sekolah_asal'] ?? null,
                ]
            );

        } catch (\Exception $e) {
            $this->failedRows[] = [
                'nisn' => $row['nisn'] ?? '-',
                'nama' => $row['nama_siswa'] ?? '-',
                'attribute' => 'general',
                'errors' => [$e->getMessage()]
            ];
            return null;
        }
    }
}
