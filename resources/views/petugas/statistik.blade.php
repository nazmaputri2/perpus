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
                    <p class="text-3xl font-bold text-blue-600">{{ $stats['total'] }}</p>
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
                    <p class="text-3xl font-bold text-yellow-600">{{ $stats['dipinjam'] }}</p>
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
                    <p class="text-3xl font-bold text-red-600">{{ $stats['terlambat'] }}</p>
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
                    <p class="text-3xl font-bold text-green-600">{{ $stats['selesaiHariIni'] }}</p>
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
                <div class="relative">
                    <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="text" id="search"
                        class="pl-12 pr-4 py-3 w-80 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                        placeholder="Cari statistik...">
                </div>
                <a href="{#}"
                    class="flex items-center gap-2 px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-2xl font-medium transition-colors shadow-md">
                    <i class="fas fa-download"></i>
                    Export Data
                </a>
            </div>
        </div>
    </div>
    <!-- Statistik Cards Layout -->
    <div class="space-y-6">
        <h3 class="text-2xl font-bold text-gray-900 mb-6">Peminjam Terbanyak - Januari 2025</h3>
        <!-- Filter Section -->
        <form method="GET" action="{{ route('petugas.statistik') }}">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 mb-6">
                <div class="flex flex-col sm:flex-row gap-4 items-center justify-between">
                    <h4 class="text-lg font-semibold text-gray-800">Filter Statistik</h4>
                    <div class="flex gap-4">
                        <!-- Filter Kelas -->
                        <select name="kelas" onchange="this.form.submit()"
                            class="px-4 py-3 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <option disabled {{ request('kelas') ? '' : 'selected' }}>Pilih Kelas</option>
                            @foreach ($daftarKelas as $kls)
                                <option value="{{ $kls }}" {{ request('kelas') == $kls ? 'selected' : '' }}>Kelas {{ $kls }}
                                </option>
                            @endforeach
                        </select>
                        <!-- Filter Bulan -->
                        <select name="bulan" onchange="this.form.submit()"
                            class="px-4 py-3 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <option disabled {{ request('bulan') ? '' : 'selected' }}>Pilih Bulan</option>
                            @foreach (["januari", "februari", "maret", "april", "mei", "juni", "juli", "agustus", "september", "oktober", "november", "desember"] as $bln)
                                <option value="{{ $bln }}" {{ request('bulan') == $bln ? 'selected' : '' }}>{{ ucfirst($bln) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </form>
        @forelse ($peminjamTerbanyak as $index => $siswa)
            @php
                $rank = $index + 1;
                $warna = match ($rank) {
                    1 => ['bg' => 'from-yellow-50 to-orange-50', 'border' => 'border-yellow-200', 'text' => 'text-yellow-600', 'icon' => 'fa-crown', 'img' => 'gold.png'],
                    2 => ['bg' => 'from-gray-50 to-slate-50', 'border' => 'border-gray-200', 'text' => 'text-gray-600', 'icon' => 'fa-medal', 'img' => 'silver.png'],
                    3 => ['bg' => 'from-orange-50 to-amber-50', 'border' => 'border-orange-200', 'text' => 'text-orange-600', 'icon' => 'fa-award', 'img' => 'bronze.png'],
                    default => ['bg' => 'white', 'border' => 'border-gray-100', 'text' => 'text-gray-700', 'icon' => null, 'img' => null]
                };
            @endphp
            <!-- Ranking Cards -->
            <div class="space-y-4">
                <!-- Rank 1 - Gold -->
                <div
                    class="bg-gradient-to-r from-gray-50 to-orange-50 rounded-2xl shadow-lg border border-gray-200 p-6 hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center gap-6">
                        <!-- Rank Badge -->
                        <div class="relative">
                            <div
                                class="w-16 h-16  {{ $rank <= 3 ? 'bg-gradient-to-r' : 'bg-gray-100' }} rounded-2xl flex items-center justify-center shadow-lg">
                                @if ($warna['icon'])
                                    <i class="fas {{ $warna['icon'] }} text-white text-2xl"></i>
                                @else
                                    <span class="text-2xl font-bold text-gray-600">{{ $rank }}</span>
                                @endif
                            </div>
                            <div
                                class="absolute -top-2 -right-2 w-8 h-8 bg-gray-500 rounded-full flex items-center justify-center">
                                <span class="text-white font-bold text-sm">{{ $rank }}</span>
                            </div>
                        </div>
                        <!-- Student Info -->
                        <div class="flex-1">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="text-xl font-bold text-gray-900 mb-1">{{ $siswa->nama_siswa }}</h4>
                                    <div class="flex items-center gap-4">
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                                            Kelas {{ $siswa->kelas_siswa }}
                                        </span>
                                        <span class="text-gray-600">NIS: {{ $siswa->nis_siswa }}</span>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-3xl font-bold {{ $warna['text'] ?? 'text-gray-700' }} mb-1">
                                        {{ $siswa->jumlah }}
                                    </p>
                                    <p class="text-sm text-gray-600">Buku Dipinjam</p>
                                </div>
                            </div>
                        </div>
                        <!-- Trophy Icon -->
                        @if ($warna['img'])
                            <div class="w-12 h-12">
                                <img src="{{ asset('images/' . $warna['img']) }}" alt="Trophy" class="w-full h-full object-contain">
                            </div>
                        @endif
                    </div>
                </div>
        @empty

                <!-- Empty State -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-12 text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-chart-bar text-gray-400 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Data Statistik</h3>
                    <p class="text-gray-600 mb-6">Tidak ada data statistik yang sesuai dengan filter yang dipilih.</p>
                    <a href="{{ route('petugas.statistik') }}"
                        class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-xl font-medium transition-colors">
                        <i class="fas fa-refresh mr-2"></i>
                        Reset Filter
                    </a>
                </div>
            @endforelse

            <script>
                // Filter functionality
                document.getElementById('filter-kelas').addEventListener('change', function () {
                    // Add filter logic here
                    console.log('Filter kelas:', this.value);
                });
                document.getElementById('filter-bulan').addEventListener('change', function () {
                    // Add filter logic here
                    console.log('Filter bulan:', this.value);
                });
                // Search functionality
                document.getElementById('search').addEventListener('input', function (e) {
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