<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Daftar Hadir Semua Rombel</title>

<style>
@page {
    size: 330mm 210mm; /* F4 / Folio Landscape */
    margin: 6mm;
}
body{
    font-family: Arial, Helvetica, sans-serif;
    font-size:9px;
}

table{
    border-collapse: collapse;
    width:100%;
}

th,td{
    border:1px solid #000;
    padding:2px;
    text-align:center;
    vertical-align:middle;
}

.header{
    text-align:center;
    font-weight:bold;
    margin-bottom:4px;
}

.judul{
    font-size:12px;
}

.kelas-bar{
    background:#ffeb3b;
    font-weight:bold;
}

.text-left{
    text-align:left;
    padding-left:3px;
}

.hari-merah{
    background:red;
    color:red;
}

.tanggal{ font-size:8px; }
.hari{ font-size:7px; }

.col-no{width:3%;}
.col-nama{width:25%;}
.col-jk{width:3%;}
.col-tgl{width:2%;}
.col-jumlah{width:2%;}

/* Kolom HISAB (H I S A B) */
.col-hisab{
    width:2%;          /* lebih lebar dari tanggal */
    height:16px;       /* bikin kotak */
    padding:0;
}

.keterangan{
    margin-top:6px;
    font-size:8px;
}

.footer{
    margin-top:12px;
}
.footer td{
    border:none;
    font-size:9px;
}

.page-break{
    page-break-after: always;
}
</style>
</head>

<body>

@php
    use Carbon\Carbon;

    // set locale ke Indonesia
    Carbon::setLocale('id');

    $tahunPelajaran = $tahun.'/'.$tahun+1;

    // Nama bulan Indonesia
    $namaBulan = Carbon::create($tahun, $bulan, 1)
                    ->translatedFormat('F');

    // Singkatan hari Indonesia
    $hariIndo = [
        'Mon'=>'Sen','Tue'=>'Sel','Wed'=>'Rab',
        'Thu'=>'Kam','Fri'=>'Jum','Sat'=>'Sab','Sun'=>'Min'
    ];
@endphp


@foreach($rombels as $rombel)

<div class="header">
    <div class="judul">DAFTAR HADIR</div>
    SISWA/SISWI MTs MUHAMMADIYAH 1 NATAR<br>
    SEMESTER {{ strtoupper($semester) }}<br>
    TAHUN PELAJARAN {{ $tahunPelajaran }}
    BULAN {{ strtoupper($namaBulan) }} {{ $tahun }}<br>
</div>


<table>
<thead>
<tr>
    <th colspan="{{ 3 + $daysInMonth + 5 }}" class="kelas-bar">
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
    <th class="hari col-tgl" style="{{ $isMerah ? 'background:red;color:red;' : '' }}">
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
<tr>
    <td>{{ $loop->iteration }}</td>
    <td class="text-left">{{ $siswa->nama_siswa }}</td>
    <td>{{ $siswa->jenis_kelamin == 'L' ? 'L' : 'P' }}</td>


    @for($d=1;$d<=$daysInMonth;$d++)
        @php
            $c = \Carbon\Carbon::create($tahun,$bulan,$d);
            $tgl = $c->toDateString();
            $isMerah = $c->isSunday() || array_key_exists($tgl, $tanggalMerahManual);
        @endphp
        <td class="{{ $isMerah ? 'hari-merah' : '' }}"></td>
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

{{-- KETERANGAN (HANYA MANUAL, TANPA MINGGU) --}}
@if(count($tanggalMerahManual))
<div class="keterangan">
    <strong>Keterangan :</strong><br>
    @foreach($tanggalMerahManual as $tgl => $ket)
        {{ \Carbon\Carbon::parse($tgl)->translatedFormat('d F Y') }} : {{ $ket }}<br>
    @endforeach
</div>
@endif

<table class="footer">
<tr>
<td style="width:70%"></td>
<td style="text-align:center;">
    Tangkitbatu, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>
    Wali Kelas<br><br><br><br>
    <strong><u>{{ $rombel->waliKelas?->nama }}</u></strong><br>
    NUPTK {{ $rombel->waliKelas?->nuptk }}
</td>
</tr>
</table>

@if(!$loop->last)
<div class="page-break"></div>
@endif

@endforeach

</body>
</html>
