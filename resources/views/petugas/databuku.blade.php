@extends('layouts.petugas')

@section('title', 'Data Buku')

@push('modals')
    @include('components.modal-ubah-sandi')
    @include('components.modal-keluar')
    
    {{-- modal buku --}}
    @include('components.buku.modal-tambah-buku')
    @include('components.buku.modal-detail-buku')
    @include('components.buku.modal-edit-buku')
@endpush

@section('content')
<div class="mb-4">
    <h3 class="text-2xl font-semibold text-gray-800 mb-4">Data Buku</h3>
    <!-- Search & Filter -->
    <div class="flex flex-col sm:flex-row sm:items-center gap-3 w-full justify-between">
        <!-- Left: Search & Dropdowns -->
        <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto flex-grow">
            <!-- Search Bar -->
            <div class="relative w-full sm:w-64">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i class="fas fa-search text-gray-500"></i>
                </div>
                <input type="text" id="search"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                    placeholder="Cari buku...">
            </div>

            <!-- Category Filter -->
            <select id="filter-kategori"
                class="w-28 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                <option selected disabled>Kategori</option>
                <option value="pelajaran">Pelajaran</option>
                <option value="fiksi">Fiksi</option>
                <option value="nonfiksi">Non Fiksi</option>
            </select>

            <!-- Class Filter -->
            <select id="filter-kelas"
                class="w-28 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                <option selected disabled>Kelas</option>
                <option value="6">Kelas 6</option>
                <option value="5">Kelas 5</option>
                <option value="4">Kelas 4</option>
                <option value="3">Kelas 3</option>
                <option value="2">Kelas 2</option>
                <option value="1">Kelas 1</option>
            </select>
        </div>

        <!-- Right: Add Button -->
        <button data-modal-target="crud-modal" data-modal-toggle="crud-modal" type="button"
            class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-800">
            + Tambah
        </button>
    </div>
</div>


<div class="p-4 bg-white rounded-xl shadow-lg mb-6 border border-gray-200">
    <div class="grid grid-cols-5 gap-4 mb-4">
        @foreach($buku as $bukus)
            <div
                onclick="openDetailModal({
                    image: '{{ asset($bukus->gambar) }}',
                    isbn: '{{ $bukus->isbn }}',
                    title: '{{ $bukus->judul }}',
                    author: '{{ $bukus->penulis }}',
                    publisher: '{{ $bukus->penerbit }}',
                    year: '{{ $bukus->tahun_terbit }}',
                    stock: '{{ $bukus->stok }}',
                    description: `{{ $bukus->sinopsis }}`.replace(/\n/g, '<br>')
                })"
                data-modal-target="detailModal"
                data-modal-toggle="detailModal"
                class="flex items-center justify-center flex-col rounded-lg bg-white-100 p-4 shadow-md transition-all duration-300 hover:scale-105 cursor-pointer transform-gpu origin-center"
            >
                <img src="{{ asset($bukus->gambar) }}" alt="{{ $bukus->judul }}" class="h-32 object-cover rounded-md">
                <p class="mt-2 text-sm text-center text-gray-700">{{ $bukus->judul }}</p>
            </div>
        @endforeach
    </div>
</div>

        
@endsection

@push('scripts')
<script>
    // Function to open detail modal
    function openDetailModal(data) {
        // Fill modal with data
        document.getElementById('modalImage').src = data.image;
        document.getElementById('modalIsbn').textContent = data.isbn;
        document.getElementById('modalTitle').textContent = data.title;
        document.getElementById('modalAuthor').textContent = data.author;
        document.getElementById('modalPublisher').textContent = data.publisher;
        document.getElementById('modalYear').textContent = data.year;
        document.getElementById('modalStock').textContent = data.stock;
        document.getElementById('modalDescription').textContent = data.description;

        // Store data for edit modal
        window.currentBookData = data;

        // Show detail modal
        const detailModal = new Flowbite.Modal(document.getElementById('detailModal'));
        detailModal.show();

        // Setup edit button
        const editButton = document.getElementById('editBookBtn');
        if (editButton) {
            editButton.onclick = function() {
                detailModal.hide();
                setTimeout(() => prepareEditModal(), 300);
            };
        }
    }

    // Function to prepare edit modal
    function prepareEditModal() {
        const data = window.currentBookData;
        if (!data) return;

        // Fill edit form fields
        document.getElementById('edit-isbn').value = data.isbn;
        document.getElementById('edit-judul_buku').value = data.title;
        document.getElementById('edit-penulis').value = data.author;
        document.getElementById('edit-penerbit').value = data.publisher;
        document.getElementById('edit-tahun_terbit').value = data.year;
        document.getElementById('edit-stok').value = data.stock;
        document.getElementById('edit-sinopsis').value = data.description;
        document.getElementById('editFotoPreview').src = data.image;

        // Show edit modal
        const editModal = new Flowbite.Modal(document.getElementById('editbuku'));
        editModal.show();
    }
</script>
@endpush