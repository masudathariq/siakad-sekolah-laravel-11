<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekap Absensi - {{ $rombel->nama_kelas }}</title>
    <style>
        @page { margin: 0.8cm; }
        body { font-family: 'Helvetica', sans-serif; font-size: 10px; color: #111827; line-height: 1.3; margin: 0; }

        .layout-table { width: 100%; border-collapse: collapse; }
        .header-box img { width: 100%; }
        .judul-container { text-align: center; padding: 8px 0; }
        .text-judul { font-size: 16px; font-weight: 700; text-decoration: underline; text-transform: uppercase; color: #1e40af; }
        .text-subjudul { font-size: 12px; font-weight: 600; color: #1e3a8a; margin-top: 2px; }

        .banner-info { background-color: #1e40af; color: #ffffff; padding: 6px 10px; border-radius: 6px; margin: 10px 0; font-size: 10px; font-weight: 600; }

        .main-table { width: 100%; border-collapse: collapse; margin-top: 8px; font-size: 9px; }
        .main-table th { background-color: #1e3a8a; color: #ffffff; padding: 5px; border: 1px solid #1e40af; }
        .main-table td { padding: 4px; border: 1px solid #cbd5e1; text-align: center; }
        .main-table td.left { text-align: left; }
        .main-table td.bold { font-weight: bold; }
        .main-table tr:nth-child(even) { background-color: #f3f4f6; }

        /* Highlight interaktif */
        .highlight-warning { background-color: #fee2e2; } /* < 75% */
        .highlight-danger { background-color: #fca5a5; font-weight: bold; } /* < 50% */

        .highlight-container { width: 100%; margin-top: 12px; border-collapse: separate; border-spacing: 6px; font-size: 9px; }
        .card-hl { background-color: #f1f5f9; border: 1px solid #1e40af; padding: 6px 4px; border-radius: 6px; text-align: center; }
        .hl-label { font-weight: 700; color: #1e40af; text-transform: uppercase; margin-bottom: 2px; }
        .hl-name { font-weight: 600; color: #111827; display: block; height: 20px; overflow: hidden; }
        .hl-value { color: #475569; font-size: 8px; }

        .hl-alpha { border-color: #dc2626; color: #dc2626; }
        .hl-bolos { border-color: #92400e; color: #92400e; }

        .footer-sign { margin-top: 25px; width: 100%; border-collapse: collapse; font-size: 9px; }
        .footer-sign td { vertical-align: top; }
        .footer-sign .date { color: #64748b; font-style: italic; font-size: 8px; }
        .footer-sign .signature { text-align: center; width: 40%; }

    </style>
</head>
<body>

@php
    $ta = \App\Models\TahunAjaran::where('aktif', 1)->first();
    $totalHariEfektif = $hariEfektif ?? 25;

    $dataSiswa = [];
    foreach($rombel->siswas as $s) {
        $d = $rekap[$s->nisn] ?? (object)['hadir'=>0,'izin'=>0,'sakit'=>0,'alpha'=>0,'bolos'=>0];
        $persentase = ($totalHariEfektif>0) ? round(($d->hadir/$totalHariEfektif)*100,1) : 0;
        $dataSiswa[] = [
            'nisn' => $s->nisn,
            'nama' => strtoupper($s->nama_siswa),
            'hadir' => $d->hadir,
            'izin' => $d->izin,
            'sakit' => $d->sakit,
            'alpha' => $d->alpha,
            'bolos' => $d->bolos,
            'persentase' => $persentase
        ];
    }

    // Ranking berdasarkan persentase kehadiran
    $ranking = collect($dataSiswa)->sortByDesc('persentase')->values();
    $col = collect($dataSiswa);
    $palingHadir = $col->sortByDesc('hadir')->first();
    $palingIzin  = $col->sortByDesc('izin')->filter(fn($i)=>$i['izin']>0)->first();
    $palingSakit = $col->sortByDesc('sakit')->filter(fn($i)=>$i['sakit']>0)->first();
    $palingAlpha = $col->sortByDesc('alpha')->filter(fn($i)=>$i['alpha']>0)->first();
    $palingBolos = $col->sortByDesc('bolos')->filter(fn($i)=>$i['bolos']>0)->first();
    $avgHadir = $col->avg('persentase');
    $siswaKurang75 = $col->filter(fn($i)=>$i['persentase']<75)->count();
@endphp

{{-- KOP SURAT --}}
<table class="layout-table">
    <tr>
        <td class="header-box"><img src="{{ public_path('images/header_kop.jpg') }}" alt="Kop Surat"></td>
    </tr>
    <tr>
        <td class="judul-container">
            <div class="text-judul">Laporan Rekapitulasi Absensi Siswa</div>
            <div class="text-subjudul">MTSS Muhammadiyah 1 Natar</div>
        </td>
    </tr>
</table>

<div class="banner-info">
    BULAN: {{ strtoupper($namaBulan) }} {{ $tahun }} | KELAS: {{ $rombel->nama_kelas }} | HARI EFEKTIF: {{ $totalHariEfektif }} | TP: {{ $ta->nama ?? '-' }}
</div>

<table class="main-table">
    <thead>
        <tr>
            <th>NO</th>
            <th class="left">NAMA LENGKAP SISWA</th>
            <th>H</th>
            <th>I</th>
            <th>S</th>
            <th>A</th>
            <th>B</th>
            <th>%</th>
            <th>RANK</th>
        </tr>
    </thead>
    <tbody>
        @foreach($dataSiswa as $no => $s)
        @php
            $cls = '';
            if($s['persentase']<50) $cls='highlight-danger';
            elseif($s['persentase']<75) $cls='highlight-warning';
            $rank = $ranking->search(fn($r)=>$r['nisn']==$s['nisn']) + 1;
        @endphp
        <tr class="{{ $cls }}" title="Hadir: {{$s['hadir']}} | Izin: {{$s['izin']}} | Sakit: {{$s['sakit']}} | Alpha: {{$s['alpha']}} | Bolos: {{$s['bolos']}}">
            <td>{{ $no+1 }}</td>
            <td class="left">{{ $s['nama'] }}</td>
            <td>{{ $s['hadir'] }}</td>
            <td>{{ $s['izin'] }}</td>
            <td>{{ $s['sakit'] }}</td>
            <td>{{ $s['alpha'] }}</td>
            <td>{{ $s['bolos'] }}</td>
            <td class="bold">{{ $s['persentase'] }}%</td>
            <td class="bold">{{ $rank }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<div style="margin-top: 8px; font-size: 9px; font-weight: 600; color: #1e40af;">
    Total Siswa: {{ count($dataSiswa) }} | Rata-rata Kehadiran: {{ round($avgHadir,1) }}% | Siswa <75%: {{ $siswaKurang75 }}
</div>

{{-- SUMMARY --}}
<table class="highlight-container">
    <tr>
        <td><div class="card-hl"><div class="hl-label">Hadir Terbanyak</div><div class="hl-name">{{ $palingHadir['nama'] ?? '-' }}</div><div class="hl-value">{{ $palingHadir['hadir'] ?? 0 }} Hari</div></div></td>
        <td><div class="card-hl"><div class="hl-label">Izin Terbanyak</div><div class="hl-name">{{ $palingIzin['nama'] ?? 'Tidak Ada' }}</div><div class="hl-value">{{ $palingIzin['izin'] ?? 0 }} Hari</div></div></td>
        <td><div class="card-hl"><div class="hl-label">Sakit Terbanyak</div><div class="hl-name">{{ $palingSakit['nama'] ?? 'Tidak Ada' }}</div><div class="hl-value">{{ $palingSakit['sakit'] ?? 0 }} Hari</div></div></td>
        <td><div class="card-hl hl-alpha"><div class="hl-label">Alpha Terbanyak</div><div class="hl-name">{{ $palingAlpha['nama'] ?? 'Tidak Ada' }}</div><div class="hl-value">{{ $palingAlpha['alpha'] ?? 0 }} Hari</div></div></td>
        <td><div class="card-hl hl-bolos"><div class="hl-label">Bolos Terbanyak</div><div class="hl-name">{{ $palingBolos['nama'] ?? 'Tidak Ada' }}</div><div class="hl-value">{{ $palingBolos['bolos'] ?? 0 }} Hari</div></div></td>
    </tr>
</table>

{{-- FOOTER --}}
<table class="footer-sign">
    <tr>
        <td class="date">* Dicetak otomatis pada {{ date('d/m/Y H:i') }}</td>
        <td class="signature">
            Natar, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>
            Wali Kelas {{ $rombel->nama_kelas }},<br><br><br><br><br>
            <strong><u>{{ $rombel->waliKelas->nama ?? '________________' }}</u></strong>
        </td>
    </tr>
</table>

</body>
</html>
