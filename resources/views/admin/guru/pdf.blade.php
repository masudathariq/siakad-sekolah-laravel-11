<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profil Guru - {{ $guru->nama }}</title>
    <style>
        @page { margin: 1cm; }
        body { 
            font-family: 'Times New Roman', Times, serif; 
            font-size: 12px; 
            color: #1e293b; 
            line-height: 1.5;
            margin: 0;
            padding: 0;
        }

        /* Kop Surat */
        .kop-surat {
            width: 100%;
            margin-bottom: 20px;
            text-align: center;
        }
        .kop-surat img { width: 100%; display: block; }

        /* Judul Dokumen */
        .judul-dokumen {
            text-align: center;
            text-decoration: underline;
            text-transform: uppercase;
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 20px;
            color: #000;
        }

        /* Tabel Data Tanpa Border */
        .table-data {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .table-data td {
            padding: 5px 0;
            vertical-align: top;
            border: none;
        }
        .label { width: 30%; color: #475569; font-weight: 600; }
        .separator { width: 3%; text-align: center; font-weight: 600; }
        .value { width: 67%; font-weight: bold; color: #000; }

        /* Section Title */
        .section-title {
            background: linear-gradient(90deg, #1e3a8a 0%, #3b82f6 100%);
            color: #ffffff;
            padding: 6px 10px;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 11px;
            margin-top: 15px;
            border-radius: 2px;
        }

        /* Footer */
        .footer-note {
            margin-top: 40px;
            font-style: italic;
            font-size: 10px;
            color: #64748b;
            text-align: right;
            border-top: 1px solid #e2e8f0;
            padding-top: 10px;
        }
    </style>
</head>
<body>

    <div class="kop-surat">
        @include('admin.pdf.header')
    </div>

    <div class="judul-dokumen">
        BIODATA TENAGA PENDIDIK
    </div>

    @php
        \Carbon\Carbon::setLocale('id');
    @endphp

<div class="section-title">I. Identitas Personal</div>
<table class="table-data">
    <tr>
        <td class="label">ID Guru / Status Kepegawaian</td>
        <td class="separator">:</td>
        <td class="value">{{ $guru->id_guru }} / {{ $guru->status_kepegawaian == 'GTY' ? 'Tetap' : 'Tidak Tetap' }}</td>
    </tr>
    <tr>
        <td class="label">Nama Lengkap</td>
        <td class="separator">:</td>
        <td class="value">{{ $guru->nama }}</td>
    </tr>
    <tr>
        <td class="label">Jenis Kelamin</td>
        <td class="separator">:</td>
        <td class="value">{{ $guru->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
    </tr>
    <tr>
        <td class="label">Tempat, Tanggal Lahir</td>
        <td class="separator">:</td>
        <td class="value">
            {{ $guru->tempat_lahir ?? '-' }}, 
            {{ $guru->tanggal_lahir ? $guru->tanggal_lahir->translatedFormat('d F Y') : '-' }}
        </td>
    </tr>
    <tr>
        <td class="label">Pendidikan Terakhir</td>
        <td class="separator">:</td>
        <td class="value">{{ $guru->pendidikan ?? '-' }} ({{ $guru->jurusan ?? '-' }})</td>
    </tr>
    <tr>
        <td class="label">Tahun Masuk</td>
        <td class="separator">:</td>
        <td class="value">{{ $guru->tmt ? $guru->tmt->format('Y') : '-' }}</td>
    </tr>
    <tr>
        <td class="label">Email / No. HP</td>
        <td class="separator">:</td>
        <td class="value">{{ $guru->email ?? '-' }} / {{ $guru->no_hp ?? '-' }}</td>
    </tr>
</table>


    <div class="section-title">II. Legalitas & Sertifikasi</div>
    <table class="table-data">
        <tr>
            <td class="label">NBM / NUPTK</td>
            <td class="separator">:</td>
            <td class="value">{{ $guru->nbm ?? '-' }} / {{ $guru->nuptk ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Status Sertifikasi</td>
            <td class="separator">:</td>
            <td class="value">{{ $guru->status_sertifikasi ? strtoupper($guru->status_sertifikasi) : 'BELUM SERTIFIKASI' }}</td>
        </tr>
    </table>

    <div class="section-title">III. Jabatan & Tugas Mengajar</div>
    <table class="table-data">
        <tr>
            <td class="label">Jabatan Struktural</td>
            <td class="separator">:</td>
            <td class="value">
                @forelse($guru->jabatans as $jab)
                    • {{ ucwords(str_replace('_',' ',$jab->jabatan)) }} {{ $jab->bidang ? '('.$jab->bidang.')' : '' }}<br>
                @empty
                    -
                @endforelse
            </td>
        </tr>
        <tr>
            <td class="label">Mata Pelajaran Diampu</td>
            <td class="separator">:</td>
            <td class="value">
                @forelse($guru->mapels as $mapel)
                    {{ $mapel->nama_mapel }}{{ !$loop->last ? ', ' : '' }}
                @empty
                    -
                @endforelse
            </td>
        </tr>
    </table>

    <div class="section-title">IV. Riwayat Pengabdian</div>
    <table class="table-data">
        <tr>
            <td class="label">TMT (Mulai Bertugas)</td>
            <td class="separator">:</td>
            <td class="value">{{ $guru->tmt ? $guru->tmt->translatedFormat('d F Y') : '-' }}</td>
        </tr>
        <tr>
            <td class="label">Masa Kerja</td>
            <td class="separator">:</td>
            <td class="value">{{ $guru->masa_kerja ?? '0' }}</td>
        </tr>
    </table>

    <div class="footer-note">
        Dokumen ini diterbitkan secara digital oleh Sistem Informasi Akademik pada {{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i') }} WIB.<br>
        Data terakhir diperbarui: {{ $guru->updated_at->translatedFormat('d F Y H:i') }}
    </div>

</body>
</html>
