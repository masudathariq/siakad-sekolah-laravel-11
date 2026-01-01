<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Cetak Rombel - {{ $rombel->nama_kelas }}</title>
    <style>
        @page { 
            size: A4 portrait; 
            margin: 1.2cm; 
        }
        body {
            font-family: 'Helvetica', Arial, sans-serif; /* Font lebih modern */
            font-size: 11px;
            color: #1a202c;
            margin: 0;
            padding: 0;
            line-height: 1.5;
        }

        /* Kop Surat Proporsional */
        .header {
            width: 100%;
            margin-bottom: 25px;
        }
        .header img {
            width: 100%;
            height: auto;
            display: block;
        }

        .judul-container {
            text-align: center;
            margin-bottom: 25px;
        }
        .judul-utama {
            font-weight: 800;
            font-size: 16px;
            color: #000;
            margin: 0;
        }
        .sub-judul {
            font-size: 12px;
            color: #4a5568;
            margin-top: 5px;
        }

        /* Section Header: Minimalis dengan Underline Gradient */
        .section-header {
            margin-top: 20px;
            margin-bottom: 10px;
            padding-bottom: 3px;
            border-bottom: 2px solid #1e3a8a; /* Garis bawah biru tegas */
            width: fit-content;
        }
        .section-header h4 {
            margin: 0;
            color: #000;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Info Table */
        .info-table {
            width: 100%;
            margin-bottom: 15px;
        }
        .info-table td {
            padding: 4px 0;
        }
        .label { width: 20%; color: #4a5568; }
        .sep { width: 3%; text-align: center; }
        .val { width: 77%; font-weight: 700; color: #000; }

        /* Data Table: Tanpa Warna Latar Header (Hanya Garis) */
        .data-table {
            width: 100%;
            border-collapse: collapse;
        }
        .data-table th {
            border-top: 2px solid #000;
            border-bottom: 2px solid #000;
            padding: 10px 5px;
            text-align: left;
            font-size: 10px;
            text-transform: uppercase;
        }
        .data-table td {
            border-bottom: 1px solid #e2e8f0;
            padding: 8px 5px;
            font-size: 10px;
        }

        /* Footer */
        .footer-section {
            margin-top: 40px;
        }
        .sign-box {
            float: right;
            width: 250px;
            text-align: center;
        }
        .space { height: 70px; }
    </style>
</head>
<body>

<div class="header">
    <img src="{{ public_path('images/header_kop.jpg') }}" alt="Header">
</div>

<div class="judul-container">
    <h1 class="judul-utama">LAPORAN DATA ROMBONGAN BELAJAR</h1>
    <div class="sub-judul">Tahun Pelajaran {{ $rombel->tahunAjaran->nama }}</div>
</div>

<div class="section-header">
    <h4>I. Profil Kelas</h4>
</div>
<table class="info-table">
        <tr>
        <td class="label">Tingkat</td>
        <td class="sep">:</td>
        <td class="val">{{ $rombel->tingkat?->nama ?? '-' }}</td>
    </tr>
    <tr>
        <td class="label">Nama Kelas</td>
        <td class="sep">:</td>
        <td class="val">{{ $rombel->nama_kelas }} ({{ $rombel->kode_kelas }})</td>
    </tr>
    <tr>
        <td class="label">Wali Kelas</td>
        <td class="sep">:</td>
        <td class="val">{{ $rombel->waliKelas?->nama ?? '-' }}</td>
    </tr>
    <tr>
        <td class="label">Total Siswa</td>
        <td class="sep">:</td>
        <td class="val">
            {{ $rombel->siswas->count() }} Peserta Didik 
            (Laki-laki: {{ $rombel->siswas->where('jenis_kelamin','L')->count() }}, 
            Perempuan: {{ $rombel->siswas->where('jenis_kelamin','P')->count() }})
        </td>
    </tr>
</table>


<div class="section-header">
    <h4>II. Daftar Peserta Didik</h4>
</div>
<table class="data-table">
    <thead>
        <tr>
            <th width="30">NO</th>
            <th width="100">NIS / NISN</th>
            <th>NAMA LENGKAP</th>
            <th width="40">JK</th>
            <th>TTL</th>
            <th width="60">UMUR</th>
        </tr>
    </thead>
    <tbody>
        @foreach($rombel->siswas->sortBy('nama_siswa') as $siswa)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $siswa->nis ?? '-' }} / {{ $siswa->nisn ?? '-' }}</td>
            <td><strong>{{ strtoupper($siswa->nama_siswa) }}</strong></td>
            <td>{{ $siswa->jenis_kelamin }}</td>
            <td>{{ $siswa->tempat_lahir }}, {{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->locale('id')->isoFormat('DD MMM YYYY') : '-' }}</td>
            <td>{{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->age . ' Thn' : '-' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="footer-section">
    <div class="sign-box">
        <p>Natar, {{ \Carbon\Carbon::now()->locale('id')->isoFormat('DD MMMM YYYY') }}</p>
        <p>Wali Kelas,</p>
        <div class="space"></div>
        <p><strong>{{ $rombel->waliKelas?->nama ?? '-' }}</strong></p>
        <p style="font-size: 9px; color: #4a5568;">NUPTK. {{ $rombel->waliKelas?->nuptk ?? '-' }}</p>
    </div>
    <div style="clear: both;"></div>
</div>

</body>
</html>