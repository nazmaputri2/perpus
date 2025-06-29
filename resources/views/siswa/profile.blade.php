@extends('layouts.siswa')

@section('title', 'Profil Siswa -')

@push('modals')
@include('components.modal-ubah-sandi')
    @include('components.modal-keluar')
@endpush

@section('content')
    <div class="p-4 sm:ml-64">
        {{-- PENYESUAIAN: Menghapus 'max-w-5xl' dan 'mx-auto' untuk membuat layout full-width --}}
        <div class="mt-14 relative">

            {{-- Alur Konten Utama (Sebelah Kiri di Desktop) --}}
            <div class="lg:w-3/5">
                {{-- KARTU PROFIL UTAMA --}}
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-6">
                    <div class="flex flex-col items-center text-center">
                        <svg class=" text-gray-400 w-32 h-32 rounded-full mb-2 object-cover shadow-lg ring-4 ring-gray-100 dark:ring-gray-700"
                            fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                clip-rule="evenodd"></path>
                        </svg>
<h1 class="text-3xl font-bold text-gray-900 dark:text-white mt-4">{{ $siswa->nama_siswa }}</h1>
<p class="text-md text-gray-500 dark:text-gray-400">{{ $siswa->kelas_siswa }} - NISN: {{ $siswa->nis_siswa }}</p>

                        <button type="button"
                            class="mt-4 text-white bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-6 py-2.5 text-center transition-all duration-200 hover:shadow-lg hover:scale-105">
                            <i class="fa-solid fa-lock mr-2"></i>Ubah Sandi
                        </button>
                    </div>

                    <hr class="my-6 border-gray-200 dark:border-gray-700">

                    <div class="flex justify-around text-center">
                        <div>
<p class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $peminjamanAktif }}</p>
<p class="text-sm text-gray-500 dark:text-gray-400">Buku Dipinjam</p>
                        </div>
                        <div>
<p class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $totalPeminjaman }}</p>
<p class="text-sm text-gray-500 dark:text-gray-400">Total Peminjaman</p>                        </div>
                        <div>
<p class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $siswa->created_at->year }}</p>
<p class="text-sm text-gray-500 dark:text-gray-400">Bergabung Sejak</p>                        </div>
                    </div>
                </div>

                {{-- KARTU INFORMASI LENGKAP --}}
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Informasi Lengkap</h3>
                    <dl class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-6">
                        <div>
                            <dt class="font-medium text-gray-500 dark:text-gray-400 text-sm">Nama Lengkap</dt>
<dd class="mt-1 text-gray-900 dark:text-white font-semibold">{{ $siswa->nama_siswa }}</dd>                        </div>
                        <div>
                            <dt class="font-medium text-gray-500 dark:text-gray-400 text-sm">Email</dt>
                            <dd class="mt-1 text-gray-900 dark:text-white font-semibold">siswa@example.com</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-gray-500 dark:text-gray-400 text-sm">Tanggal Lahir</dt>
                            <dd class="mt-1 text-gray-900 dark:text-white font-semibold">01 Januari 2008</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-gray-500 dark:text-gray-400 text-sm">Nomor Telepon</dt>
<dd class="mt-1 text-gray-900 dark:text-white font-semibold">{{ $siswa->nohp_siswa ?? '-' }}</dd>                        </div>
                        <div class="lg:col-span-2">
                            <dt class="font-medium text-gray-500 dark:text-gray-400 text-sm">Alamat</dt>
                            <dd class="mt-1 text-gray-900 dark:text-white font-semibold">Jl. Pendidikan No. 123, Kelurahan
                                Belian, Kecamatan Batam Kota, Batam, Kepulauan Riau</dd>
                        </div>
                    </dl>
                </div>
            </div>

            {{-- CARD RIWAYAT PEMINJAMAN (Mengambang di Kanan pada Desktop) --}}
            <div class="w-full mt-6 lg:w-1/3 lg:absolute lg:top-0 lg:right-0 lg:mt-0">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 h-full">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Riwayat Peminjaman</h3>
                    <div class="space-y-2">
@forelse($riwayat as $r)
    <div class="flex p-3 -m-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700/60 transition-colors duration-150">
        <div class="flex-shrink-0 w-12 h-12 rounded-full 
            {{ $r->status == 'Dipinjam' ? 'bg-yellow-100 dark:bg-yellow-900' : 'bg-green-100 dark:bg-green-900' }} 
            flex items-center justify-center mr-4">
            <i class="fa-solid {{ $r->status == 'Dipinjam' ? 'fa-book-open text-yellow-600 dark:text-yellow-300' : 'fa-check text-green-600 dark:text-green-300' }}"></i>
        </div>
        <div>
            <p class="font-semibold text-gray-900 dark:text-white">
               {{ $r->status == 'Dipinjam' ? 'Meminjam buku' : 'Mengembalikan buku' }} "{{ $r->buku->judul ?? '-' }}"

            </p>
            <time class="text-sm text-gray-500 dark:text-gray-400">
                {{ $r->status == 'Dipinjam' ? 'Dipinjam pada' : 'Dikembalikan pada' }} {{ \Carbon\Carbon::parse($r->created_at)->translatedFormat('d F Y') }}
            </time>
        </div>
    </div>
@empty
    <p class="text-center text-sm text-gray-500 dark:text-gray-400">Belum ada riwayat peminjaman.</p>
@endforelse

