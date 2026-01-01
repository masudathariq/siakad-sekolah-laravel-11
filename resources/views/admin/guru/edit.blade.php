@extends('layouts.admin')

@section('title', 'Edit Data Guru')

@section('content')
<div class="py-8 px-4 sm:px-6">
    <div class="max-w-4xl mx-auto">

        {{-- HEADER --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-xl font-black text-slate-800">Edit Data Guru</h1>
                <p class="text-xs text-slate-400 uppercase tracking-widest">
                    Perbarui Profil Tenaga Pendidik
                </p>
            </div>
            <a href="{{ route('admin.guru.index') }}"
               class="px-4 py-2 border rounded-lg text-xs font-bold text-slate-500">
                Kembali
            </a>
        </div>

        {{-- CARD --}}
        <div class="bg-white rounded-2xl shadow border overflow-hidden">
            <div class="h-1.5 bg-gradient-to-r from-indigo-600 to-violet-600"></div>

            <form action="{{ route('admin.guru.update', $guru->id) }}" method="POST" class="p-6 md:p-8 space-y-10">
                @csrf
                @method('PUT')

                @php
                    $input = 'w-full px-4 py-2.5 border rounded-xl text-xs font-semibold focus:ring-2 focus:ring-indigo-500';
                    $jabatanGuru = $guru->jabatans->pluck('jabatan')->toArray();
                    $bidangGuru  = optional($guru->jabatans->where('jabatan','wakil_kepala')->first())->bidang ?? '';
                    $mapels = $guru->mapels->pluck('nama_mapel')->toArray();
                @endphp

                {{-- DATA UTAMA --}}
                <section>
                    <h4 class="section-title">Profil & Identitas</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div><label class="label">ID Guru *</label>
                            <input name="id_guru" value="{{ $guru->id_guru }}" required class="{{ $input }}"></div>
                        <div><label class="label">Nama Lengkap *</label>
                            <input name="nama" value="{{ $guru->nama }}" required class="{{ $input }}"></div>
                        <div><label class="label">Jenis Kelamin *</label>
                            <select name="jenis_kelamin" required class="{{ $input }}">
                                <option value="">Pilih</option>
                                <option value="L" {{ $guru->jenis_kelamin=='L'?'selected':'' }}>Laki-laki</option>
                                <option value="P" {{ $guru->jenis_kelamin=='P'?'selected':'' }}>Perempuan</option>
                            </select></div>
                        <div><label class="label">Status Kepegawaian *</label>
                            <select name="status_kepegawaian" required class="{{ $input }}">
                                <option value="">Pilih</option>
                                <option value="GTY" {{ $guru->status_kepegawaian=='GTY'?'selected':'' }}>GTY</option>
                                <option value="GTTY" {{ $guru->status_kepegawaian=='GTTY'?'selected':'' }}>GTTY</option>
                            </select></div>
                        <div><label class="label">Tempat Lahir</label>
                            <input name="tempat_lahir" value="{{ $guru->tempat_lahir }}" class="{{ $input }}"></div>
                        <div><label class="label">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" value="{{ optional($guru->tanggal_lahir)->format('Y-m-d') }}" class="{{ $input }}"></div>
                        <div><label class="label">NBM</label>
                            <input name="nbm" value="{{ $guru->nbm }}" class="{{ $input }}"></div>
                        <div><label class="label">NUPTK</label>
                            <input name="nuptk" value="{{ $guru->nuptk }}" class="{{ $input }}"></div>
                        <div><label class="label">Pendidikan *</label>
                            <select name="pendidikan" required class="{{ $input }}">
                                @foreach(['SMA','D I','D II','D III','D IV','S1','S2','S3'] as $p)
                                    <option value="{{ $p }}" {{ $guru->pendidikan==$p?'selected':'' }}>{{ $p }}</option>
                                @endforeach
                            </select></div>
                        <div><label class="label">Jurusan</label>
                            <input name="jurusan" value="{{ $guru->jurusan }}" class="{{ $input }}"></div>
                        <div><label class="label">Status Sertifikasi *</label>
                            <select name="status_sertifikasi" required class="{{ $input }}">
                                <option value="belum" {{ $guru->status_sertifikasi=='belum'?'selected':'' }}>Belum</option>
                                <option value="sertifikasi" {{ $guru->status_sertifikasi=='sertifikasi'?'selected':'' }}>Sertifikasi</option>
                                <option value="ppg" {{ $guru->status_sertifikasi=='ppg'?'selected':'' }}>PPG</option>
                            </select></div>
                        <div><label class="label">TMT *</label>
                            <input type="date" name="tmt" value="{{ optional($guru->tmt)->format('Y-m-d') }}" required class="{{ $input }}"></div>
                    </div>
                </section>

                {{-- JABATAN --}}
                <section>
                    <h4 class="section-title">Jabatan</h4>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        @foreach([
                            'kepala_madrasah'=>'Kepala Madrasah',
                            'wakil_kepala'=>'Wakil Kepala',
                            'kepala_tu'=>'Kepala TU',
                            'staff_tu'=>'Staff TU',
                            'bendahara'=>'Bendahara',
                            'guru_mapel'=>'Guru Mapel'
                        ] as $val=>$label)

                        @php $checked = in_array($val, $jabatanGuru); @endphp

                        <label class="cursor-pointer space-y-2">
                            <input type="checkbox" name="jabatan[]" value="{{ $val }}" class="hidden peer" data-jabatan="{{ $val }}" {{ $checked?'checked':'' }}>
                            <div class="px-3 py-2 text-xs font-bold text-center border rounded-xl peer-checked:bg-indigo-600 peer-checked:text-white">
                                {{ $label }}
                            </div>
                        </label>

                        @if($val === 'wakil_kepala')
                            <input type="text" name="bidang" value="{{ $bidangGuru }}" placeholder="Bidang Wakil Kepala" class="{{ $input }}">
                        @endif

                        @endforeach
                    </div>
                </section>

                {{-- MAPEL --}}
                <section>
                    <h4 class="section-title">Mata Pelajaran</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @forelse($mapels as $mapel)
                            <input name="mapel[]" value="{{ $mapel }}" class="{{ $input }}">
                        @empty
                            <input name="mapel[]" placeholder="Mapel 1" class="{{ $input }}">
                        @endforelse
                        <input name="mapel[]" placeholder="Mapel tambahan" class="{{ $input }}">
                    </div>
                </section>

                {{-- FOOTER --}}
                <div class="flex justify-end gap-4 pt-6 border-t">
                    <a href="{{ route('admin.guru.index') }}" class="text-xs font-bold text-slate-400">Batal</a>
                    <button type="submit" class="px-8 py-3 bg-indigo-600 text-white rounded-xl text-xs font-black">Simpan Perubahan</button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
