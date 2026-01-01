<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Surat Masuk</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 1.2cm;
        }
        body { 
            font-family: 'Arial', Helvetica, sans-serif; 
            font-size: 11px; 
            color: #000; 
            margin: 0;
            line-height: 1.5;
        }

        /* ===== KOP SURAT ===== */
        .kop-container { text-align: center; margin-bottom: 10px; }
        .kop-img { width: 100%; display: block; }
        .line-double {
            border-bottom: 3px solid #000;
            border-top: 1px solid #000;
            height: 2px;
            margin-top: 3px;
            margin-bottom: 15px;
        }

        /* ===== JUDUL LAPORAN ===== */
        .judul-container {
            text-align: center;
            margin-bottom: 20px;
        }
        .judul-main {
            font-size: 17px;
            font-weight: bold;
            text-decoration: underline;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .judul-sub {
            font-size: 13px;
            font-weight: bold;
            margin-top: 5px;
        }

        /* ===== TABEL FORMAL SOLID ===== */
        table.data-table { 
            border-collapse: collapse; 
            width: 100%; 
            table-layout: fixed;
            border: 2px solid #000;
        }

        th { 
            background-color: #00d2ff !important; /* Biru Laut Solid */
            color: #000 !important; 
            font-size: 10px;
            font-weight: bold;
            padding: 12px 5px;
            border: 1px solid #000;
            text-transform: uppercase;
            -webkit-print-color-adjust: exact;
        }

        td { 
            padding: 9px 5px; 
            border: 1px solid #000; 
            vertical-align: top;
            word-wrap: break-word;
        }

        /* Zebra Striping Halus */
        tr:nth-child(even) { 
            background-color: #f2faff; 
        }

        /* ===== UKURAN KOLOM ===== */
        .col-no { width: 30px; text-align: center; }
        .col-nomor { width: 135px; font-weight: bold; font-family: 'Courier New', monospace; }
        .col-tgl { width: 75px; text-align: center; }
        .col-pengirim { width: 125px; }
        .col-perihal { width: auto; font-style: italic; }
        .col-sifat { width: 65px; text-align: center; }

        .text-center { text-align: center; }
        .text-right { text-align: right; font-size: 9px; margin-bottom: 5px; color: #333; }
    </style>
</head>
<body>

<div class="kop-container">
    <img src="{{ public_path('images/header_kop.jpg') }}" class="kop-img">
    <div class="line-double"></div>
</div>

<div class="text-right">Dicetak: {{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i') }}</div>

<div class="judul-container">
    <div class="judul-main">DAFTAR AGENDA SURAT MASUK</div>
    <div class="judul-sub">MTSS MUHAMMADIYAH 1 NATAR</div>
    <div style="font-size: 12px; font-weight: bold;">Tahun Pelajaran {{ $tahunAktif->nama ?? '-' }}</div>
</div>

<table class="data-table">
    <thead>
        <tr>
            <th class="col-no">No</th>
            <th class="col-nomor">Nomor Surat</th>
            <th class="col-tgl">Tgl Surat</th>
            <th class="col-tgl">Tgl Terima</th>
            <th class="col-pengirim">Asal Pengirim</th>
            <th class="col-perihal">Perihal / Isi Ringkas</th>
            <th class="col-sifat">Sifat</th>
        </tr>
    </thead>
    <tbody>
        @forelse($suratMasuk as $index => $surat)
        <tr>
            <td class="text-center">{{ $index + 1 }}</td>
            <td class="col-nomor">{{ $surat->nomor_surat }}</td>
            <td class="text-center">
                {{ \Carbon\Carbon::parse($surat->tanggal_surat)->translatedFormat('d/m/Y') }}
            </td>
            <td class="text-center">
                {{ \Carbon\Carbon::parse($surat->tanggal_diterima)->translatedFormat('d/m/Y') }}
            </td>
            <td>{{ $surat->pengirim }}</td>
            <td class="col-perihal">{{ $surat->perihal }}</td>
            <td class="text-center" style="font-size: 9px; font-weight: bold;">
                {{ strtoupper($surat->sifat) }}
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7" style="text-align:center; padding: 40px; color: #666; font-style: italic;">
                -- Belum ada rekaman data surat masuk --
            </td>
        </tr>
        @endforelse
    </tbody>
</table>

<div style="margin-top: 40px; width: 100%;">
    <table style="border: none !important; width: 100%;">
        <tr style="background: none !important;">
            <td style="border: none !important; width: 65%;"></td>
            <td style="border: none !important; text-align: center; width: 35%;">
                Natar, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>
                <strong>Kepala Madrasah,</strong>
                <br><br><br><br><br>
                <strong><u>{{ $kepalaMadrasah->nama ?? '( ____________________ )' }}</u></strong><br>
                NIP. {{ $kepalaMadrasah->nip ?? '...........................' }}
            </td>
        </tr>
    </table>
</div>

</body>
</html>