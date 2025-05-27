@extends('layouts.petugas')

@section('title', 'Beranda')

@push('modals')
    @include('components.modal-ubah-sandi')
    @include('components.modal-keluar')
@endpush

@section('content')



 @push('toasts')
<div id="toast-alert"
     class="fixed inset-x-0 top-6 mx-auto z-50 flex items-center gap-3 w-fit max-w-lg p-4 text-green-600 bg-green-100 border border-green-300 rounded-xl shadow-lg
     opacity-0 -translate-y-4 transition-all duration-500 ease-out"
     style="z-index: 99999;">
    <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
    </svg>
    <div class="text-sm font-medium">
        <span class="font-bold">Selamat Datang Petugas {{ session('user')['name'] ?? 'name' }}!</span>
    </div>
</div>
@endpush


    <!-- Card Data -->
    <div class="p-4 bg-white rounded-xl shadow-lg mb-6 border border-gray-200">
        <div class="grid grid-cols-3 gap-4 mb-4 ">
            <div class="flex items-center justify-center h-32 rounded-lg bg-blue-100 p-6 shadow-md transition-all duration-300 hover:scale-105 cursor-pointer transform-gpu origin-center">
                <div class="text-center">
                    <h2 class="text-xl font-bold text-black mb-2">42</h2>
                    <p class="text-sm font-medium text-black">Total Buku</p>
                </div>
            </div>
            <div class="flex items-center justify-center h-32 rounded-lg bg-yellow-100 p-6 shadow-md transition-transform duration-300 hover:scale-105 cursor-pointer transform-gpu origin-center">
                <div class="text-center">
                    <h2 class="text-xl font-bold text-black mb-2">16</h2>
                    <p class="text-sm font-medium text-black">Buku Dipinjam</p>
                </div>
            </div>
            <div class="flex items-center justify-center h-32 rounded-lg bg-green-100 p-6 shadow-md transition-transform duration-300 hover:scale-105 cursor-pointer transform-gpu origin-center">
                <div class="text-center">
                    <h2 class="text-xl font-bold text-black mb-2">8</h2>
                    <p class="text-sm font-medium text-black">Buku Dikembalikan</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Card Tabel Aktivitas Terbaru -->
    <div class="p-4 bg-white rounded-xl shadow-lg mb-6 border border-gray-200">
        <div class="mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Aktivitas Terbaru</h3>
        </div>
        <div class="grid grid-cols-1 gap-4 mb-4">
            <div class="w-full overflow-x-auto">
                <table class="w-full text-sm text-left rtl:text-right text-black dark:text-black border-2 border-gray-300 dark:border-gray-700">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-black">
                        <tr>
                            <th scope="col" class="px-6 py-3 border-b border-gray-300 dark:border-gray-600">Aktivitas</th>
                            <th scope="col" class="px-6 py-3 border-b border-gray-300 dark:border-gray-600">Pengguna</th>
                            <th scope="col" class="px-6 py-3 border-b border-gray-300 dark:border-gray-600">Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white dark:bg-gray-800">
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white border-b border-gray-300 dark:border-gray-600">
                                Meminjam Buku "Matahari"</td>
                            <td class="px-6 py-4 font-medium border-b border-gray-300 dark:border-gray-600">Riansyah</td>
                            <td class="px-6 py-4 font-medium border-b border-gray-300 dark:border-gray-600">32 menit yang lalu</td>
                        </tr>
                        <tr class="bg-white dark:bg-gray-800">
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white border-b border-gray-300 dark:border-gray-600">
                                Mengembalikan Buku "Bulan"</td>
                            <td class="px-6 py-4 font-medium border-b border-gray-300 dark:border-gray-600">Putra Maulana</td>
                            <td class="px-6 py-4 font-medium border-b border-gray-300 dark:border-gray-600">1 jam yang lalu</td>
                        </tr>
                        <tr class="bg-white dark:bg-gray-800">
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white border-b border-gray-300 dark:border-gray-600">
                                Menambahkan Buku "Harmoni"</td>
                            <td class="px-6 py-4 font-medium border-b border-gray-300 dark:border-gray-600">Rafif Ruhul Haqq</td>
                            <td class="px-6 py-4 font-medium border-b border-gray-300 dark:border-gray-600">2 jam yang lalu</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Card Tabel Peminjam Terbanyak -->
    <div class="p-4 bg-white rounded-xl shadow-lg mb-6 border border-gray-200">
        <div class="mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Peminjam Terbanyak</h3>
        </div>
        <div class="grid grid-cols-1 gap-4 mb-4">
            <div class="w-full overflow-x-auto">
                <table class="w-full text-sm text-left rtl:text-right text-black dark:text-black border-2 border-gray-300 dark:border-gray-700">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-black">
                        <tr>
                            <th scope="col" class="px-6 py-3 border-b border-gray-300 dark:border-gray-600">Nama Siswa</th>
                            <th scope="col" class="px-6 py-3 border-b border-gray-300 dark:border-gray-600">Kelas</th>
                            <th scope="col" class="px-6 py-3 border-b border-gray-300 dark:border-gray-600">Jumlah Buku</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white dark:bg-gray-800">
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white border-b border-gray-300 dark:border-gray-600">
                                Muhamad Aulia <img src="{{ asset('images/gold.png') }}" alt="Icon" class="h-5 w-5 ml-2 inline"></td>
                            <td class="px-6 py-4 font-medium border-b border-gray-300 dark:border-gray-600">6</td>
                            <td class="px-6 py-4 font-medium border-b border-gray-300 dark:border-gray-600">10 Buku</td>
                        </tr>
                        <tr class="bg-white dark:bg-gray-800">
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white border-b border-gray-300 dark:border-gray-600">
                                Putri Nazma <img src="{{ asset('images/silver.png') }}" alt="Icon" class="h-5 w-5 ml-2 inline"></td>
                            <td class="px-6 py-4 font-medium border-b border-gray-300 dark:border-gray-600">6</td>
                            <td class="px-6 py-4 font-medium border-b border-gray-300 dark:border-gray-600">7 Buku</td>
                        </tr>
                        <tr class="bg-white dark:bg-gray-800">
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white border-b border-gray-300 dark:border-gray-600">
                                Yulia Nabila <img src="{{ asset('images/bronze.png') }}" alt="Icon" class="h-5 w-5 ml-2 inline"></td>
                            <td class="px-6 py-4 font-medium border-b border-gray-300 dark:border-gray-600">5</td>
                            <td class="px-6 py-4 font-medium border-b border-gray-300 dark:border-gray-600">5 Buku</td>
                        </tr>
                    </tbody>
                </table>
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
@endpush