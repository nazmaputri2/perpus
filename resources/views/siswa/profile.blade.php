@extends('layouts.siswa')

@section('title', 'Profil Siswa -')

@push('modals')
    @include('components.modal-ubah-sandi')
    @include('components.modal-keluar')
@endpush

@section('content')
    <div class="p-4 sm:ml-64">
        <div class="mt-14 max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                {{-- BAGIAN KIRI: Profil Utama dan Informasi Lengkap --}}
                <div class="lg:col-span-2 space-y-6">
                    
                    {{-- KARTU PROFIL UTAMA --}}
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                        <div class="relative bg-gradient-to-r from-blue-500 to-indigo-600 h-32">
                            <div class="absolute inset-0 bg-black bg-opacity-10"></div>
                        </div>
                        
                        <div class="relative px-6 pb-6">
                            <div class="flex flex-col items-center text-center -mt-16">
                                <div class="relative">
                                    <svg class="text-gray-400 w-32 h-32 rounded-full bg-white dark:bg-gray-700 p-4 shadow-xl ring-4 ring-white dark:ring-gray-700"
                                        fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                
                                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mt-4">
                                    {{ $siswa->nama_siswa }}
                                </h1>
                                <p class="text-md text-gray-500 dark:text-gray-400 mb-4">
                                    {{ $siswa->kelas_siswa }} - NISN: {{ $siswa->nis_siswa }}
                                </p>

                                <button type="button"
                                    class="text-white bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-6 py-2.5 text-center transition-all duration-200 hover:shadow-lg hover:scale-105 transform">
                                    <i class="fa-solid fa-lock mr-2"></i>Ubah Sandi
                                </button>
                            </div>

                            <hr class="my-6 border-gray-200 dark:border-gray-700">

                            {{-- STATISTIK --}}
                            <div class="grid grid-cols-3 gap-4 text-center">
                                <div class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                                    <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">
                                        {{ $peminjamanAktif }}
                                    </p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Buku Dipinjam</p>
                                </div>
                                <div class="p-4 bg-green-50 dark:bg-green-900/20 rounded-lg">
                                    <p class="text-3xl font-bold text-green-600 dark:text-green-400">
                                        {{ $totalPeminjaman }}
                                    </p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Peminjaman</p>
                                </div>
                                <div class="p-4 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                                    <p class="text-3xl font-bold text-purple-600 dark:text-purple-400">
                                        {{ $siswa->created_at->year }}
                                    </p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Bergabung Sejak</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- KARTU INFORMASI LENGKAP --}}
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                        <div class="flex items-center mb-6">
                            <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center mr-3">
                                <i class="fa-solid fa-user text-blue-600 dark:text-blue-400"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Informasi Lengkap</h3>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div class="flex items-start space-x-3">
                                    <div class="w-10 h-10 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i class="fa-solid fa-id-card text-gray-600 dark:text-gray-400"></i>
                                    </div>
                                    <div>
                                        <dt class="font-medium text-gray-500 dark:text-gray-400 text-sm">Nama Lengkap</dt>
                                        <dd class="mt-1 text-gray-900 dark:text-white font-semibold">
                                            {{ $siswa->nama_siswa }}
                                        </dd>
                                    </div>
                                </div>
                                
                                <div class="flex items-start space-x-3">
                                    <div class="w-10 h-10 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i class="fa-solid fa-envelope text-gray-600 dark:text-gray-400"></i>
                                    </div>
                                    <div>
                                        <dt class="font-medium text-gray-500 dark:text-gray-400 text-sm">Email</dt>
                                        <dd class="mt-1 text-gray-900 dark:text-white font-semibold">
                                            {{ $siswa->email ?? 'siswa@example.com' }}
                                        </dd>
                                    </div>
                                </div>
                                
                                <div class="flex items-start space-x-3">
                                    <div class="w-10 h-10 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i class="fa-solid fa-calendar text-gray-600 dark:text-gray-400"></i>
                                    </div>
                                    <div>
                                        <dt class="font-medium text-gray-500 dark:text-gray-400 text-sm">Tanggal Lahir</dt>
                                        <dd class="mt-1 text-gray-900 dark:text-white font-semibold">
                                            {{ $siswa->tanggal_lahir ?? '01 Januari 2008' }}
                                        </dd>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="space-y-4">
                                <div class="flex items-start space-x-3">
                                    <div class="w-10 h-10 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i class="fa-solid fa-phone text-gray-600 dark:text-gray-400"></i>
                                    </div>
                                    <div>
                                        <dt class="font-medium text-gray-500 dark:text-gray-400 text-sm">Nomor Telepon</dt>
                                        <dd class="mt-1 text-gray-900 dark:text-white font-semibold">
                                            {{ $siswa->nohp_siswa ?? '-' }}
                                        </dd>
                                    </div>
                                </div>
                                
                                <div class="flex items-start space-x-3">
                                    <div class="w-10 h-10 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i class="fa-solid fa-graduation-cap text-gray-600 dark:text-gray-400"></i>
                                    </div>
                                    <div>
                                        <dt class="font-medium text-gray-500 dark:text-gray-400 text-sm">Kelas</dt>
                                        <dd class="mt-1 text-gray-900 dark:text-white font-semibold">
                                            {{ $siswa->kelas_siswa }}
                                        </dd>
                                    </div>
                                </div>
                                
                                <div class="flex items-start space-x-3">
                                    <div class="w-10 h-10 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i class="fa-solid fa-map-marker-alt text-gray-600 dark:text-gray-400"></i>
                                    </div>
                                    <div>
                                        <dt class="font-medium text-gray-500 dark:text-gray-400 text-sm">Alamat</dt>
                                        <dd class="mt-1 text-gray-900 dark:text-white font-semibold">
                                            {{ $siswa->alamat ?? 'Jl. Pendidikan No. 123, Kelurahan Belian, Kecamatan Batam Kota, Batam, Kepulauan Riau' }}
                                        </dd>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- BAGIAN KANAN: Riwayat Peminjaman --}}
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 sticky top-4">
                        <div class="flex items-center mb-6">
                            <div class="w-8 h-8 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center mr-3">
                                <i class="fa-solid fa-history text-green-600 dark:text-green-400"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Riwayat Peminjaman</h3>
                        </div>
                        
                        <div class="space-y-3 max-h-96 overflow-y-auto">
                            @forelse($riwayat as $r)
                                <div class="flex p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150 border border-gray-100 dark:border-gray-700">
                                    <div class="flex-shrink-0 w-12 h-12 rounded-full 
                                        {{ $r->status_peminjaman == 'Dipinjam' ? 'bg-yellow-100 dark:bg-yellow-900' : 'bg-green-100 dark:bg-green-900' }} 
                                        flex items-center justify-center mr-4">
                                        <i class="fa-solid {{ $r->status_peminjaman == 'Dipinjam' ? 'fa-book-open text-yellow-600 dark:text-yellow-300' : 'fa-check text-green-600 dark:text-green-300' }}"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="font-semibold text-gray-900 dark:text-white text-sm mb-1">
                                            {{ $r->status_peminjaman == 'Dipinjam' ? 'Meminjam buku' : 'Mengembalikan buku' }}
                                        </p>
                                        <p class="text-sm text-gray-600 dark:text-gray-300 truncate mb-1">
                                            "{{ $r->buku->judul ?? '-' }}"
                                        </p>
                                        <time class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $r->status_peminjaman == 'Dipinjam' ? 'Dipinjam pada' : 'Dikembalikan pada' }} 
                                            {{ \Carbon\Carbon::parse($r->created_at)->translatedFormat('d M Y') }}
                                        </time>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8">
                                    <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <i class="fa-solid fa-book text-gray-400 text-xl"></i>
                                    </div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Belum ada riwayat peminjaman.</p>
                                </div>
                            @endforelse
                        </div>
                        

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection