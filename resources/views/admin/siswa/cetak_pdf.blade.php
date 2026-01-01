<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Biodata Siswa - {{ $siswa->nama_siswa }}</title>
    <style>
        @page { 
            size: A4 portrait; 
            margin: 1.5cm; 
        }

        body { 
            font-family: 'Times New Roman', Times, serif; 
            color: #1e293b; 
            line-height: 1.6;
            font-size: 11pt;
            margin: 0;
            padding: 0;
        }

        /* Kop Surat - Mencegah gambar tertekan */
        .kop-surat {
            width: 100%;
            text-align: center;
            margin-bottom: 20px;
        }
        .kop-surat img {
            width: 100%;
            height: auto; /* Rasio gambar tetap terjaga */
            display: block;
        }

        /* Judul Utama */
        .judul-dokumen {
            text-align: center;
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 25px;
            text-transform: uppercase;
            font-size: 14pt;
            color: #000;
        }

        /* Section Title dengan Blue Gradient */
        .section-title {
            background: linear-gradient(90deg, #1e3a8a 0%, #3b82f6 100%);
            color: #ffffff;
            padding: 5px 12px;
            font-weight: bold;
            font-size: 10pt;
            text-transform: uppercase;
            margin-top: 20px;
            margin-bottom: 10px;
            border-radius: 2px;
        }

        /* Tabel Data Tanpa Border (Invisible) */
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .info-table td {
            padding: 5px 0;
            vertical-align: top;
            border: none;
        }

        .col-label {
            width: 30%;
            color: #475569;
        }

        .col-colon {
            width: 3%;
            text-align: center;
        }

        .col-value {
            width: 67%;
            font-weight: bold;
            color: #000;
        }

        /* Layout Bawah: Foto dan Tanda Tangan */
        .footer-layout {
            margin-top: 40px;
            width: 100%;
        }

        /* Tabel untuk mengatur posisi Foto (Kiri) dan Tanda Tangan (Kanan) */
        .table-footer {
            width: 100%;
            border-collapse: collapse;
        }

        .photo-box {
            width: 113.38px; /* 3cm */
            height: 151.18px; /* 4cm */
            border: 1px solid #000;
            text-align: center;
            position: relative;
        }

        .photo-text {
            margin-top: 60px;
            font-size: 9pt;
            color: #64748b;
        }

        .signature-cell {
            text-align: right;
            vertical-align: top;
            padding-right: 20px;
        }

        .signature-wrapper {
            display: inline-block;
            text-align: center;
            width: 250px;
        }

        .signature-space {
            height: 70px;
        }
    </style>
</head>
<body>

    @php
        // Pastikan locale Carbon diatur ke Bahasa Indonesia
        \Carbon\Carbon::setLocale('id');
    @endphp

    <div class="kop-surat">
        @include('admin.pdf.header')
    </div>

    <div class="judul-dokumen">
        BIODATA SISWA
    </div>

    <div class="section-title">A. IDENTITAS PRIBADI</div>
    <table class="info-table">
        <tr>
            <td class="col-label">Nama Lengkap</td>
            <td class="col-colon">:</td>
            <td class="col-value">{{ $siswa->nama_siswa }}</td>
        </tr>
        <tr>
            <td class="col-label">NISN / NIS</td>
            <td class="col-colon">:</td>
            <td class="col-value">{{ $siswa->nisn }} / {{ $siswa->nis ?? '-' }}</td>
        </tr>
        <tr>
            <td class="col-label">Tempat, Tanggal Lahir</td>
            <td class="col-colon">:</td>
            <td class="col-value">{{ $siswa->tempat_lahir }}, {{ $siswa->tanggal_lahir ? $siswa->tanggal_lahir->translatedFormat('d F Y') : '-' }}</td>
        </tr>
        <tr>
            <td class="col-label">Jenis Kelamin</td>
            <td class="col-colon">:</td>
            <td class="col-value">{{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
        </tr>
        <tr>
            <td class="col-label">Alamat</td>
            <td class="col-colon">:</td>
            <td class="col-value">{{ $siswa->alamat ?? '-' }}</td>
        </tr>
        <tr>
            <td class="col-label">Sekolah Asal</td>
            <td class="col-colon">:</td>
            <td class="col-value">{{ $siswa->sekolah_asal ?? '-' }}</td>
        </tr>
    </table>

    <div class="section-title">B. KETERANGAN ORANG TUA</div>
    <table class="info-table">
        <tr>
            <td class="col-label">Nama Ayah</td>
            <td class="col-colon">:</td>
            <td class="col-value">{{ $siswa->ayah ?? '-' }}</td>
        </tr>
        <tr>
            <td class="col-label">Nama Ibu</td>
            <td class="col-colon">:</td>
            <td class="col-value">{{ $siswa->ibu ?? '-' }}</td>
        </tr>
        <tr>
            <td class="col-label">Nama Wali</td>
            <td class="col-colon">:</td>
            <td class="col-value">{{ $siswa->wali ?? '-' }}</td>
        </tr>
    </table>

    <div class="footer-layout">
        <table class="table-footer">
            <tr>
                <td style="width: 3cm;">
                    <div class="photo-box">
                        <div class="photo-text">PAS FOTO<br>3 X 4</div>
                    </div>
                </td>
                <td class="signature-cell">
                    <div class="signature-wrapper">
                        <div>Natar, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</div>
                        <div>Orang Tua / Wali Murid,</div>
                        <div class="signature-space"></div>
                        <div style="font-weight: bold;">( __________________________ )</div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

</body>
</html>