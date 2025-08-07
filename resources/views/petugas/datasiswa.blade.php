@extends('layouts.petugas')

@section('title', 'Data Siswa')

@push('modals')
    @include('components.modal-ubah-sandi')
    @include('components.modal-keluar')
    {{-- modal siswa --}}
    @include('components.datasiswa.modal-tambah-siswa')
    @include('components.datasiswa.modal-edit-siswa')
    @include('components.datasiswa.modal-hapus-siswa')
    @include('components.datasiswa.modal-import-siswa')
    {{-- modal siswa --}}
@endpush


@section('content')
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
    <div class="mb-6">
        <h3 class="text-3xl font-bold text-gray-900 mb-6">Data Keanggotaan Perpustakaan</h3>

        <div class="flex flex-col lg:flex-row lg:items-center gap-4 w-full justify-between mb-6">
            <div class="flex-grow">
                {{-- Form Pencarian --}}
                <form action="{{ route('petugas.datasiswa') }}" method="GET" class="relative w-64">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text" id="search" name="search"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 block w-full pl-12 pr-4 py-3 shadow-sm transition-all duration-200 placeholder-gray-400"
                        placeholder="Cari siswa berdasarkan..." value="{{ request('search') }}">
                    {{-- Tambahkan tombol submit jika belum ada, atau enter akan submit form --}}
                    <button type="submit" class="absolute inset-y-0 right-0 px-4 flex items-center bg-blue-500 text-white rounded-r-xl hover:bg-blue-600 transition-colors duration-200" style="display:none;">
                        Cari
                    </button>
                </form>
            </div>

            <div class="flex items-center gap-4">
                <button data-modal-target="importDataModal" data-modal-toggle="importDataModal" type="button"
                    class="bg-green-600 text-white font-semibold rounded-xl px-6 py-3 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5">
                    <i class="fas fa-file-import mr-2"></i>Import Data Anggota
                </button>
                <button data-modal-target="tambahDataModal" data-modal-toggle="tambahDataModal" type="button"
                    class="bg-blue-600 text-white font-semibold rounded-xl px-6 py-3 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5">
                    <i class="fas fa-plus mr-2"></i>Tambah Data Anggota
                </button>
            </div>
        </div>
    </div> <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h4 class="text-lg font-semibold text-gray-800">Daftar Anggota</h4>
                <span class="text-sm text-gray-500">{{ count($students) }} anggota terdaftar</span>
            </div>
        </div>
        <div class="overflow-x-auto pb-6">
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
                                <span>No Anggota</span>
                            </div>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            <div class="flex items-center space-x-1">
                                <span>Nama Anggota</span>
                            </div>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            <div class="flex items-center space-x-1">
                                <span>Jenis Kelamin</span>
                            </div>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            <div class="flex items-center space-x-1">
                                <span>Keanggotaan</span>
                            </div>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            <div class="flex items-center space-x-1">
                                <span>No HP</span>
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
                    @foreach ($students as $index => $student)
                        <tr
                            class="group hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 transition-all duration-300">

                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-2 text-sm font-medium text-gray-800">
                                    {{ $students->firstItem() + $index }}
                                </div>
                            </td>

                            {{-- NIS --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-id-card text-gray-800 text-sm"></i>
                                    <span class="text-sm font-medium text-gray-800">{{ $student->no_anggota }}</span>
                                </div>
                            </td>

                            {{-- Nama --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-user-graduate text-gray-800 text-sm"></i>
                                    <span class="text-sm font-medium text-gray-800">{{ $student->nama_anggota }}</span>
                                </div>
                            </td>

                            {{-- Jenis Kelamin --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-2">
                                    @if ($student->jenis_kelamin == 'Laki-laki' || $student->jenis_kelamin == 'L')
                                        <i class="fas fa-mars text-gray-800 text-sm"></i>
                                        <span class="text-sm font-medium text-gray-800">Laki-laki</span>
                                    @else
                                        <i class="fas fa-venus text-gray-800 text-sm"></i>
                                        <span class="text-sm font-medium text-gray-800">Perempuan</span>
                                    @endif
                                </div>
                            </td>


                            {{-- Kelas --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-chalkboard-teacher text-gray-800 text-sm"></i>
                                    <span class="text-sm font-medium text-gray-800">
                                        {{ strtolower($student->keanggotaan) === 'guru' ? 'Guru' : 'Siswa ' . $student->keanggotaan }}
                                    </span>
                                </div>
                </td>

                            {{-- No Hp --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-phone text-gray-800 text-sm"></i>
                                    <span class="text-sm font-medium text-gray-800">{{ $student->nohp_anggota }}</span>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex space-x-2">
                                    <button onclick="prepareEditModal({{ json_encode($student) }})"
                                        data-modal-target="editDataModal" data-modal-toggle="editDataModal"
                                        class="flex items-center gap-2 bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-lg transition-all duration-300 transform hover:scale-105 hover:shadow-lg"
                                        title="Edit Siswa">
                                        <i class="fas fa-edit text-sm"></i>
                                    </button>

                                    <button onclick="setDeleteId('{{ $student->no_anggota }}')" data-modal-target="deleteModal"
                                        data-modal-toggle="deleteModal"
                                        class="flex items-center gap-2 bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg transition-all duration-300 transform hover:scale-105 hover:shadow-lg"
                                        title="Hapus Siswa">
                                        <i class="fas fa-trash text-sm"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

{{-- Pagination Modern --}}
@if ($students->hasPages())
    <div class="flex flex-col items-center mt-8 space-y-1">
        {{-- Info Halaman --}}
        <div class="text-sm text-gray-600">
            Menampilkan <span class="font-medium">{{ $students->firstItem() ?? 0 }}-{{ $students->lastItem() ?? 0 }}</span>
            dari <span class="font-medium">{{ $students->total() }}</span> anggota
        </div>

        {{-- Navigasi Desktop --}}
        <nav class="flex items-center justify-center">
            <div class="flex items-center  space-x-1">
                {{-- Tombol Sebelumnya --}}
                @if ($students->onFirstPage())
                    <span class="px-3 py-2 text-sm text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                        ← Sebelumnya
                    </span>
                @else
                    <a href="{{ $students->previousPageUrl() }}{{ request()->getQueryString() ? '&' . http_build_query(request()->except('page')) : '' }}"
                       class="px-3 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                        ← Sebelumnya
                    </a>
                @endif

                {{-- Nomor Halaman --}}
                <div class="flex items-center space-x-1 mx-4">
                    @php
                        $start = max(1, $students->currentPage() - 2);
                        $end = min($students->lastPage(), $students->currentPage() + 2);
                    @endphp

                    @if ($start > 1)
                        <a href="{{ $students->url(1) }}{{ request()->getQueryString() ? '&' . http_build_query(request()->except('page')) : '' }}"
                           class="w-8 h-8 flex items-center justify-center text-sm text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50 transition">
                            1
                        </a>
                        @if ($start > 2)
                            <span class="px-2 text-gray-400">...</span>
                        @endif
                    @endif

                    @for ($page = $start; $page <= $end; $page++)
                        @if ($page == $students->currentPage())
                            <span class="w-8 h-8 flex items-center justify-center text-sm font-medium text-white bg-blue-600 rounded">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $students->url($page) }}{{ request()->getQueryString() ? '&' . http_build_query(request()->except('page')) : '' }}"
                               class="w-8 h-8 flex items-center justify-center text-sm text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50 transition">
                                {{ $page }}
                            </a>
                        @endif
                    @endfor

                    @if ($end < $students->lastPage())
                        @if ($end < $students->lastPage() - 1)
                            <span class="px-2 text-gray-400">...</span>
                        @endif
                        <a href="{{ $students->url($students->lastPage()) }}{{ request()->getQueryString() ? '&' . http_build_query(request()->except('page')) : '' }}"
                           class="w-8 h-8 flex items-center justify-center text-sm text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50 transition">
                            {{ $students->lastPage() }}
                        </a>
                    @endif
                </div>

                {{-- Tombol Berikutnya --}}
                @if ($students->hasMorePages())
                    <a href="{{ $students->nextPageUrl() }}{{ request()->getQueryString() ? '&' . http_build_query(request()->except('page')) : '' }}"
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

        {{-- Navigasi Mobile --}}
        <div class="sm:hidden flex items-center justify-center space-x-4">
            @if (!$students->onFirstPage())
                <a href="{{ $students->previousPageUrl() }}{{ request()->getQueryString() ? '&' . http_build_query(request()->except('page')) : '' }}"
                   class="w-10 h-10 flex items-center justify-center text-gray-700 bg-white border border-gray-300 rounded-full hover:bg-gray-50">
                    ←
                </a>
            @endif

            <span class="text-sm text-gray-600 px-4 py-2 bg-gray-100 rounded-full">
                {{ $students->currentPage() }} / {{ $students->lastPage() }}
            </span>

            @if ($students->hasMorePages())
                <a href="{{ $students->nextPageUrl() }}{{ request()->getQueryString() ? '&' . http_build_query(request()->except('page')) : '' }}"
                   class="w-10 h-10 flex items-center justify-center text-gray-700 bg-white border border-gray-300 rounded-full hover:bg-gray-50">
                    →
                </a>
            @endif
        </div>
    </div>
@endif

            {{-- Empty State --}}
            @if ($students->isEmpty())
                <div class="text-center py-16">
                    <div class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <i class="fas fa-users-slash text-gray-400 text-3xl"></i>
                    </div>

                    @if(request('search'))
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Data Tidak Ditemukan</h3>
                        <p class="text-gray-500 mb-6">
                            Tidak ada anggota yang cocok dengan kata kunci: 
                            <span class="font-semibold text-blue-600 bg-blue-50 px-2 py-1 rounded-lg">"{{ request('search') }}"</span>
                        </p>
                        <a href="{{ route('petugas.datasiswa') }}"
                            class="bg-gradient-to-r from-gray-200 to-gray-300 text-gray-800 font-semibold rounded-xl px-6 py-3 shadow-lg hover:shadow-xl hover:from-gray-300 hover:to-gray-400 transition-all duration-300 transform hover:-translate-y-0.5">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali ke semua data
                        </a>
                    @else
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Data Anggota</h3>
                        <p class="text-gray-500 mb-6">Silakan tambahkan anggota pertama untuk memulai</p>
                        <button data-modal-target="tambahDataModal" data-modal-toggle="tambahDataModal"
                            class="bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-xl px-6 py-3 shadow-lg hover:shadow-xl hover:from-blue-700 hover:to-purple-700 transition-all duration-300 transform hover:-translate-y-0.5">
                            <i class="fas fa-plus mr-2"></i>Tambah Anggota Pertama
                        </button>
                    @endif
                </div>
            @endif

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Function to prepare edit modal with student data
        function prepareEditModal(student) {
            document.getElementById('edit-no_anggota').value = student.no_anggota;
            document.getElementById('edit-nama_anggota').value = student.nama_anggota;
            document.getElementById('edit-jenis_kelamin').value = student.jenis_kelamin;
            document.getElementById('edit-keanggotaan').value = student.keanggotaan;
            document.getElementById('edit-nohp_anggota').value = student.nohp_anggota;

            const form = document.getElementById('edit-form');
            form.action = `/petugas/datasiswa/${student.no_anggota}`;
            const editModal = new Flowbite.Modal(document.getElementById('editDataModal'));
            editModal.show();
        }

        // Function to set student ID for deletion
        function setDeleteId(no_anggota) {
            document.getElementById('delete-form').action = '/petugas/datasiswa/' + no_anggota;
        }

        // Script untuk mempertahankan nilai pencarian setelah refresh halaman
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search');
            const urlParams = new URLSearchParams(window.location.search);
            const searchTerm = urlParams.get('search');
            if (searchTerm) {
                searchInput.value = searchTerm;
            }
        });

        // Auto submit form ketika user mengetik (opsional - dengan debounce)
        let searchTimeout;
        document.getElementById('search').addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                this.form.submit();
            }, 500); // Submit setelah 500ms user berhenti mengetik
        });

    </script>
@endpush