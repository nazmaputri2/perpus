@extends('layouts.petugas')

@section('title', 'Beranda')

@push('modals')
    @include('components.modal-ubah-sandi')
    @include('components.modal-keluar')
@endpush



@section('content')
    <div class="bg-gradient-to-br from-blue-600 to-indigo-700 text-white rounded-3xl p-8 mb-10 shadow-lg relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full opacity-10" style="background-image: url('https://www.transparenttextures.com/patterns/cubes.png');"></div>
        <div class="relative z-10">
            <h1 class="text-4xl font-extrabold mb-2">Selamat Datang Kembali!</h1>
            <p class="text-blue-100 text-lg">Pantau aktivitas perpustakaan Anda dengan mudah.</p>
            <div class="mt-6">
                <a href="{{ route('petugas.koleksibuku') }}" class="inline-flex items-center px-6 py-3 bg-white text-blue-700 rounded-full font-semibold shadow-md hover:bg-gray-100 transition-colors duration-300">
                    Lihat Semua Buku
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </div>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mb-10">
        <div class="bg-white rounded-3xl p-7 shadow-xl border border-blue-50 hover:border-blue-200 transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-md font-semibold text-gray-500 mb-1">Total Buku</p>
                    <p class="text-4xl font-extrabold text-blue-700">42</p>
                </div>
                <div class="w-14 h-14 bg-blue-500/10 rounded-full flex items-center justify-center shadow-inner">
                    <i class="fas fa-book-open text-blue-600 text-2xl"></i>
                </div>
            </div>
            <p class="text-sm text-gray-400 mt-3">Jumlah keseluruhan koleksi</p>
        </div>
        <div class="bg-white rounded-3xl p-7 shadow-xl border border-yellow-50 hover:border-yellow-200 transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-md font-semibold text-gray-500 mb-1">Buku Dipinjam</p>
                    <p class="text-4xl font-extrabold text-yellow-600">16</p>
                </div>
                <div class="w-14 h-14 bg-yellow-500/10 rounded-full flex items-center justify-center shadow-inner">
                    <i class="fas fa-users-viewfinder text-yellow-600 text-2xl"></i>
                </div>
            </div>
            <p class="text-sm text-gray-400 mt-3">Sedang dalam peminjaman aktif</p>
        </div>
        <div class="bg-white rounded-3xl p-7 shadow-xl border border-green-50 hover:border-green-200 transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-md font-semibold text-gray-500 mb-1">Buku Dikembalikan</p>
                    <p class="text-4xl font-extrabold text-green-600">8</p>
                </div>
                <div class="w-14 h-14 bg-green-500/10 rounded-full flex items-center justify-center shadow-inner">
                    <i class="fas fa-circle-check text-green-600 text-2xl"></i>
                </div>
            </div>
            <p class="text-sm text-gray-400 mt-3">Telah berhasil dikembalikan</p>
        </div>
    </div>
    
    <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-8 mb-10">
        <div class="flex items-center justify-between mb-8">
            <h3 class="text-3xl font-extrabold text-gray-900 flex items-center">
                <i class="fas fa-history text-blue-500 text-2xl mr-3"></i>
                Aktivitas Terbaru
            </h3>
            <div class="flex items-center space-x-2 bg-green-50 px-4 py-2 rounded-full border border-green-200 shadow-sm">
                <div class="w-2.5 h-2.5 bg-green-500 rounded-full animate-pulse"></div>
                <span class="text-sm font-medium text-green-700">Live Updates</span>
            </div>
        </div>
        <div class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-2xl p-5 mb-6 border border-blue-200 shadow-md">
            <div class="flex items-center justify-between">
                <h4 class="font-bold text-blue-800 text-lg">Hari Ini - {{ $today }}</h4>
                <span class="px-4 py-1.5 bg-blue-200 text-blue-800 text-sm font-semibold rounded-full">
                    {{ count($todayActivities) }} aktivitas
                </span>
            </div>
        </div>
        @if($todayActivities->isEmpty())
            <div class="bg-gray-50 rounded-2xl border border-gray-200 p-12 text-center flex flex-col items-center justify-center">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner">
                    <i class="fas fa-receipt text-gray-400 text-4xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-3">Tidak Ada Aktivitas Hari Ini</h3>
                <p class="text-gray-600 max-w-md mb-8">Belum ada kegiatan peminjaman atau pengembalian buku yang tercatat untuk hari ini. Mari mulai buat aktivitas!</p>
                <button class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-full font-bold transition-colors duration-300 shadow-md hover:shadow-lg">
                    <i class="fas fa-plus mr-2"></i>
                    Catat Aktivitas Baru
                </button>
            </div>
        @else
            <div class="space-y-5">
                @foreach($todayActivities as $activity)
                <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-6 hover:shadow-lg transition-all duration-300 group flex items-center gap-6">
                    <div class="relative">
                        <div class="w-14 h-14 rounded-full flex items-center justify-center shadow-sm
                            bg-{{ $activity->aksi == 'meminjam' ? 'blue' : ($activity->aksi == 'mengembalikan' ? 'green' : ($activity->aksi == 'menambah' ? 'purple' : ($activity->aksi == 'mengubah' ? 'yellow' : ($activity->aksi == 'menghapus' ? 'red' : 'gray')))) }}-100
                            text-{{ $activity->aksi == 'meminjam' ? 'blue' : ($activity->aksi == 'mengembalikan' ? 'green' : ($activity->aksi == 'menambah' ? 'purple' : ($activity->aksi == 'mengubah' ? 'yellow' : ($activity->aksi == 'menghapus' ? 'red' : 'gray')))) }}-600">
                            <i class="fas fa-{{ $activity->aksi == 'meminjam' ? 'book-reader' : ($activity->aksi == 'mengembalikan' ? 'undo-alt' : ($activity->aksi == 'menambah' ? 'circle-plus' : ($activity->aksi == 'mengubah' ? 'edit' : ($activity->aksi == 'menghapus' ? 'trash' : 'info-circle')))) }} text-2xl"></i>
                        </div>
                    </div>
                    <div class="flex-1 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-y-3 gap-x-6">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-0.5">Aktivitas</p>
                            <p class="text-lg font-bold text-gray-900">
                                {{ ucfirst($activity->aksi) }} <span class="text-blue-600">{{ strtoupper($activity->tabel) }}</span>
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-0.5">Keterangan</p>
                            <p class="font-semibold text-gray-800">{{ $activity->keterangan }}</p>
                        </div>
                        <div class="flex flex-col sm:flex-row lg:flex-col gap-3 sm:gap-6 lg:gap-3 items-start sm:items-center lg:items-start">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-purple-600 text-md"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Pengguna</p>
                                    <p class="font-semibold text-gray-800">{{ $activity->pengguna->username }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-clock text-gray-600 text-md"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Waktu</p>
                                    <p class="font-semibold text-gray-800">{{ \Carbon\Carbon::parse($activity->waktu)->diffForHumans() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
    
    <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-8">
        <div class="flex items-center justify-between mb-8">
            <h3 class="text-3xl font-extrabold text-gray-900 flex items-center">
                <i class="fas fa-trophy text-amber-500 text-2xl mr-3"></i>
                Peminjam Terbanyak
            </h3>
            <span class="px-5 py-2 bg-blue-100 text-blue-800 text-md font-semibold rounded-full shadow-sm">Top 3</span>
        </div>
        <div class="space-y-6">
            <div class="bg-gradient-to-r from-yellow-50 to-amber-100 rounded-2xl shadow-lg border border-yellow-200 p-7 hover:shadow-xl transition-all duration-300 transform hover:scale-[1.02] relative">
                <div class="absolute top-0 right-0 -mr-2 -mt-2 w-12 h-12 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full flex items-center justify-center shadow-md">
                    <i class="fas fa-crown text-white text-lg"></i>
                </div>
                <div class="flex items-center gap-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-yellow-400 to-orange-400 rounded-xl flex items-center justify-center shadow-lg ring-2 ring-white ring-offset-2 ring-offset-yellow-100">
                        <span class="text-3xl font-black text-white">1</span>
                    </div>
                    <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-y-3 gap-x-6">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-0.5">Nama Peminjam</p>
                            <p class="text-xl font-bold text-gray-900">Muhamad Aulia</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-0.5">Kelas</p>
                            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-semibold bg-purple-100 text-purple-800">
                                <i class="fas fa-graduation-cap mr-2 text-purple-600"></i>Kelas 6
                            </span>
                        </div>
                        <div class="md:col-span-2"> {{-- Spans across two columns on medium screens and up --}}
                            <p class="text-sm text-gray-500 mb-0.5">Total Peminjaman</p>
                            <div class="flex items-center gap-3">
                                <i class="fas fa-books text-blue-600 text-xl"></i>
                                <p class="text-3xl font-extrabold text-blue-700">10</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 rounded-2xl shadow-md border border-gray-200 p-7 hover:shadow-lg transition-all duration-300 transform hover:translate-x-1">
                <div class="flex items-center gap-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-gray-300 to-gray-400 rounded-xl flex items-center justify-center shadow-md ring-2 ring-white ring-offset-2 ring-offset-gray-100">
                        <span class="text-3xl font-black text-gray-700">2</span>
                    </div>
                    <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-y-3 gap-x-6">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-0.5">Nama Peminjam</p>
                            <p class="text-xl font-bold text-gray-900">Putri Nazma</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-0.5">Kelas</p>
                            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-semibold bg-purple-100 text-purple-800">
                                <i class="fas fa-graduation-cap mr-2 text-purple-600"></i>Kelas 6
                            </span>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-sm text-gray-500 mb-0.5">Total Peminjaman</p>
                            <div class="flex items-center gap-3">
                                <i class="fas fa-books text-blue-600 text-xl"></i>
                                <p class="text-3xl font-extrabold text-blue-700">7</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 rounded-2xl shadow-md border border-gray-200 p-7 hover:shadow-lg transition-all duration-300 transform hover:translate-x-1">
                <div class="flex items-center gap-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-amber-300 to-amber-400 rounded-xl flex items-center justify-center shadow-md ring-2 ring-white ring-offset-2 ring-offset-gray-100">
                        <span class="text-3xl font-black text-amber-700">3</span>
                    </div>
                    <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-y-3 gap-x-6">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-0.5">Nama Peminjam</p>
                            <p class="text-xl font-bold text-gray-900">Yulia Nabila</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-0.5">Kelas</p>
                            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-semibold bg-purple-100 text-purple-800">
                                <i class="fas fa-graduation-cap mr-2 text-purple-600"></i>Kelas 5
                            </span>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-sm text-gray-500 mb-0.5">Total Peminjaman</p>
                            <div class="flex items-center gap-3">
                                <i class="fas fa-books text-blue-600 text-xl"></i>
                                <p class="text-3xl font-extrabold text-blue-700">5</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const toast = document.getElementById('toast-alert');
        if (toast) {
            toast.classList.remove('opacity-0', '-translate-y-4');
            toast.classList.add('opacity-100', 'translate-y-0');

            setTimeout(() => {
                toast.classList.remove('opacity-100', 'translate-y-0');
                toast.classList.add('opacity-0', '-translate-y-4');
            }, 3000);
        }
    });
</script>
<script>
    document.getElementById('confirm-exit').addEventListener('click', function () {
        document.getElementById('logout-form').submit();
    });
</script>

@endpush