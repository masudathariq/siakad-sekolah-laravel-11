<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Daftar Hadir</title>

<style>
@page {
    size: 330mm 210mm; /* F4 / Folio Landscape */
    margin: 2mm 4mm; /* Margin dioptimalkan agar muat 1 halaman */
}

body{
    font-family: Arial, Helvetica, sans-serif;
    font-size:10px;
}

/* ===== TABEL ===== */
table{
    border-collapse: collapse;
    width:100%;
}

th,td{
    border:1px solid #000;
    text-align:center;
    vertical-align:middle;
    padding:0;
}

/* ===== HEADER ===== */
.header{
    text-align:center;
    font-weight:bold;
    margin-bottom:8px;
}

.header .judul{
    font-size:16px;
}

/* ===== BAR KUNING (HEADER TABEL) ===== */
.kelas-bar{
    background:#ffeb3b !important;
    font-weight:bold;
    -webkit-print-color-adjust: exact;
}

.header-info-bar {
    background:#ffeb3b !important;
    font-weight:bold;
    -webkit-print-color-adjust: exact;
}

/* ===== TEXT ===== */
.text-left{
    text-align:left;
    padding-left:4px;
}

/* ===== TANGGAL MERAH ===== */
.hari-merah{
    background:red !important;
    color:red !important;
    -webkit-print-color-adjust: exact;
}

/* ===== FONT ===== */
.tanggal{ font-size:8px; }
.hari{ font-size:7px; }

/* ===== KOLOM (UKURAN ASLI ANDA) ===== */
.col-no{ width:3%; }
.col-nama{ width:25%; }
.col-jk{ width:3%; }

.col-tgl{
    width:2.2%;
    height:16px;
    line-height:16px;
    font-size:8px;
}

.col-hisab{
    width:3%;
    height:16px;
    line-height:16px;
}

/* ===== KETERANGAN & FOOTER ===== */
.keterangan{
    margin-top:10px;
    font-size:9px;
}

.footer{
    margin-top:8px;
}
.footer td{
    border:none;
    font-size:11px;
}
</style>
</head>

<body>

@php
    use Carbon\Carbon;
    Carbon::setLocale('id');

    $namaBulan = Carbon::create($tahun, $bulan, 1)->translatedFormat('F');
    $hariIndo = ['Mon'=>'Sen','Tue'=>'Sel','Wed'=>'Rab','Thu'=>'Kam','Fri'=>'Jum','Sat'=>'Sab','Sun'=>'Min'];
@endphp

<div class="header">
    <div class="judul">DAFTAR HADIR</div>
    SISWA/SISWI MTs MUHAMMADIYAH 1 NATAR
</div>

<table>
<thead>
    <tr class="header-info-bar">
        <th colspan="{{ 3 + $daysInMonth + 5 }}" style="padding: 5px 10px;">
            <table style="width:100%; border:none !important;">
                <tr>
                    <td style="border:none !important; text-align:left; font-weight:bold; width:30%;">
                        SEMESTER: {{ strtoupper($semester) }}
                    </td>
                    <td style="border:none !important; text-align:center; font-weight:bold; width:40%; font-size:12px;">
                        TAHUN PELAJARAN {{ $tahunAktif->nama }}
                    </td>
                    <td style="border:none !important; text-align:right; font-weight:bold; width:30%;">
                        BULAN: {{ strtoupper($namaBulan) }} {{ $tahun }}
                    </td>
                </tr>
            </table>
        </th>
    </tr>

    <tr>
        <th colspan="{{ 3 + $daysInMonth + 5 }}" class="kelas-bar" style="padding: 5px 0;">
            {{ $rombel->tingkat->nama }} {{ $rombel->nama_kelas }}
        </th>
    </tr>

    <tr>
        <th rowspan="2" class="col-no">NO</th>
        <th rowspan="2" class="col-nama">NAMA</th>
        <th rowspan="2" class="col-jk">JK</th>

        @for($d=1;$d<=$daysInMonth;$d++)
            <th class="tanggal col-tgl">{{ $d }}</th>
        @endfor

        <th colspan="5">JUMLAH</th>
    </tr>

    <tr>
    @for($d=1;$d<=$daysInMonth;$d++)
        @php
            $c = \Carbon\Carbon::create($tahun,$bulan,$d);
            $tgl = $c->toDateString();
            $hari = $hariIndo[$c->format('D')];
            $isMerah = $c->isSunday() || array_key_exists($tgl, $tanggalMerahManual);
        @endphp
        <th class="hari col-tgl {{ $isMerah ? 'hari-merah' : '' }}">
            {{ $hari }}
        </th>
    @endfor
        <th class="col-hisab">H</th>
        <th class="col-hisab">I</th>
        <th class="col-hisab">S</th>
        <th class="col-hisab">A</th>
        <th class="col-hisab">B</th>
    </tr>
</thead>

<tbody>
@foreach($rombel->siswas->sortBy('nama_siswa') as $siswa)
<tr style="height: auto;">
    <td class="col-no">{{ $loop->iteration }}</td>
    <td class="text-left col-nama">{{ $siswa->nama_siswa }}</td>
    <td class="col-jk">{{ $siswa->jenis_kelamin }}</td>

    @for($d=1;$d<=$daysInMonth;$d++)
        @php
            $c = \Carbon\Carbon::create($tahun,$bulan,$d);
            $tgl = $c->toDateString();
            $isMerah = $c->isSunday() || array_key_exists($tgl, $tanggalMerahManual);
        @endphp
        <td class="col-tgl {{ $isMerah ? 'hari-merah' : '' }}"></td>
    @endfor

    <td class="col-hisab"></td>
    <td class="col-hisab"></td>
    <td class="col-hisab"></td>
    <td class="col-hisab"></td>
    <td class="col-hisab"></td>
</tr>
@endforeach
</tbody>
</table>

@if(count($tanggalMerahManual))
<div class="keterangan">
    <strong>Keterangan :</strong>
    @foreach($tanggalMerahManual as $tgl => $ket)
        {{ \Carbon\Carbon::parse($tgl)->translatedFormat('d/m') }} : {{ $ket }}{{ !$loop->last ? ' | ' : '' }}
    @endforeach
</div>
@endif

<table class="footer">
<tr>
<td style="width:70%"></td>
<td style="text-align:center;">
    Tangkitbatu, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>
    Wali Kelas<br><br><br><br>
    <strong><u>{{ $rombel->waliKelas?->nama ?? '..........................' }}</u></strong><br>
    NUPTK {{ $rombel->waliKelas?->nuptk ?? '-' }}
</td>
</tr>
</table>

</body>
</html>