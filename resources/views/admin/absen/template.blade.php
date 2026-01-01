<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Template Absen - {{ $rombel->nama_kelas ?? $rombel->kode_kelas }}</title>
    <style>
        @page { size: A4 landscape; margin: 8mm; }
        body { font-family: sans-serif; font-size: 12px; margin: 4px; padding: 4px; }
        table { border-collapse: collapse; width: 100%; table-layout: fixed; font-size: 10px; }
        th, td { border: 1px solid #000; padding: 3px; text-align: center; word-break: break-word; }
        th { background: #f1f5f9; }
        .header { text-align: center; font-size: 12px; font-weight: bold; margin-bottom: 8px; }
        .bulan-info { text-align: center; font-size: 12px; margin-top: -5px; font-weight: bold; color: blue; }
        .red-bg { background-color: #fdd; }
        .text-left { text-align: left; padding-left: 5px; }
        .col-no { width: 3%; }
        .col-nis { width: 10%; }
        .col-nama { width: 30%; }
        .col-tanggal { font-size: 8px; padding: 1px; width: 2.5%; }
        .footer { margin-top: 30px; font-size: 10px; width: 100%; }
        .footer td { border: none; }
    </style>
</head>
<body>

<div class="header">
    TEMPLATE ABSEN SISWA<br>
    MTs Muhammadiyah 1 Natar<br>
    {{ strtoupper($rombel->nama_kelas ?? $rombel->kode_kelas) }}<br>
    KELAS {{ strtoupper($rombel->tingkat->nama ?? '-') }}
</div>

<p class="bulan-info">
    Bulan: {{ Carbon\Carbon::create($tahun, $bulan)->translatedFormat('F Y') }}
</p>

<table>
    <thead>
        <tr>
            <th class="col-no">NO</th>
            <th class="col-nis">NIS</th>
            <th class="col-nama text-left">NAMA SISWA</th>
            @for ($d = 1; $d <= $daysInMonth; $d++)
                <th class="col-tanggal">{{ $d }}</th>
            @endfor
        </tr>
    </thead>
    <tbody>
        @foreach ($rombel->siswas->sortBy('nama_siswa') as $index => $siswa)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $siswa->nis ?? '-' }}</td>
                <td class="text-left">{{ $siswa->nama_siswa }}</td>
                @for ($d = 1; $d <= $daysInMonth; $d++)
                    @php
                        $tgl = Carbon\Carbon::create($tahun, $bulan, $d)->toDateString();
                        $isRed = Carbon\Carbon::create($tahun, $bulan, $d)->isSunday() || in_array($tgl, $tanggalMerahManual ?? []);
                    @endphp
                    <td @if($isRed) class="red-bg" @endif></td>
                @endfor
            </tr>
        @endforeach
    </tbody>
</table>

@if (!empty($tanggalMerahManual) && !empty($keteranganTanggalMerah))
    <div style="margin-top:15px; font-size: 10px;">
        <strong>Keterangan Tanggal Merah:</strong>
        <ul style="padding-left: 15px;">
            @foreach ($keteranganTanggalMerah as $i => $ket)
                @php $tgl = $tanggalMerahManual[$i] ?? null; @endphp
                @if ($tgl)
                    <li>{{ Carbon\Carbon::parse($tgl)->translatedFormat('d F Y') }} - {{ $ket }}</li>
                @endif
            @endforeach
        </ul>
    </div>
@endif

<table class="footer">
    <tr>
        <td style="width: 65%"></td>
        <td class="text-center">
            Tangkitbatu, {{ Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>
            Wali Kelas<br><br><br><br>
            <strong><u>{{ $rombel->waliKelas?->nama ?? 'Nama Wali Kelas' }}</u></strong><br>
            NUPTK: {{ $rombel->waliKelas?->nuptk ?? '-' }}
        </td>
    </tr>
</table>

</body>
</html>
