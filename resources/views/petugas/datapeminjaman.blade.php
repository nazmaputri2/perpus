
@extends('layouts.petugas')
@section('title', 'Data Peminjaman')
@push('modals')
    @include('components.modal-ubah-sandi')
    @include('components.modal-keluar')
@endpush
        @section('content')
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                @php
                    $stats = $stats ?? ['total' => 0, 'dipinjam' => 0, 'terlambat' => 0, 'selesaiHariIni' => 0];
                @endphp
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
                        <a href="{{ route('petugas.datapeminjaman') }}" class="px-6 py-3 bg-blue-600 text-white rounded-xl font-medium shadow-md">
                            <i class="fas fa-list mr-2"></i>Peminjaman
                        </a>
                        <a href="{{ route('petugas.statistik') }}"
                            class="px-6 py-3 text-gray-600 hover:text-gray-900 rounded-xl font-medium transition-colors">
                            <i class="fas fa-chart-line mr-2"></i>Statistik
                        </a>
                    </div>
                    <!-- Search & Actions -->
                    <div class="flex items-center gap-4">
                        <div class="relative">
                            <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="text" id="search"
                                class="pl-12 pr-4 py-3 w-80 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Cari peminjaman...">
                        </div>
                        <button
                            class="flex items-center gap-2 px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-2xl font-medium transition-colors shadow-md">
                            <i class="fas fa-download"></i>
                            Export Data
                        </button>
                    </div>
                </div>
            </div>

            <!-- Data Cards Layout -->
            <div class="space-y-4">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Peminjaman Aktif</h3>

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
                                            <p class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($data->tanggal_peminjaman)->translatedFormat('d F Y') }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center">
                                            <i class="fas fa-calendar-times text-red-600"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Batas Kembali</p>
                                            <p class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($data->tanggal_pengembalian)->translatedFormat('d F Y') }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Status & Actions -->
                                <div class="flex flex-col justify-between">
                                    <div class="mb-4">
                                        <p class="text-sm text-gray-500 mb-2">Status Peminjaman</p>
                                        @php
                                        $statusMap = [
                                            'Dipinjam' => ['bg' => 'bg-yellow-100 text-yellow-800 border-yellow-200', 'icon' => 'fa-hourglass-half'],
                                            'Terlambat' => ['bg' => 'bg-red-100 text-red-800 border-red-200', 'icon' => 'fa-exclamation-circle'],
                                            'Dikembalikan' => ['bg' => 'bg-green-100 text-green-800 border-green-200', 'icon' => 'fa-check-circle'],
                                        ];
                                            $status = $statusMap[$data->status_peminjaman] ?? $statusMap['Dipinjam'];
                                        @endphp
                                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium {{ $status['bg'] }} border">
                                            <i class="fas {{ $status['icon'] }} mr-2"></i>
                                            {{ $data->status_peminjaman }}
                                        </span>
                                        @if ($data->keterangan)
    <p class="text-sm text-red-600 mt-1">{{ $data->keterangan }}</p>
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
                <form action="{{ route('peminjaman.updateStatus', $data->id_peminjaman) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan peminjaman ini?')">
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
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Peminjaman</h3>
                    <p class="text-gray-600 mb-6">Tidak ada data peminjaman yang tersedia.</p>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if(method_exists($peminjaman, 'links'))
            <div class="mt-8">
                {{ $peminjaman->links('components.pagination') }}
            </div>
            @endif
        @endsection
@push('scripts')

<script>
        function toggleStatus(button) {
            const card = button.closest('.bg-white');
            const statusBadge = card.querySelector('.bg-yellow-100');
            // Update status badge
            statusBadge.className = 'inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-green-100 text-green-800 border border-green-200';
            statusBadge.innerHTML = '<i class="fas fa-check-circle mr-2"></i>Selesai';
            // Update button
            button.innerHTML = '<i class="fas fa-undo mr-2"></i>Batalkan';
            button.className = 'flex-1 px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-xl font-medium transition-colors shadow-md';
            // Update progress bar
            const progressBar = card.querySelector('.bg-gradient-to-r');
            progressBar.style.width = '100%';
            progressBar.className = 'bg-gradient-to-r from-green-500 to-emerald-500 h-2 rounded-full';
            // Update duration text
            const durationText = card.querySelector('.text-sm.font-medium.text-gray-900');
            durationText.textContent = 'Selesai';
        }
        // Search functionality
        document.getElementById('search').addEventListener('input', function (e) {
            const searchTerm = e.target.value.toLowerCase();
            const cards = document.querySelectorAll('.bg-white.rounded-2xl.shadow-lg:not(.text-center)');
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

<script>
    function toggleStatus(button) {
        const currentText = button.textContent.trim();
        if (currentText === 'Proses') {
            button.textContent = 'Selesai';
            button.classList.remove('bg-yellow-400', 'hover:bg-yellow-500');
            button.classList.add('bg-green-400', 'hover:bg-green-500');
        } else {
            button.textContent = 'Proses';
            button.classList.remove('bg-green-400', 'hover:bg-green-500');
            button.classList.add('bg-yellow-400', 'hover:bg-yellow-500');
        }
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('search');
        searchInput.addEventListener('input', function () {
            const filter = searchInput.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                let match = false;
                cells.forEach(cell => {
                    if (cell.textContent.toLowerCase().includes(filter)) {
                        match = true;
                    }
                });
                row.style.display = match ? '' : 'none';
            });
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const exportButton = document.querySelector('button[type="button"]');
        exportButton.addEventListener('click', function () {
            alert('Fitur ekspor belum tersedia.');
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const datepickerEl = document.querySelector('[datepicker]');
        if (datepickerEl) {
            new Datepicker(datepickerEl, {
                format: 'dd/mm/yyyy',
                autohide: true
            });
        }
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const sidebar = document.getElementById('logo-sidebar');
        sidebarToggle.addEventListener('click', function () {
            sidebar.classList.toggle('-translate-x-full');
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.getElementById('logo-sidebar');
        const sidebarToggle = document.getElementById('sidebar-toggle');
        sidebarToggle.addEventListener('click', function () {
            sidebar.classList.toggle('-translate-x-full');
        });
    });
</script>
