@extends('layouts.petugas')
@section('title', 'Riwayat Aktivitas')
@push('modals')
    @include('components.modal-ubah-sandi')
    @include('components.modal-keluar')
@endpush

@section('content')
<div class="mb-6">
    <h3 class="text-3xl font-bold text-gray-900 mb-6">Riwayat Aktivitas</h3>
    <div class="flex flex-col lg:flex-row lg:items-center gap-4 w-full justify-between mb-6">
        <div class="flex flex-col sm:flex-row gap-4 w-full lg:w-auto flex-grow">
            <div class="relative w-full sm:w-80">
                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="text" id="search"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 block w-full pl-12 pr-4 py-3 shadow-sm transition-all duration-200 placeholder-gray-400"
                    placeholder="Cari aktivitas...">
            </div>
        </div>
        <form method="GET" action="{{ route('petugas.riwayat') }}" class="flex gap-2">
            <div class="relative w-full sm:w-48">
                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                    <i class="fas fa-calendar-alt text-gray-400"></i>
                </div>
                <input type="date" id="dateFilter" name="filter_date"
                    value="{{ request('filter_date') }}"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 block w-full pl-12 pr-4 py-3 shadow-sm transition-all duration-200 placeholder-gray-400">
            </div>
            <button type="submit" class="px-4 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors duration-200">
                <i class="fas fa-filter"></i>
            </button>
            <a href="{{ route('petugas.riwayat') }}" class="px-4 py-3 bg-gray-500 text-white rounded-xl hover:bg-gray-600 transition-colors duration-200">
                <i class="fas fa-times"></i>
            </a>
        </form>
    </div>
</div>

@if(request('filter_date'))
    <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-xl">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <i class="fas fa-filter text-blue-600 mr-2"></i>
                <span class="text-blue-800 font-medium">
                    Menampilkan aktivitas untuk tanggal: 
                    {{ \Carbon\Carbon::parse(request('filter_date'))->translatedFormat('l, d F Y') }}
                </span>
            </div>
            <a href="{{ route('petugas.riwayat') }}" class="text-blue-600 hover:text-blue-800 transition-colors">
                <i class="fas fa-times"></i> Hapus Filter
            </a>
        </div>
    </div>
@endif

@php
    if (isset($isFiltered) && $isFiltered) {
        // Jika sedang difilter, hanya tampilkan grup hari yang dipilih
        $groups = [
            ['label' => 'Tanggal yang dipilih', 'tanggal' => $today, 'data' => $todayActivities],
        ];
    } else {
        // Tampilan normal (tidak difilter)
        $groups = [
            ['label' => 'Hari ini', 'tanggal' => $today, 'data' => $todayActivities],
            ['label' => 'Kemarin', 'tanggal' => $yesterday, 'data' => $yesterdayActivities],
            ['label' => $previousDay, 'tanggal' => '', 'data' => $previousActivities],
        ];
    }
@endphp

@foreach ($groups as $groupIndex => $group)
<div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100 mb-6 activity-group" data-group="{{ $groupIndex }}">
    <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <h4 class="text-lg font-semibold text-gray-800">{{ $group['label'] }}{{ $group['tanggal'] ? ' - ' . $group['tanggal'] : '' }}</h4>
            <span class="text-sm text-gray-500 activity-count">{{ count($group['data']) }} aktivitas</span>
        </div>
    </div>
    <div class="overflow-x-auto">
        @if($group['data']->isEmpty())
        <div class="text-center py-16 empty-state">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-clipboard-list text-gray-400 text-3xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Aktivitas</h3>
            <p class="text-gray-500 mb-6">Tidak ada aktivitas yang tercatat.</p>
        </div>
        @else
<table class="w-full text-left">
    <thead class="bg-gradient-to-r from-gray-100 to-gray-200 text-gray-800 shadow-md rounded-lg overflow-hidden">
        <tr>
            <th class="px-6 py-3 text-sm font-bold uppercase tracking-wider rounded-tl-lg">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-bullhorn text-gray-600"></i>
                    <span>Aktivitas</span>
                </div>
            </th>
            <th class="px-6 py-3 text-sm font-bold uppercase tracking-wider">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-user-friends text-gray-600"></i>
                    <span>Pengguna</span>
                </div>
            </th>
            <th class="px-6 py-3 text-sm font-bold uppercase tracking-wider rounded-tr-lg">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-hourglass-half text-gray-600"></i>
                    <span>Waktu</span>
                </div>
            </th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-100">
        @foreach($group['data'] as $activity)
        <tr class="bg-white hover:bg-blue-50 transition-all duration-300 ease-in-out transform hover:scale-[1.005] hover:shadow-lg rounded-lg activity-row" 
            data-date="{{ \Carbon\Carbon::parse($activity->waktu)->format('Y-m-d') }}"
            data-datetime="{{ $activity->waktu }}">
            <td class="px-6 py-4">
                <div class="flex items-start">
                    <div class="w-9 h-9 flex-shrink-0 bg-blue-100 text-blue-700 rounded-full flex items-center justify-center mr-3 text-lg font-bold">
                        <i class="fas fa-{{ $activity->aksi == 'meminjam' ? 'book-reader' : ($activity->aksi == 'mengembalikan' ? 'undo' : ($activity->aksi == 'menambah' ? 'plus-circle' : ($activity->aksi == 'mengubah' ? 'pen-to-square' : ($activity->aksi == 'menghapus' ? 'trash-alt' : 'info-circle')))) }}"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 text-base leading-tight">
                            {{ ucfirst($activity->aksi) }}
                            <span class="text-blue-600">{{ ' ' . strtoupper($activity->tabel) }}</span>
                        </h4>
                        <p class="text-sm text-gray-500 mt-1">{{ $activity->keterangan }}</p>
                    </div>
                </div>
            </td>
            <td class="px-6 py-4">
                <div class="flex items-center">
                    <div class="w-8 h-8 flex-shrink-0 bg-green-100 text-green-700 rounded-full flex items-center justify-center mr-2 text-sm">
                        <i class="fas fa-user"></i>
                    </div>
                    <span class="text-base text-gray-800 font-medium">{{ $activity->pengguna->username }}</span>
                </div>
            </td>
            <td class="px-6 py-4">
                <div class="flex items-center">
                    <div class="w-8 h-8 flex-shrink-0 bg-purple-100 text-purple-700 rounded-full flex items-center justify-center mr-2 text-sm">
                        <i class="fas fa-clock"></i>
                    </div>
                    <span class="text-base text-gray-800 font-medium">{{ \Carbon\Carbon::parse($activity->waktu)->diffForHumans() }}</span>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="text-center py-16 no-results" style="display: none;">
    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
        <i class="fas fa-search text-gray-400 text-3xl"></i>
    </div>
    <h3 class="text-xl font-semibold text-gray-900 mb-2">Tidak Ada Hasil</h3>
    <p class="text-gray-500 mb-6">Tidak ada aktivitas yang sesuai dengan filter.</p>
</div>
@endif
    </div>
</div>
@endforeach
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search');
        
        // Fungsi untuk memfilter aktivitas (hanya untuk pencarian teks)
        function filterActivities() {
            const searchTerm = searchInput.value.toLowerCase().trim();
            
            // Loop through setiap grup aktivitas
            document.querySelectorAll('.activity-group').forEach(group => {
                const rows = group.querySelectorAll('.activity-row');
                const emptyState = group.querySelector('.empty-state');
                const noResults = group.querySelector('.no-results');
                const table = group.querySelector('table');
                const activityCount = group.querySelector('.activity-count');
                
                let visibleCount = 0;
                let hasOriginalData = rows.length > 0;
                
                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    
                    // Filter berdasarkan pencarian teks
                    const matchesSearch = !searchTerm || text.includes(searchTerm);
                    
                    // Tampilkan row jika cocok dengan filter
                    const shouldShow = matchesSearch;
                    row.style.display = shouldShow ? '' : 'none';
                    
                    if (shouldShow) {
                        visibleCount++;
                    }
                });
                
                // Update tampilan berdasarkan hasil filter
                if (hasOriginalData) {
                    if (visibleCount === 0) {
                        // Tidak ada hasil yang cocok
                        if (table) table.style.display = 'none';
                        if (emptyState) emptyState.style.display = 'none';
                        if (noResults) noResults.style.display = 'block';
                    } else {
                        // Ada hasil yang cocok
                        if (table) table.style.display = '';
                        if (emptyState) emptyState.style.display = 'none';
                        if (noResults) noResults.style.display = 'none';
                    }
                } else {
                    // Grup tidak memiliki data asli (kosong)
                    if (emptyState) emptyState.style.display = 'block';
                    if (noResults) noResults.style.display = 'none';
                }
                
                // Update counter
                if (activityCount) {
                    activityCount.textContent = `${visibleCount} aktivitas`;
                }
            });
        }
        
        // Event listener untuk pencarian
        if (searchInput) {
            searchInput.addEventListener('input', filterActivities);
        }
    });
</script>
@endpush