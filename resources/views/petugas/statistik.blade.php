@extends('layouts.petugas')
@section('title', 'Statistik')
@push('modals')
    @include('components.modal-ubah-sandi')
    @include('components.modal-keluar')
@endpush
@section('content')
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Peminjaman</p>
                    <p class="text-3xl font-bold text-blue-600">1,234</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-book text-blue-600"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Sedang Dipinjam</p>
                    <p class="text-3xl font-bold text-yellow-600">89</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-clock text-yellow-600"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Terlambat</p>
                    <p class="text-3xl font-bold text-red-600">12</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-red-600"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Selesai Hari Ini</p>
                    <p class="text-3xl font-bold text-green-600">45</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600"></i>
                </div>
            </div>
        </div>
    </div>
    <!-- Action Panel -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 mb-8">
        <div class="flex flex-col lg:flex-row justify-between items-center gap-6">
            <!-- Navigation Pills -->
            <div class="flex bg-gray-100 rounded-2xl p-2">
                <a href="{{ route('petugas.datapeminjaman') }}"
                    class="px-6 py-3 text-gray-600 hover:text-gray-900 rounded-xl font-medium transition-colors">
                    <i class="fas fa-list mr-2"></i>Peminjaman
                </a>
                <a href="{{ route('petugas.statistik') }}"
                    class="px-6 py-3 bg-green-600 text-white rounded-xl font-medium shadow-md">
                    <i class="fas fa-chart-line mr-2"></i>Statistik
                </a>
            </div>
            <!-- Search & Actions -->
            <div class="flex items-center gap-4">
                <div class="relative flex items-center w-80">
                    <span class="absolute left-4 text-gray-400">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" id="search"
                        class="pl-12 pr-4 py-3 w-full bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                        placeholder="Cari statistik...">
                </div>
                <button
                    class="flex items-center gap-2 px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-2xl font-medium transition-colors shadow-md">
                    <i class="fas fa-download"></i>
                    Export Data
                </button>
            </div>
        </div>
    </div>
    <!-- Statistik Cards Layout -->
    <div class="space-y-6">
        <h3 class="text-2xl font-bold text-gray-900 mb-6">Peminjam Terbanyak - Januari 2025</h3>
        <!-- Filter Section -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 mb-6">
            <div class="flex flex-col sm:flex-row gap-4 items-center justify-between">
                <h4 class="text-lg font-semibold text-gray-800">Filter Statistik</h4>
                <div class="flex gap-4">
                    <!-- Filter Kelas -->
                    <select id="filter-kelas"
                        class="w-28 px-4 py-3 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <option selected disabled>Pilih Kelas</option>
                        <option value="1">Kelas 1</option>
                        <option value="2">Kelas 2</option>
                        <option value="3">Kelas 3</option>
                        <option value="4">Kelas 4</option>
                        <option value="5">Kelas 5</option>
                        <option value="6">Kelas 6</option>
                    </select>
                    <!-- Filter Bulan -->
                    <select id="filter-bulan"
                        class="w-28 px-4 py-3 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <option selected disabled>Pilih Bulan</option>
                        <option value="januari">Januari</option>
                        <option value="februari">Februari</option>
                        <option value="maret">Maret</option>
                        <option value="april">April</option>
                        <option value="mei">Mei</option>
                        <option value="juni">Juni</option>
                        <option value="juli">Juli</option>
                        <option value="agustus">Agustus</option>
                        <option value="september">September</option>
                        <option value="oktober">Oktober</option>
                        <option value="november">November</option>
                        <option value="desember">Desember</option>
                    </select>
                </div>
            </div>
        </div>
        <!-- Ranking Cards -->
        <div class="space-y-4">
            <!-- Rank 1 - Gold -->
            <div
                class="bg-gradient-to-r from-gray-50 to-orange-50 rounded-2xl shadow-lg border border-gray-200 p-6 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center gap-6">
                    <!-- Rank Badge -->
                    <div class="relative">
                        <div
                            class="w-16 h-16 bg-gradient-to-r bg-gray-100 rounded-2xl flex items-center justify-center shadow-lg">
                            <img src="/images/gold.png" alt="Rank 1" class="w-8 h-8 object-contain">
                        </div>
                        
                    </div>
                    <!-- Student Info -->
                    <div class="flex-1">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-xl font-bold text-gray-900 mb-1">Muhamad Aulia</h4>
                                <div class="flex items-center gap-4">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                                        Kelas 6
                                    </span>
                                    <span class="text-gray-600">NIS: 3312411086</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-3xl font-bold text-gray-600 mb-1">10</p>
                                <p class="text-sm text-gray-600">Buku Dipinjam</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- Rank 2 - Silver -->
            <div
                class="bg-gradient-to-r from-gray-50 to-slate-50 rounded-2xl shadow-lg border border-gray-200 p-6 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center gap-6">
                    <!-- Rank Badge -->
                    <div class="relative">
                        <div
                            class="w-16 h-16 bg-gradient-to-r bg-gray-100 rounded-2xl flex items-center justify-center shadow-lg">
                            <img src="/images/silver.png" alt="Rank 1" class="w-8 h-8 object-contain">
                        </div>
                    </div>
                    <!-- Student Info -->
                    <div class="flex-1">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-xl font-bold text-gray-900 mb-1">Putri Nazma</h4>
                                <div class="flex items-center gap-4">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                                        Kelas 6
                                    </span>
                                    <span class="text-gray-600">NIS: 3312411087</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-3xl font-bold text-gray-600 mb-1">7</p>
                                <p class="text-sm text-gray-600">Buku Dipinjam</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- Rank 3 - Bronze -->
            <div
                class="bg-gradient-to-r from-orange-50 to-amber-50 rounded-2xl shadow-lg border border-orange-200 p-6 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center gap-6">
                    <!-- Rank Badge -->
                    <div class="relative">
                        <div
                            class="w-16 h-16 bg-gradient-to-r bg-gray-100 rounded-2xl flex items-center justify-center shadow-lg">
                            <img src="/images/bronze.png" alt="Rank 1" class="w-8 h-8 object-contain">
                        </div>
                    </div>
                    <!-- Student Info -->
                    <div class="flex-1">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-xl font-bold text-gray-900 mb-1">Yulia Nabila</h4>
                                <div class="flex items-center gap-4">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                                        Kelas 5
                                    </span>
                                    <span class="text-gray-600">NIS: 3312411088</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-3xl font-bold text-gray-600 mb-1">5</p>
                                <p class="text-sm text-gray-600">Buku Dipinjam</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- Other Rankings -->
            <div
                class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center gap-6">
                    <!-- Rank Badge -->
                    <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center">
                        <span class="text-2xl font-bold text-gray-600">4</span>
                    </div>
                    <!-- Student Info -->
                    <div class="flex-1">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-xl font-semibold text-gray-900 mb-1">Nur Alfi Syahrin</h4>
                                <div class="flex items-center gap-4">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                                        Kelas 5
                                    </span>
                                    <span class="text-gray-600">NIS: 3312411089</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-2xl font-bold text-gray-700 mb-1">3</p>
                                <p class="text-sm text-gray-600">Buku Dipinjam</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div
                class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center gap-6">
                    <!-- Rank Badge -->
                    <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center">
                        <span class="text-2xl font-bold text-gray-600">5</span>
                    </div>
                    <!-- Student Info -->
                    <div class="flex-1">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-xl font-semibold text-gray-900 mb-1">Putra Maulana</h4>
                                <div class="flex items-center gap-4">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                                        Kelas 5
                                    </span>
                                    <span class="text-gray-600">NIS: 3312411090</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-2xl font-bold text-gray-700 mb-1">2</p>
                                <p class="text-sm text-gray-600">Buku Dipinjam</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Empty State (jika diperlukan) -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-12 text-center" style="display: none;">
            <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-chart-bar text-gray-400 text-2xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Data Statistik</h3>
            <p class="text-gray-600 mb-6">Tidak ada data statistik yang sesuai dengan filter yang dipilih.</p>
            <button class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-xl font-medium transition-colors">
                <i class="fas fa-refresh mr-2"></i>
                Refresh Data
            </button>
        </div>
    </div>
    <script>
        // Filter functionality
        document.getElementById('filter-kelas').addEventListener('change', function() {
            // Add filter logic here
            console.log('Filter kelas:', this.value);
        });
        document.getElementById('filter-bulan').addEventListener('change', function() {
            // Add filter logic here
            console.log('Filter bulan:', this.value);
        });
        // Search functionality
        document.getElementById('search').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const cards = document.querySelectorAll('.space-y-4 > div:not(.text-center)');
            cards.forEach(card => {
                const text = card.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    </script>
@endsection
