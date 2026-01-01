@foreach($rombels as $rombel)
    <div style="page-break-after: always;">
        @include('admin.absen._cetak-table', [
            'rombel' => $rombel,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'daysInMonth' => $daysInMonth,
            'semester' => $semester,
            'tanggalMerah' => $tanggalMerah,
            'tanggalMerahManual' => $tanggalMerahManual
        ])
    </div>
@endforeach
