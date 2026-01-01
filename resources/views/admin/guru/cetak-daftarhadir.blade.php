<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>{{ $judulAtas }}</title>

<style>
    body {
        font-family: 'Inter', 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        font-size: 11px;
    }

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
    font-family: 'Inter', 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
    border-radius: 8px; 
    overflow: hidden;    
}

th, td {
    border: 1px solid #000;  
    padding: 6px 8px;        
    line-height: 1.2;        
    vertical-align: middle;
}

th {
    background-color: #FFEB3B;  
    color: #000;                 
    font-weight: 600;
    text-align: center;
}

td {
    background-color: #fff;  
}

tbody tr:hover {
    background-color: #f2f2f2;
}

.judul {
    text-align: center;
    margin: 3px 0;
    font-weight: 600; 
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

.ttd-cell.no-bottom { border-bottom: 1px solid #fff !important; }

.ttd-no {
    position: absolute;
    top: 2px;
    left: 4px;
    font-size: 9px;
}

.ttd {
    margin-top: 35px;
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
<div class="judul judul-tahun">
    TAHUN PELAJARAN {{ $tahunAjaranAktif->nama ?? '-' }}
</div>

<table>
    <thead>
<thead>
    <tr>
        <th width="3%">No</th>          <!-- lebih rapat -->
        <th width="6%">NBM</th>         <!-- lebih rapat -->
        <th width="8%">NUPTK/NIP</th>  <!-- lebih rapat -->
        <th width="40%">Nama Guru</th>  <!-- dipanjangkan -->
        <th width="8%" colspan="2">TANDA TANGAN</th>
    </tr>
</thead>

    </thead>

    <tbody>
    @foreach($guru as $g)
        @php
            $index = $loop->index;
            $showNumber = $index % 2 == 0;

            $noKiri  = $showNumber ? $index + 1 : '';
            $noKanan = $showNumber ? $index + 2 : '';
        @endphp

        <tr>
            <td align="center">{{ $loop->iteration }}</td>
<td align="center">{{ $g->nbm ?? '-' }}</td>
<td align="center">{{ $g->nuptk ?? '-' }}</td>

            <td>{{ $g->nama }}</td>

            {{-- TTD KIRI --}}
            <td class="ttd-cell {{ $showNumber ? 'no-bottom' : '' }}" style="width: 90px;">
                @if($showNumber)
                    <span class="ttd-no">{{ $noKiri }}</span>
                @endif
            </td>

            {{-- TTD KANAN --}}
            <td class="ttd-cell {{ $showNumber ? 'no-bottom' : '' }}" style="width: 90px;">
                @if($showNumber)
                    <span class="ttd-no">{{ $noKanan }}</span>
                @endif
            </td>
        </tr>
    @endforeach

    {{-- JIKA DATA GANJIL → BARIS BANTUAN --}}
    @if($guru->count() % 2 == 1)
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

<div class="ttd">
    <div class="ttd-kanan">
        Tangkitbatu, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>
        Kepala Madrasah
        <div class="nama">
            Imroatun Rofiqoh, S.Pd.<br>
            NUPTK. 8446759662210013
        </div>
    </div>
</div>

<div class="clearfix"></div>

</body>
</html>
