<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Guru</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            color: #000;
        }
        .kop {
            width: 100%;
            margin-bottom: 8px;
        }
        h2 {
            text-align: center;
            font-size: 13px;
            margin: 4px 0 8px 0;
            text-transform: uppercase;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 3px;
            vertical-align: top;
        }
        th {
            background-color: #0000FF;
            color: #fff;
            text-align: center;
            font-size: 8px;
        }
        td {
            font-size: 8px;
        }
        .center { text-align: center; }
        .uppercase { text-transform: uppercase; }
    </style>
</head>
<body>

{{-- KOP --}}
<img src="{{ public_path('images/header_kop.jpg') }}" class="kop">

<h2>
    DATA TENAGA PENDIDIK DAN KEPENDIDIKAN<br>
    MTs MUHAMMADIYAH 1 NATAR
</h2>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>ID Guru</th>
            <th>Nama Lengkap</th>
            <th>JK</th>
            <th>TTL</th>
            <th>NBM</th>
            <th>NUPTK</th>
            <th>Pendidikan</th>
            <th>Jurusan</th>
            <th>Status Pegawai</th>
            <th>Sertifikasi</th>
            <th>TMT</th>
            <th>Jabatan</th>
            <th>Mapel</th>
        </tr>
    </thead>
    <tbody>
        @forelse($guru as $g)
        <tr>
            <td class="center">{{ $loop->iteration }}</td>
            <td class="center">{{ $g->id_guru }}</td>
            <td class="uppercase">{{ $g->nama }}</td>
            <td class="center">
                {{ $g->jenis_kelamin === 'L' ? 'L' : 'P' }}
            </td>
            <td>
                {{ $g->tempat_lahir }},
                {{ $g->tanggal_lahir ? \Carbon\Carbon::parse($g->tanggal_lahir)->format('d-m-Y') : '-' }}
            </td>
            <td class="center">{{ $g->nbm ?? '-' }}</td>
            <td class="center">{{ $g->nuptk ?? '-' }}</td>
            <td class="center">{{ $g->pendidikan }}</td>
            <td>{{ $g->jurusan ?? '-' }}</td>
            <td class="center">{{ $g->status_kepegawaian }}</td>
            <td class="center">
                {{ strtoupper($g->status_sertifikasi) }}
            </td>
            <td class="center">
                {{ $g->tmt ? \Carbon\Carbon::parse($g->tmt)->format('d-m-Y') : '-' }}
            </td>

            {{-- Jabatan --}}
            <td>
                @if($g->jabatans->count())
                    @foreach($g->jabatans as $j)
                        - {{ str_replace('_',' ', strtoupper($j->jabatan)) }}
                        @if($j->bidang)
                            ({{ strtoupper($j->bidang) }})
                        @endif
                        <br>
                    @endforeach
                @else
                    -
                @endif
            </td>

            {{-- Mapel --}}
            <td>
                @if($g->mapels->count())
                    @foreach($g->mapels as $m)
                        - {{ strtoupper($m->nama_mapel) }}<br>
                    @endforeach
                @else
                    -
                @endif
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="14" class="center">Tidak ada data guru</td>
        </tr>
        @endforelse
    </tbody>
</table>

</body>
</html>
