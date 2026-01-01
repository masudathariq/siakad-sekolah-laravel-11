<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Surat Keluar</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 1.2cm;
        }
        body { 
            font-family: 'Arial', sans-serif; 
            font-size: 11px; 
            color: #000; 
            margin: 0;
            line-height: 1.5;
        }

        /* ===== KOP SURAT ===== */
        .kop-container { text-align: center; margin-bottom: 15px; }
        .kop-img { width: 100%; display: block; }
        .line-double {
            border-bottom: 3px solid #000;
            border-top: 1px solid #000;
            height: 2px;
            margin-top: 3px;
        }

        /* ===== JUDUL LAPORAN ===== */
        .judul-container {
            text-align: center;
            margin: 20px 0;
        }
        .judul-main {
            font-size: 17px;
            font-weight: bold;
            text-decoration: underline;
            letter-spacing: 1px;
        }
        .judul-sub {
            font-size: 13px;
            font-weight: bold;
            margin-top: 5px;
            color: #333;
        }

        /* ===== TABEL FORMAL ===== */
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
            padding: 12px 6px;
            border: 1px solid #000;
            text-transform: uppercase;
            -webkit-print-color-adjust: exact;
        }

        td { 
            padding: 9px 6px; 
            border: 1px solid #000; 
            vertical-align: top;
            word-wrap: break-word;
        }

        /* Zebra Striping Halus */
        tr:nth-child(even) { background-color: #f2faff; }

        /* ===== KOLOM ===== */
        .col-no { width: 30px; text-align: center; }
        .col-nomor { width: 150px; font-weight: bold; font-family: 'Courier New', monospace; }
        .col-tgl { width: 85px; text-align: center; }
        .col-tujuan { width: 140px; }
        .col-perihal { width: auto; }
        .col-sifat { width: 75px; text-align: center; }

        .text-center { text-align: center; }
        .text-italic { font-style: italic; color: #444; }
        .meta-data { text-align: right; font-size: 9px; margin-bottom: 5px; }

        /* ===== FOOTER TANDA TANGAN ===== */
        .footer-table {
            margin-top: 40px;
            width: 100%;
            border: none !important;
        }
        .footer-table td { border: none !important; padding: 0; }
        .signature-box { text-align: center; width: 35%; }
    </style>
</head>
<body>

<div class="kop-container">
    <img src="{{ public_path('images/header_kop.jpg') }}" class="kop-img">
    <div class="line-double"></div>
</div>

<div class="meta-data">
    ID Dokumen: REKAP-SK/{{ date('Y/m') }} | Dicetak: {{ date('d/m/Y H:i') }}
</div>

<div class="judul-container">
    <div class="judul-main">DAFTAR AGENDA SURAT KELUAR</div>
    <div class="judul-sub">
        MTSS MUHAMMADIYAH 1 NATAR<br>
        Tahun Pelajaran {{ $tahunAktif->nama ?? '-' }}
    </div>
</div>

<table class="data-table">
    <thead>
        <tr>
            <th class="col-no">No</th>
            <th class="col-nomor">Nomor Surat</th>
            <th class="col-tgl">Tgl Surat</th>
            <th class="col-tujuan">Tujuan & Alamat</th>
            <th class="col-perihal">Perihal / Perkara</th>
            <th class="col-sifat">Sifat</th>
        </tr>
    </thead>
    <tbody>
        @forelse($suratKeluar as $index => $surat)
        <tr>
            <td class="text-center">{{ $index + 1 }}</td>
            <td class="col-nomor">{{ $surat->nomor_surat }}</td>
            <td class="text-center">
                {{ \Carbon\Carbon::parse($surat->tanggal_surat)->translatedFormat('d/m/Y') }}
            </td>
            <td>{{ $surat->tujuan }}</td>
            <td class="text-italic">{{ $surat->perihal }}</td>
            <td class="text-center">
                <span style="font-size: 9px; font-weight: bold;">{{ strtoupper($surat->sifat) }}</span>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="text-center" style="padding: 40px;">
                <em>-- Belum ada rekaman data surat keluar --</em>
            </td>
        </tr>
        @endforelse
    </tbody>
</table>

<table class="footer-table">
    <tr>
        <td style="width: 65%;"></td>
        <td class="signature-box">
            Natar, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>
            <strong>Kepala Madrasah,</strong>
            <br><br><br><br><br>
            <strong><u>{{ $kepalaMadrasah->nama ?? '( ____________________ )' }}</u></strong><br>
            NIP. {{ $kepalaMadrasah->nip ?? '...........................' }}
        </td>
    </tr>
</table>

</body>
</html>