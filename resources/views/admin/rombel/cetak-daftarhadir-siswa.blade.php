<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>{{ $judulAtas }}</title>
    <style>
        body {
            font-family: 'Arial', Helvetica, sans-serif;
            font-size: 11px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #000;
            padding: 2px 4px;
            line-height: 1.1;
            vertical-align: middle;
        }

        th {
            background-color: #FFE600; /* Kuning cerah */
            color: #000;
            font-weight: bold;
            text-align: center;
        }

        .judul {
            text-align: center;
            margin: 3px 0;
            font-weight: bold;
            text-transform: uppercase;
        }

        .judul-atas { font-size: 14px; }
        .judul-bawah { font-size: 12px; }
        .judul-sekolah { font-size: 12px; }
        .judul-tahun { font-size: 11px; margin-bottom: 8px; }

        .ttd-cell {
            position: relative;
            height: 25px;
            padding: 0 !important;
        }

        .ttd-cell.no-bottom {
            border-bottom: 1px solid #fff !important;
        }

        .ttd-no {
            position: absolute;
            top: 2px;
            left: 4px;
            font-size: 9px;
        }

        .ttd {
            margin-top: 33px;
            width: 100%;
        }

        .ttd-kanan {
            width: 40%;
            float: right;
            text-align: center;
            font-size: 11px;
        }

        .ttd-kanan .nama {
            margin-top: 55px;
            font-weight: bold;
        }

        .clearfix { clear: both; }
    </style>
</head>
<body>

<img src="{{ public_path('images/header_kop.jpg') }}" width="100%">

<div class="judul judul-atas">{{ $judulAtas }}</div>
<div class="judul judul-bawah">{{ $judulBawah }}</div>
<div class="judul judul-sekolah">MTsS MUHAMMADIYAH 1 NATAR</div>
<div class="judul judul-sekolah">{{ $rombel->tingkat->nama }} - {{ $rombel->kode_kelas }}- {{ $rombel->nama_kelas }} </div>
<div class="judul judul-tahun">
    TAHUN PELAJARAN {{ $rombel->tahunAjaran->nama ?? '-' }}
</div>

<table>
    <thead>
        <tr>
            <th width="5%">No</th>
            <th width="10%">NISN</th>
            <th width="50%">NISN</th>
            <th width="10%">JK</th>
            <th width="5%" colspan="2">TANDA TANGAN</th>
        </tr>
    </thead>

    <tbody>
    @foreach($rombel->siswas as $s)
        @php
            $index = $loop->index;
            $showNumber = $index % 2 == 0;

            $noKiri  = $showNumber ? $index + 1 : '';
            $noKanan = $showNumber ? $index + 2 : '';
        @endphp

        <tr>
            <td align="center">{{ $loop->iteration }}</td>
            <td align="center">{{ $s->nisn }}</td>
            <td>{{ $s->nama_siswa }}</td>
            <td align="center">
                {{ $s->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
            </td>

            {{-- TTD KIRI --}}
            <td class="ttd-cell {{ $showNumber ? 'no-bottom' : '' }}">
                @if($showNumber)
                    <span class="ttd-no">{{ $noKiri }}</span>
                @endif
            </td>

            {{-- TTD KANAN --}}
            <td class="ttd-cell {{ $showNumber ? 'no-bottom' : '' }}">
                @if($showNumber)
                    <span class="ttd-no">{{ $noKanan }}</span>
                @endif
            </td>
        </tr>
    @endforeach

    {{-- Baris tambahan jika ganjil --}}
    @if($rombel->siswas->count() % 2 == 1)
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td class="ttd-cell"></td>
            <td class="ttd-cell"></td>
        </tr>
    @endif
    </tbody>
</table>

<table class="footer" style="width:100%; border-collapse: collapse; border: none;">
<tr>
<td style="width:70%; border: none;"></td>
<td style="text-align:center; border: none;">
    Tangkitbatu, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>
    Wali Kelas<br><br><br><br>
    <strong><u>{{ $rombel->waliKelas?->nama ?? '..........................' }}</u></strong><br>
    NUPTK {{ $rombel->waliKelas?->nuptk ?? '-' }}
</td>
</tr>
</table>


<div class="clearfix"></div>

</body>
</html>
