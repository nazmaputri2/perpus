@extends('layouts.petugas')
@section('title', 'Data Petugas')
@push('modals')
    @include('components.modal-ubah-sandi')
    @include('components.modal-keluar')
    {{-- modal siswa --}}
    @include('components.datapetugas.modal-tambah-petugas')
    @include('components.datapetugas.modal-edit-petugas')
    @include('components.datapetugas.modal-hapus-petugas')

    {{-- @include('components.datasiswa.modal-edit-siswa')
    @include('components.datasiswa.modal-hapus-siswa') --}}
@endpush
@section('content')
    {{-- BLOK EROR: Disesuaikan dengan gaya modern --}}
    @if ($errors->any())
        <div
            class="bg-gradient-to-r from-red-50 to-red-100 border border-red-200 text-red-700 px-6 py-4 rounded-xl mb-6 shadow-lg">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-red-500 text-xl"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-semibold">Oops! Ada kesalahan:</h3>
                    <ul class="mt-2 text-sm list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif
    {{-- HEADER: Disesuaikan dengan gaya modern --}}
    <div class="mb-6">
        <h3 class="text-3xl font-bold text-gray-900 mb-6">Data Petugas</h3>
        <div class="flex flex-col lg:flex-row lg:items-center gap-4 w-full justify-between mb-6">
            <div class="flex-grow">
                <div class="relative w-full lg:w-80">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text" id="search"
                        class="bg-gray-50 border border-gray-300  text-gray-900 text-sm rounded-xl focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 block w-full pl-12 pr-4 py-3 shadow-sm transition-all duration-200 placeholder-gray-400"
                        placeholder="Cari petugas berdasarkan...">
                </div>
            </div>
            <button data-modal-target="tambahDataModal" data-modal-toggle="tambahDataModal" type="button"
                class="bg-blue-600 text-white font-semibold rounded-xl px-6 py-3 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5">
                <i class="fas fa-plus mr-2"></i>Tambah Petugas
            </button>
        </div>
    </div>
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h4 class="text-lg font-semibold text-gray-800">Daftar Petugas</h4>
                {{-- Menggunakan variabel $petugas untuk menghitung data --}}
                <span class="text-sm text-gray-500">{{ count($petugas) }} petugas terdaftar</span>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            <div class="flex items-center space-x-1">
                                <span>No</span>
                            </div>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            <div class="flex items-center space-x-1">
                                <span>NIP</span>
                            </div>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            <div class="flex items-center space-x-1">
                                <span>Nama Petugas</span>
                            </div>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            <div class="flex items-center space-x-1">
                                <span>No HP</span>
                            </div>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            <div class="flex items-center space-x-1">
                                <span>Alamat</span>
                            </div>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            <div class="flex items-center space-x-1">
                                <span>Aksi</span>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    {{-- Menambahkan $index untuk penomoran --}}
                    @foreach ($petugas as $index => $staf)
                        <tr
                            class="group hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 transition-all duration-300">
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-2 text-sm font-medium text-gray-800">
                                    {{ $index + 1 }}
                                </div>
                            </td>
                            {{-- NIP --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-id-card text-gray-800 text-sm"></i>
                                    <span class="text-sm font-medium text-gray-800">{{ $staf->nip }}</span>
                                </div>
                            </td>
                            {{-- Isi dari Nama Petugas --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-2">
                                    <div class="flex-shrink-0 h-5 w-10 flex items-center justify-center">
                                        <i class="fas fa-user-tie text-gray-800"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-800 transition-colors duration-200">
                                            {{ $staf->nama }}
                                        </h4>
                                    </div>
                                </div>
                            </td>
                            {{-- Isi dari No HP --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-phone text-gray-800"></i>
                                    <span class="text-sm font-medium text-gray-800">{{ $staf->nohp }}</span>
                                </div>
                            </td>
                            {{-- Isi dari Alamat --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-map-marker-alt text-gray-800"></i>
                                    <span
                                        class="text-sm font-medium text-gray-800">{{ Str::limit($staf->alamat, 25) }}</span>
                                </div>
                            </td>
                            {{-- Isi dari Aksi --}}
                            <td class="px-6 py-4">
                                <div class="flex space-x-2">
                                    {{-- Tombol Edit --}}
                                    <button onclick="prepareEditModal({{ json_encode($staf) }})"
                                        data-modal-target="editDataModal" data-modal-toggle="editDataModal"
                                        class="flex items-center gap-2 bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-lg transition-all duration-300 transform hover:scale-105 hover:shadow-lg"
                                        title="Edit Petugas">
                                        <i class="fas fa-edit text-sm"></i>
                                    </button>
                                    {{-- Tombol Hapus --}}
                                    <button onclick="setDeleteId({{ $staf->nip }})" data-modal-target="deleteModal"
                                        data-modal-toggle="deleteModal"
                                        class="flex items-center gap-2 bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg transition-all duration-300 transform hover:scale-105 hover:shadow-lg"
                                        title="Hapus Petugas">
                                        <i class="fas fa-trash text-sm"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- BLOK DATA KOSONG: Disesuaikan dengan gaya modern --}}
            @if ($petugas->isEmpty())
                <div class="text-center py-16">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-user-shield text-gray-400 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Data Petugas</h3>
                    <p class="text-gray-500 mb-6">Silakan tambahkan petugas pertama untuk memulai</p>
                    <button data-modal-target="tambahDataModal" data-modal-toggle="tambahDataModal"
                        class="bg-blue-600 text-white font-semibold rounded-xl px-6 py-3 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5">
                        <i class="fas fa-plus mr-2"></i>Tambah Petugas Pertama
                    </button>
                </div>
            @endif
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        // Function to prepare edit modal with student data
        function prepareEditModal(staf) {
            document.getElementById('edit-nip').value = staf.nip;
            document.getElementById('edit-nama').value = staf.nama;
            document.getElementById('edit-nohp').value = staf.nohp;
            document.getElementById('edit-alamat').value = staf.alamat;

            const form = document.getElementById('edit-form');
            form.action = `/petugas/datapetugas/${staf.nip}`;
            const editModal = new Flowbite.Modal(document.getElementById('editDataModal'));
            editModal.show();
        }
        // Function to set student ID for deletion
        function setDeleteId(nip) {
            document.getElementById('delete-form').action = '/petugas/datapetugas/' + nip;
        }
    </script>
@endpush
