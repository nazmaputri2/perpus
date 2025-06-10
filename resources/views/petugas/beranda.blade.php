@extends('layouts.petugas')

@section('title', 'Beranda')

@push('modals')
    @include('components.modal-ubah-sandi')
    @include('components.modal-keluar')
@endpush


@section('content')
    <!-- Card Data dengan Glassmorphism Effect -->
    <div class="p-6 bg-white/90 backdrop-blur-xl rounded-2xl shadow-2xl mb-8 border border-white/30">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <!-- Total Buku Card -->
            <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-blue-200 to-blue-300 p-6 shadow-lg transition-all duration-500 hover:scale-105 hover:shadow-2xl cursor-pointer">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-100/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative z-10 text-center">
                    <div class="text-blue-700 text-sm font-medium mb-2 uppercase tracking-wider">Total Buku</div>
                    <div class="text-4xl font-bold text-blue-800 mb-1">42</div>
                    <div class="h-1 w-12 bg-blue-500/40 rounded-full mx-auto group-hover:w-16 transition-all duration-300"></div>
                </div>
                <div class="absolute -top-4 -right-4 w-24 h-24 bg-white/30 rounded-full blur-xl"></div>
            </div>
            <!-- Buku Dipinjam Card -->
            <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-purple-200 to-purple-300 p-6 shadow-lg transition-all duration-500 hover:scale-105 hover:shadow-2xl cursor-pointer">
                <div class="absolute inset-0 bg-gradient-to-br from-purple-100/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative z-10 text-center">
                    <div class="text-purple-700 text-sm font-medium mb-2 uppercase tracking-wider">Buku Dipinjam</div>
                    <div class="text-4xl font-bold text-purple-800 mb-1">16</div>
                    <div class="h-1 w-12 bg-purple-500/40 rounded-full mx-auto group-hover:w-16 transition-all duration-300"></div>
                </div>
                <div class="absolute -top-4 -right-4 w-24 h-24 bg-white/30 rounded-full blur-xl"></div>
            </div>
            <!-- Buku Dikembalikan Card -->
            <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-green-200 to-green-300 p-6 shadow-lg transition-all duration-500 hover:scale-105 hover:shadow-2xl cursor-pointer">
                <div class="absolute inset-0 bg-gradient-to-br from-green-100/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative z-10 text-center">
                    <div class="text-green-700 text-sm font-medium mb-2 uppercase tracking-wider">Buku Dikembalikan</div>
                    <div class="text-4xl font-bold text-green-800 mb-1">8</div>
                    <div class="h-1 w-12 bg-green-500/40 rounded-full mx-auto group-hover:w-16 transition-all duration-300"></div>
                </div>
                <div class="absolute -top-4 -right-4 w-24 h-24 bg-white/30 rounded-full blur-xl"></div>
            </div>
        </div>
    </div>
    <!-- Card Aktivitas Terbaru -->
    <div class="p-6 bg-white/80 backdrop-blur-xl rounded-2xl shadow-2xl mb-8 border border-white/20">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-2xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">
                Aktivitas Terbaru
            </h3>
            <div class="h-2 w-2 bg-emerald-500 rounded-full animate-pulse"></div>
        </div>
        
        <div class="overflow-hidden rounded-xl border border-gray-200/50">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Aktivitas
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Pengguna
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Waktu
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200/50">
                        <tr class="hover:bg-blue-50/50 transition-colors duration-200 group">
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                                    <span class="font-medium text-gray-900 group-hover:text-blue-600 transition-colors">
                                        Meminjam Buku "Matahari"
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    Riansyah
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">32 menit yang lalu</td>
                        </tr>
                        <tr class="hover:bg-green-50/50 transition-colors duration-200 group">
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                    <span class="font-medium text-gray-900 group-hover:text-green-600 transition-colors">
                                        Mengembalikan Buku "Bulan"
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    Putra Maulana
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">1 jam yang lalu</td>
                        </tr>
                        <tr class="hover:bg-purple-50/50 transition-colors duration-200 group">
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-2 h-2 bg-purple-500 rounded-full"></div>
                                    <span class="font-medium text-gray-900 group-hover:text-purple-600 transition-colors">
                                        Menambahkan Buku "Harmoni"
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                                    Rafif Ruhul Haqq
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">2 jam yang lalu</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Card Peminjam Terbanyak dengan Ranking Modern -->
    <div class="p-6 bg-white/80 backdrop-blur-xl rounded-2xl shadow-2xl mb-8 border border-white/20">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-2xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">
                🏆 Peminjam Terbanyak
            </h3>
            <div class="flex space-x-1">
                <div class="w-2 h-2 bg-yellow-400 rounded-full animate-pulse"></div>
                <div class="w-2 h-2 bg-gray-400 rounded-full animate-pulse" style="animation-delay: 0.2s"></div>
                <div class="w-2 h-2 bg-yellow-600 rounded-full animate-pulse" style="animation-delay: 0.4s"></div>
            </div>
        </div>
        
        <div class="space-y-4">
            <!-- Peringkat 1 - Biru -->
            <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-r from-blue-200 to-blue-300 p-6 shadow-lg hover:shadow-2xl transition-all duration-300">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-100/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative z-10 flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center justify-center w-12 h-12 bg-blue-300 rounded-full">
                            <span class="text-2xl">🥇</span>
                        </div>
                        <div>
                            <div class="text-blue-800 font-bold text-lg">Muhamad Aulia</div>
                            <div class="text-blue-600 text-sm">Kelas 6</div>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-blue-800 font-bold text-2xl">10</div>
                        <div class="text-blue-600 text-sm">Buku</div>
                    </div>
                </div>
                <div class="absolute -top-4 -right-4 w-24 h-24 bg-blue-100/30 rounded-full blur-xl"></div>
            </div>
            <!-- Peringkat 2 - Ungu -->
            <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-r from-purple-200 to-purple-300 p-6 shadow-lg hover:shadow-2xl transition-all duration-300">
                <div class="absolute inset-0 bg-gradient-to-r from-purple-100/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative z-10 flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center justify-center w-12 h-12 bg-purple-300 rounded-full">
                            <span class="text-2xl">🥈</span>
                        </div>
                        <div>
                            <div class="text-purple-800 font-bold text-lg">Putri Nazma</div>
                            <div class="text-purple-600 text-sm">Kelas 6</div>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-purple-800 font-bold text-2xl">7</div>
                        <div class="text-purple-600 text-sm">Buku</div>
                    </div>
                </div>
                <div class="absolute -top-4 -right-4 w-24 h-24 bg-purple-100/30 rounded-full blur-xl"></div>
            </div>
            <!-- Peringkat 3 - Hijau -->
            <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-r from-green-200 to-green-300 p-6 shadow-lg hover:shadow-2xl transition-all duration-300">
                <div class="absolute inset-0 bg-gradient-to-r from-green-100/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative z-10 flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center justify-center w-12 h-12 bg-green-300 rounded-full">
                            <span class="text-2xl">🥉</span>
                        </div>
                        <div>
                            <div class="text-green-800 font-bold text-lg">Yulia Nabila</div>
                            <div class="text-green-600 text-sm">Kelas 5</div>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-green-800 font-bold text-2xl">5</div>
                        <div class="text-green-600 text-sm">Buku</div>
                    </div>
                </div>
                <div class="absolute -top-4 -right-4 w-24 h-24 bg-green-100/30 rounded-full blur-xl"></div>
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