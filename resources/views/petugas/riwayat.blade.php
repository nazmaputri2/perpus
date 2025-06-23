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
        <div class="relative w-full sm:w-48">
            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                <i class="fas fa-calendar-alt text-gray-400"></i>
            </div>
            <input datepicker type="text"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 block w-full pl-12 pr-4 py-3 shadow-sm transition-all duration-200 placeholder-gray-400"
                placeholder="Pilih tanggal">
        </div>
    </div>
</div>
@php
    $groups = [
        ['label' => 'Hari ini', 'tanggal' => $today, 'data' => $todayActivities],
        ['label' => 'Kemarin', 'tanggal' => $yesterday, 'data' => $yesterdayActivities],
        ['label' => $previousDay, 'tanggal' => '', 'data' => $previousActivities],
    ];
@endphp
@foreach ($groups as $group)
<div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100 mb-6">
    <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <h4 class="text-lg font-semibold text-gray-800">{{ $group['label'] }}{{ $group['tanggal'] ? ' - ' . $group['tanggal'] : '' }}</h4>
            <span class="text-sm text-gray-500">{{ count($group['data']) }} aktivitas</span>
        </div>
    </div>
    <div class="overflow-x-auto">
        @if($group['data']->isEmpty())
        <div class="text-center py-16">
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
        <tr class="bg-white hover:bg-blue-50 transition-all duration-300 ease-in-out transform hover:scale-[1.005] hover:shadow-lg rounded-lg">
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
 @endif
    </div>
</div>
@endforeach
@endsection
@push('scripts')
<script>
    // Inisialisasi datepicker
    document.addEventListener('DOMContentLoaded', function() {
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
    // Inisialisasi search input
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search');
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const filter = this.value.toLowerCase();
                const rows = document.querySelectorAll('tbody tr');
                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(filter) ? '' : 'none';
                });
            });
        }
    });
</script>
@endpush 
