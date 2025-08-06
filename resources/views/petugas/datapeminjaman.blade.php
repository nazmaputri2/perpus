@extends('layouts.petugas')
@section('title', 'Data Peminjaman')
@push('modals')
    @include('components.modal-ubah-sandi')
    @include('components.modal-keluar')
    @include('components.datapeminjaman.modal-export-data')
@endpush
@section('content')
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        @php
            // Pastikan $stats selalu memiliki nilai default jika belum didefinisikan
            $stats = $stats ?? ['total' => 0, 'dipinjam' => 0, 'terlambat' => 0, 'selesaiHariIni' => 0];
            // Ambil filter aktif dari request
            $currentFilter = request('status');
        @endphp
        
        <!-- Card: Total Peminjaman -->
        <a href="{{ route('petugas.datapeminjaman', ['status' => 'total'] + request()->only(['search'])) }}" 
           class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300 cursor-pointer {{ $currentFilter === 'total' ? 'ring-2 ring-blue-500 border-blue-300' : '' }}">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Sudah Dikembalikan</p>
                    <p class="text-3xl font-bold text-blue-600">{{ $stats['total'] }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-book text-blue-600"></i>
                </div>
            </div>
            @if($currentFilter === 'total')
                <div class="mt-2 text-xs text-blue-600 font-medium">
                    <i class="fas fa-filter mr-1"></i>Filter Aktif
                </div>
            @endif
        </a>

        <!-- Card: Sedang Dipinjam -->
        <a href="{{ route('petugas.datapeminjaman', ['status' => 'Dipinjam'] + request()->only(['search'])) }}" 
           class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300 cursor-pointer {{ $currentFilter === 'Dipinjam' ? 'ring-2 ring-yellow-500 border-yellow-300' : '' }}">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Sedang Dipinjam</p>
                    <p class="text-3xl font-bold text-yellow-600">{{ $stats['dipinjam'] }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-clock text-yellow-600"></i>
                </div>
            </div>
            @if($currentFilter === 'Dipinjam')
                <div class="mt-2 text-xs text-yellow-600 font-medium">
                    <i class="fas fa-filter mr-1"></i>Filter Aktif
                </div>
            @endif
        </a>

        <!-- Card: Terlambat -->
        <a href="{{ route('petugas.datapeminjaman', ['status' => 'Terlambat'] + request()->only(['search'])) }}" 
           class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300 cursor-pointer {{ $currentFilter === 'Terlambat' ? 'ring-2 ring-red-500 border-red-300' : '' }}">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Terlambat</p>
                    <p class="text-3xl font-bold text-red-600">{{ $stats['terlambat'] }}</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-red-600"></i>
                </div>
            </div>
            @if($currentFilter === 'Terlambat')
                <div class="mt-2 text-xs text-red-600 font-medium">
                    <i class="fas fa-filter mr-1"></i>Filter Aktif
                </div>
            @endif
        </a>

        <!-- Card: Selesai Hari Ini -->
        <a href="{{ route('petugas.datapeminjaman', ['status' => 'SelesaiHariIni'] + request()->only(['search'])) }}" 
           class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300 cursor-pointer {{ $currentFilter === 'SelesaiHariIni' ? 'ring-2 ring-green-500 border-green-300' : '' }}">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Selesai Hari Ini</p>
                    <p class="text-3xl font-bold text-green-600">{{ $stats['selesaiHariIni'] }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600"></i>
                </div>
            </div>
            @if($currentFilter === 'SelesaiHariIni')
                <div class="mt-2 text-xs text-green-600 font-medium">
                    <i class="fas fa-filter mr-1"></i>Filter Aktif
                </div>
            @endif
        </a>
    </div>

    <!-- Filter Status Indicator -->
    @if($currentFilter)
        <div class="bg-blue-50 border border-blue-200 rounded-2xl p-4 mb-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <i class="fas fa-filter text-blue-600 mr-2"></i>
                    <span class="text-blue-800 font-medium">
                        Filter Aktif: 
                        @switch($currentFilter)
                            @case('total')
                                Semua Data Peminjaman
                                @break
                            @case('Dipinjam')
                                Sedang Dipinjam
                                @break
                            @case('Terlambat')
                                Terlambat
                                @break
                            @case('SelesaiHariIni')
                                Selesai Hari Ini
                                @break
                        @endswitch
                    </span>
                </div>
                <a href="{{ route('petugas.datapeminjaman', request()->only(['search'])) }}" 
                   class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                    <i class="fas fa-times mr-1"></i>Hapus Filter
                </a>
            </div>
        </div>
    @endif

    <!-- Action Panel -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 mb-8">
        <div class="flex flex-col lg:flex-row justify-between items-center gap-6">
            <!-- Navigation Pills -->
            <div class="flex bg-gray-100 rounded-2xl p-2">
                <a href="{{ route('petugas.datapeminjaman') }}"
                    class="px-6 py-3 bg-blue-600 text-white rounded-xl font-medium shadow-md">
                    <i class="fas fa-list mr-2"></i>Peminjaman
                </a>
                <a href="{{ route('petugas.statistik') }}"
                    class="px-6 py-3 text-gray-600 hover:text-gray-900 rounded-xl font-medium transition-colors">
                    <i class="fas fa-chart-line mr-2"></i>Statistik
                </a>
            </div>
            <!-- Search & Actions -->
            <div class="flex items-center gap-4">
                <form method="GET" action="{{ route('petugas.datapeminjaman') }}" class="relative flex items-center w-80">

                    <!-- Pertahankan filter status jika ada -->
                    @if($currentFilter)
                        <input type="hidden" name="status" value="{{ $currentFilter }}">
                    @endif
                    <span class="absolute left-4 text-gray-400">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="pl-12 pr-4 py-3 w-full bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                        placeholder="Cari peminjam / siswa / buku"
                        onkeypress="if(event.key === 'Enter') this.form.submit();">
                </form>
               <button type="button"
    data-modal-target="exportPeminjamanModal"
    data-modal-toggle="exportPeminjamanModal"
    class="flex items-center gap-2 px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-2xl font-medium transition-colors shadow-md">
    <i class="fas fa-download"></i>
    Export Peminjaman
</button>

            </div>
        </div>
    </div>

    <!-- Data Cards Layout -->
    <div class="space-y-4">
        {{-- Judul akan diperbarui secara dinamis --}}
        <h3 class="text-2xl font-bold text-gray-900 mb-6" id="peminjaman-filter-title">
            @if($currentFilter)
                @switch($currentFilter)
                    @case('total')
                        Semua Data Peminjaman
                        @break
                    @case('Dipinjam')
                        Peminjaman Sedang Berjalan
                        @break
                    @case('Terlambat')
                        Peminjaman Terlambat
                        @break
                    @case('SelesaiHariIni')
                        Peminjaman Selesai Hari Ini
                        @break
                    @default
                        Peminjaman Aktif
                @endswitch
            @else
                Semua Data Peminjaman
            @endif
        </h3>

        @forelse ($peminjaman as $data)
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-all duration-300 group">
                <div class="flex items-center gap-6">
                    <!-- Book Image -->
                    <div class="relative">
                        <img src="{{ $data->buku->gambar ?? 'https://via.placeholder.com/150x220?text=No+Cover' }}"
                            alt="Cover Buku"
                            class="w-20 h-28 object-cover rounded-xl shadow-md group-hover:shadow-lg transition-shadow">
                        @if ($data->status_peminjaman === 'Dipinjam')
                            <div class="absolute -top-2 -right-2 w-6 h-6 bg-yellow-400 rounded-full flex items-center justify-center">
                                <i class="fas fa-clock text-white text-xs"></i>
                            </div>
                        @elseif ($data->status_peminjaman === 'Terlambat')
                            <div class="absolute -top-2 -right-2 w-6 h-6 bg-red-400 rounded-full flex items-center justify-center">
                                <i class="fas fa-exclamation-triangle text-white text-xs"></i>
                            </div>
                        @endif
                    </div>

                    <!-- Book & Student Info -->
                    <div class="flex-1">
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            <!-- Student Details -->
                            <div class="space-y-3">
                                <div>
                                    <p class="text-sm text-gray-500 mb-1">Nama Peminjam</p>
                                    <p class="text-lg font-semibold text-gray-900">{{ $data->siswa->nama_siswa }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 mb-1">Judul Buku</p>
                                    <p class="text-md font-medium text-gray-800">{{ $data->buku->judul }}</p>
                                </div>
                                <div class="flex items-center gap-4">
                                    <div>
                                        <p class="text-sm text-gray-500">NIS</p>
                                        <p class="font-medium text-gray-900">{{ $data->siswa->nis_siswa }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Kelas</p>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                                            {{ $data->siswa->kelas_siswa }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Date Information -->
                            <div class="space-y-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                                        <i class="fas fa-calendar-plus text-green-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Tanggal Pinjam</p>
                                        <p class="font-semibold text-gray-900">
                                            {{ $data->tanggal_peminjaman ? \Carbon\Carbon::parse($data->tanggal_peminjaman)->translatedFormat('d F Y') : 'Belum ditentukan' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center">
                                        <i class="fas fa-calendar-times text-red-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Batas Kembali</p>
                                        <p class="font-semibold text-gray-900">
                                            {{ $data->tanggal_pengembalian ? \Carbon\Carbon::parse($data->tanggal_pengembalian)->translatedFormat('d F Y') : 'Belum ditentukan' }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Status & Actions -->
                            <div class="flex flex-col justify-between">
                                <div class="mb-4">
                                    <p class="text-sm text-gray-500 mb-2">Status Peminjaman</p>
                                    @php
                                        $statusMap = [
                                            'Proses' => [
                                                'bg' => 'bg-gray-100 text-gray-800 border-gray-200',
                                                'icon' => 'fa-spinner',
                                            ],
                                            'Dipinjam' => [
                                                'bg' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                                'icon' => 'fa-hourglass-half',
                                            ],
                                            'Terlambat' => [
                                                'bg' => 'bg-red-100 text-red-800 border-red-200',
                                                'icon' => 'fa-exclamation-circle',
                                            ],
                                            'Dikembalikan' => [
                                                'bg' => 'bg-green-100 text-green-800 border-green-200',
                                                'icon' => 'fa-check-circle',
                                            ],
                                        ];
                                        $status = $statusMap[$data->status_peminjaman] ?? $statusMap['Proses'];
                                    @endphp
                                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium {{ $status['bg'] }} border">
                                        <i class="fas {{ $status['icon'] }} mr-2"></i>
                                        {{ $data->status_peminjaman }}
                                    </span>
@if ($data->keterangan)
    <p class="text-sm mt-1 
        {{ str_contains(strtolower($data->keterangan), 'terlambat') ? 'text-red-600' : 'text-blue-600' }}">
        {{ $data->keterangan }}
    </p>
@endif
                                </div>
                                <div class="flex gap-3">
                                    @if ($data->status_peminjaman === 'Proses')
                                        <form action="{{ route('peminjaman.updateStatus', $data->id_peminjaman) }}" method="POST">
                                            @csrf @method('PUT')
                                            <input type="hidden" name="aksi" value="setujui">
                                            <button class="flex-1 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-xl font-medium">
                                                <i class="fas fa-check mr-2"></i> Setujui
                                            </button>
                                        </form>
                                    @elseif (in_array($data->status_peminjaman, ['Dipinjam', 'Terlambat']))
                                        <form action="{{ route('peminjaman.updateStatus', $data->id_peminjaman) }}" method="POST">
                                            @csrf @method('PUT')
                                            <input type="hidden" name="aksi" value="selesai">
                                            <button class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-medium">
                                                <i class="fas fa-check-double mr-2"></i> Tandai Selesai
                                            </button>
                                        </form>
                                    @endif
                                    @if (!in_array($data->status_peminjaman, ['Dikembalikan']))
                                        <form action="{{ route('peminjaman.updateStatus', $data->id_peminjaman) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin membatalkan peminjaman ini?')">
                                            @csrf @method('PUT')
                                            <input type="hidden" name="aksi" value="batal">
                                            <button class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-xl font-medium">
                                                <i class="fas fa-times mr-1"></i> Batal
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-12 text-center">
                <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-book-open text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">
                    @if($currentFilter)
                        Tidak Ada Data untuk Filter Ini
                    @else
                        Belum Ada Peminjaman
                    @endif
                </h3>
                <p class="text-gray-600 mb-6">
                    @if($currentFilter)
                        Tidak ada data peminjaman yang sesuai dengan filter yang dipilih.
                    @else
                        Tidak ada data peminjaman yang tersedia.
                    @endif
                </p>
                @if($currentFilter)
                    <a href="{{ route('petugas.datapeminjaman') }}" 
                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors">
                        <i class="fas fa-list mr-2"></i>Tampilkan Semua Data
                    </a>
                @endif
            </div>
        @endforelse
    </div>
    
<!-- Pagination -->
@if ($peminjaman->hasPages())
    <div class="flex flex-col items-center mt-8 space-y-1">
        {{-- Info Halaman --}}
        <div class="text-sm text-gray-600">
            Menampilkan <span class="font-medium">{{ $peminjaman->firstItem() ?? 0 }}-{{ $peminjaman->lastItem() ?? 0 }}</span>
            dari <span class="font-medium">{{ $peminjaman->total() }}</span> peminjaman
        </div>

        {{-- Navigation --}}
        <nav class="flex items-center justify-center">
            <div class="flex items-center space-x-1">
                {{-- Tombol Sebelumnya --}}
                @if ($peminjaman->onFirstPage())
                    <span class="px-3 py-2 text-sm text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                        ← Sebelumnya
                    </span>
                @else
                    <a href="{{ $peminjaman->previousPageUrl() }}{{ request()->getQueryString() ? '&' . http_build_query(request()->except('page')) : '' }}"
                       class="px-3 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                        ← Sebelumnya
                    </a>
                @endif

                {{-- Nomor Halaman --}}
                <div class="flex items-center space-x-1 mx-4">
                    @php
                        $start = max(1, $peminjaman->currentPage() - 2);
                        $end = min($peminjaman->lastPage(), $peminjaman->currentPage() + 2);
                    @endphp

                    {{-- Halaman pertama jika tidak terlihat --}}
                    @if ($start > 1)
                        <a href="{{ $peminjaman->url(1) }}{{ request()->getQueryString() ? '&' . http_build_query(request()->except('page')) : '' }}"
                           class="w-8 h-8 flex items-center justify-center text-sm text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50 transition-colors duration-200">
                            1
                        </a>
                        @if ($start > 2)
                            <span class="px-2 text-gray-400">...</span>
                        @endif
                    @endif

                    {{-- Halaman di sekitar halaman aktif --}}
                    @for ($page = $start; $page <= $end; $page++)
                        @if ($page == $peminjaman->currentPage())
                            <span class="w-8 h-8 flex items-center justify-center text-sm font-medium text-white bg-blue-600 rounded">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $peminjaman->url($page) }}{{ request()->getQueryString() ? '&' . http_build_query(request()->except('page')) : '' }}"
                               class="w-8 h-8 flex items-center justify-center text-sm text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50 transition-colors duration-200">
                                {{ $page }}
                            </a>
                        @endif
                    @endfor

                    {{-- Halaman terakhir jika tidak terlihat --}}
                    @if ($end < $peminjaman->lastPage())
                        @if ($end < $peminjaman->lastPage() - 1)
                            <span class="px-2 text-gray-400">...</span>
                        @endif
                        <a href="{{ $peminjaman->url($peminjaman->lastPage()) }}{{ request()->getQueryString() ? '&' . http_build_query(request()->except('page')) : '' }}"
                           class="w-8 h-8 flex items-center justify-center text-sm text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50 transition-colors duration-200">
                            {{ $peminjaman->lastPage() }}
                        </a>
                    @endif
                </div>

                {{-- Tombol Berikutnya --}}
                @if ($peminjaman->hasMorePages())
                    <a href="{{ $peminjaman->nextPageUrl() }}{{ request()->getQueryString() ? '&' . http_build_query(request()->except('page')) : '' }}"
                       class="px-3 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                        Berikutnya →
                    </a>
                @else
                    <span class="px-3 py-2 text-sm text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                        Berikutnya →
                    </span>
                @endif
            </div>
        </nav>

        {{-- Mobile Responsive - Versi Sederhana untuk Layar Kecil --}}
        <div class="sm:hidden flex items-center justify-center space-x-4">
            {{-- Previous Mobile --}}
            @if (!$peminjaman->onFirstPage())
                <a href="{{ $peminjaman->previousPageUrl() }}{{ request()->getQueryString() ? '&' . http_build_query(request()->except('page')) : '' }}"
                   class="w-10 h-10 flex items-center justify-center text-gray-700 bg-white border border-gray-300 rounded-full hover:bg-gray-50">
                    ←
                </a>
            @endif

            {{-- Current Page Info --}}
            <span class="text-sm text-gray-600 px-4 py-2 bg-gray-100 rounded-full">
                {{ $peminjaman->currentPage() }} / {{ $peminjaman->lastPage() }}
            </span>

            {{-- Next Mobile --}}
            @if ($peminjaman->hasMorePages())
                <a href="{{ $peminjaman->nextPageUrl() }}{{ request()->getQueryString() ? '&' . http_build_query(request()->except('page')) : '' }}"
                   class="w-10 h-10 flex items-center justify-center text-gray-700 bg-white border border-gray-300 rounded-full hover:bg-gray-50">
                    →
                </a>
            @endif
        </div>
    </div>
@endif
@endsection

@push('scripts')
    <script>
        // Fungsi untuk export data
        function exportData() {
            const urlParams = new URLSearchParams(window.location.search);
            const statusFilter = urlParams.get('status');
            const searchTerm = urlParams.get('search');
            
            // Placeholder untuk fitur export
            let message = 'Fitur ekspor belum diimplementasikan.\n\n';
            message += 'Data yang akan diekspor:\n';
            message += '- Filter Status: ' + (statusFilter || 'Semua') + '\n';
            message += '- Pencarian: ' + (searchTerm || 'Tidak ada') + '\n';
            
            alert(message);
            
            // TODO: Implementasi actual export functionality
            // fetch('/petugas/datapeminjaman/export?' + urlParams.toString())
            //     .then(response => response.blob())
            //     .then(blob => {
            //         const url = window.URL.createObjectURL(blob);
            //         const a = document.createElement('a');
            //         a.style.display = 'none';
            //         a.href = url;
            //         a.download = 'data-peminjaman.xlsx';
            //         document.body.appendChild(a);
            //         a.click();
            //         window.URL.revokeObjectURL(url);
            //     });
        }

        // Sidebar toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const sidebar = document.getElementById('logo-sidebar');
            
            if (sidebarToggle && sidebar) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('-translate-x-full');
                });
            }
        });
    </script>
@endpush