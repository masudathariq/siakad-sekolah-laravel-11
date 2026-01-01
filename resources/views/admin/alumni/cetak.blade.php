<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Alumni</title>

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10px;
            color: #000;
        }

        .kop {
            width: 100%;
            margin-bottom: 10px;
        }

        h2 {
            text-align: center;
            font-size: 14px;
            margin: 5px 0 10px 0;
            text-transform: uppercase;
        }

        .info {
            margin-bottom: 8px;
            font-size: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #000;
            padding: 4px;
            vertical-align: top;
        }

        th {
            background-color: #0000FF;
            color: #fff;
            text-align: center;
            font-size: 9px;
        }

        td {
            font-size: 9px;
        }

        .center {
            text-align: center;
        }

        .uppercase {
            text-transform: uppercase;
        }
    </style>
</head>
<body>

{{-- KOP SURAT --}}
<img src="{{ public_path('images/header_kop.jpg') }}" class="kop">

<h2>DATA ALUMNI MTs MUHAMMADIYAH 1 NATAR</h2>

<div class="info">
    @if(isset($tahunAjaran))
        <strong>Tahun Ajaran :</strong> {{ $tahunAjaran->nama }}
    @else
        <strong>Tahun Ajaran :</strong> Semua
    @endif
</div>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>NISN</th>
            <th>NIS</th>
            <th>Nama Siswa</th>
            <th>JK</th>
            <th>Tempat Lahir</th>
            <th>Tanggal Lahir</th>
            <th>Ayah</th>
            <th>Ibu</th>
            <th>Wali</th>
            <th>Alamat</th>
            <th>Sekolah Asal</th>
            <th>Rombel Terakhir</th>
            <th>Tahun Lulus</th>
        </tr>
    </thead>
    <tbody>
        @forelse($alumnis as $a)
        <tr>
            <td class="center">{{ $loop->iteration }}</td>
            <td class="center">{{ $a->nisn }}</td>
            <td class="center">{{ $a->nis ?? '-' }}</td>
            <td class="uppercase">{{ $a->nama_siswa }}</td>
            <td class="center">{{ $a->jenis_kelamin }}</td>
            <td>{{ $a->tempat_lahir ?? '-' }}</td>
            <td class="center">
                {{ $a->tanggal_lahir ? \Carbon\Carbon::parse($a->tanggal_lahir)->format('d-m-Y') : '-' }}
            </td>
            <td>{{ $a->ayah ?? '-' }}</td>
            <td>{{ $a->ibu ?? '-' }}</td>
            <td>{{ $a->wali ?? '-' }}</td>
            <td>{{ $a->alamat ?? '-' }}</td>
            <td>{{ $a->sekolah_asal ?? '-' }}</td>
            <td class="center">{{ $a->rombel->kode_kelas ?? '-' }} ( {{ $a->rombel->nama_kelas ?? '-' }} )</td>
            <td class="center">{{ $a->tahunAjaran->nama ?? '-' }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="14" class="center">
                Tidak ada data alumni
            </td>
        </tr>
        @endforelse
    </tbody>
</table>

</body>
</html>
