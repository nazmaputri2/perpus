@extends('layouts.petugas')

@section('title', 'Data Buku')

@push('modals')
    @include('components.modal-ubah-sandi')
    @include('components.modal-keluar')
    {{-- modal buku --}}
    @include('components.buku.modal-tambah-buku')
    @include('components.buku.modal-detail-buku')
    @include('components.buku.modal-edit-buku')
    {{-- Tambahkan modal konfirmasi hapus --}}
    @include('components.buku.modal-hapus-buku')
@endpush

@section('content')
<div class="mb-4">
    <h3 class="text-2xl font-semibold text-gray-800 mb-4">Data Buku</h3>
    <div class="flex flex-col sm:flex-row sm:items-center gap-3 w-full justify-between">
        <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto flex-grow">
            <div class="relative w-full sm:w-64">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i class="fas fa-search text-gray-500"></i>
                </div>
                <input type="text" id="search"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                    placeholder="Cari buku...">
            </div>

            <select id="filter-kategori"
                class="w-28 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                <option value="" selected>Semua Kategori</option> {{-- Tambah opsi "Semua Kategori" --}}
                <option value="Pelajaran">Pelajaran</option>
                <option value="Fiksi">Fiksi</option>
                <option value="Non-Fiksi">Non-Fiksi</option>
            </select>

            <select id="filter-kelas"
                class="w-28 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                <option value="" selected>Semua Kelas</option> {{-- Tambah opsi "Semua Kelas" --}}
                <option value="Tidak Ada">Tidak Ada</option>
                <option value="6">Kelas 6</option>
                <option value="5">Kelas 5</option>
                <option value="4">Kelas 4</option>
                <option value="3">Kelas 3</option>
                <option value="2">Kelas 2</option>
                <option value="1">Kelas 1</option>
            </select>
        </div>

        <button data-modal-target="crud-modal" data-modal-toggle="crud-modal" type="button"
            class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-800">
            + Tambah
        </button>
    </div>
</div>

<div class="p-4 bg-white rounded-xl shadow-lg mb-6 border border-gray-200">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 mb-4" id="book-grid">
        @foreach($buku as $bukus)
            <div
                onclick="openDetailModal({
                    id: '{{ $bukus->isbn }}',
                    // Pastikan URL gambar benar. Jika $bukus->gambar sudah merupakan URL lengkap dari Storage::url(),
                    // maka asset() tidak diperlukan, tapi tidak ada salahnya juga.
                    image: '{{ $bukus->gambar }}', // Asumsikan $bukus->gambar sudah berupa URL lengkap dari Storage::url()
                    isbn: '{{ $bukus->isbn }}',
                    title: '{{ $bukus->judul }}',
                    author: '{{ $bukus->penulis }}',
                    publisher: '{{ $bukus->penerbit }}',
                    year: '{{ $bukus->tahun_terbit }}',
                    stock: '{{ $bukus->stok }}',
                    jenis_buku: '{{ $bukus->jenis_buku }}',
                    kelas: '{{ $bukus->kelas }}',
                    description: `{{ $bukus->sinopsis }}`.replace(/\n/g, '<br>')
                })"
                data-modal-target="detailModal"
                data-modal-toggle="detailModal"
                class="flex items-center justify-center flex-col rounded-lg bg-white-100 p-4 shadow-md transition-all duration-300 hover:scale-105 cursor-pointer transform-gpu origin-center"
            >
                {{-- Gunakan $bukus->gambar secara langsung karena sudah berupa URL --}}
                <img src="{{ $bukus->gambar }}" alt="{{ $bukus->judul }}" class="h-32 object-cover rounded-md">
                <p class="mt-2 text-sm text-center text-gray-700">{{ $bukus->judul }}</p>
            </div>
        @endforeach
    </div>
    @if ($buku->isEmpty())
        <p class="text-center text-gray-600">Tidak ada buku ditemukan.</p>
    @endif
</div>

@endsection

@push('scripts')
<script>
    // Inisialisasi Flowbite Modals (jika belum ada)
    // const Flowbite = require('flowbite'); // Jika menggunakan modul bundler
    // import { Modal } from 'flowbite'; // Jika menggunakan ESM

    function openDetailModal(data) {
        // Isi modal detail
        document.getElementById('modalImage').src = data.image;
        document.getElementById('modalIsbn').textContent = data.isbn;
        document.getElementById('modalTitle').textContent = data.title;
        document.getElementById('modalAuthor').textContent = data.author;
        document.getElementById('modalPublisher').textContent = data.publisher;
        document.getElementById('modalYear').textContent = data.year;
        document.getElementById('modalStock').textContent = data.stock;
        document.getElementById('modalDescription').innerHTML = data.description; // Gunakan innerHTML untuk <br>
        document.getElementById('modalJenisbuku').textContent = data.jenis_buku;
        document.getElementById('modalkelas').textContent = data.kelas;

        window.currentBookData = data; // Simpan data untuk modal edit/delete

        // Tampilkan modal detail menggunakan Flowbite JS (jika tersedia)
        const detailModalElement = document.getElementById('detailModal');
        // Jika Anda menggunakan Flowbite, Anda bisa langsung memanggil show()
        // const detailModal = new Modal(detailModalElement);
        // detailModal.show();
        detailModalElement.classList.remove('hidden'); // Fallback jika Flowbite JS tidak terinisialisasi
        detailModalElement.setAttribute('aria-hidden', 'false');

        // Tombol ubah
        const editButton = document.getElementById('editBookBtn');
        if (editButton) {
            editButton.onclick = function () {
                // Sembunyikan modal detail, lalu tampilkan modal edit
                detailModalElement.classList.add('hidden');
                detailModalElement.setAttribute('aria-hidden', 'true');
                prepareEditModal();
            };
        }

        // Tombol Hapus
        const deleteButton = document.getElementById('deleteBookBtn');
        if (deleteButton) {
            deleteButton.onclick = function () {
                // Sembunyikan modal detail, lalu tampilkan modal hapus
                detailModalElement.classList.add('hidden');
                detailModalElement.setAttribute('aria-hidden', 'true');
                prepareDeleteModal(data.id); // Teruskan ID buku ke modal hapus
            };
        }
    }

    function prepareEditModal() {
    const data = window.currentBookData;
    console.log('Data yang dikirim ke modal edit:', data);
    if (!data) return;

    const editForm = document.getElementById('editBookForm');
    editForm.action = `/petugas/databuku/${data.isbn}`;

    document.getElementById('edit-isbn').value = data.isbn;
    document.getElementById('edit-judul_buku').value = data.title;
    document.getElementById('edit-penulis').value = data.author;
    document.getElementById('edit-penerbit').value = data.publisher;
    document.getElementById('edit-tahun_terbit').value = data.year;
    document.getElementById('edit-stok').value = data.stock;
    document.getElementById('edit-sinopsis').value = data.description.replace(/<br>/g, '\n');
    document.getElementById('editFotoPreview').src = data.image; // Ini akan bekerja jika data.image adalah URL lengkap
    document.getElementById('edit-jenis_buku').value = data.jenis_buku;
    document.getElementById('edit-kelas').value = data.kelas;

    const editModalElement = document.getElementById('editbuku');
    editModalElement.classList.remove('hidden');
    editModalElement.setAttribute('aria-hidden', 'false');
}

    function prepareDeleteModal(bookId) {
        const deleteForm = document.getElementById('deleteBookForm');
        // Sesuaikan dengan rute delete Anda, misalnya 'petugas.databuku.destroy'
        deleteForm.action = `/petugas/databuku/${bookId}`; // Sesuaikan dengan struktur rute Anda

        const deleteModalElement = document.getElementById('deleteConfirmationModal');
        // const deleteModal = new Modal(deleteModalElement);
        // deleteModal.show();
        deleteModalElement.classList.remove('hidden'); // Fallback
        deleteModalElement.setAttribute('aria-hidden', 'false');
    }


    // Fungsi pencarian dan filter (Client-side)
    const searchInput = document.getElementById('search');
    const filterKategori = document.getElementById('filter-kategori');
    const filterKelas = document.getElementById('filter-kelas');
    const bookGrid = document.getElementById('book-grid');

    function applyFilters() {
        const searchTerm = searchInput.value.toLowerCase();
        const selectedKategori = filterKategori.value;
        const selectedKelas = filterKelas.value;

        Array.from(bookGrid.children).forEach(card => {
            const title = card.querySelector('p').textContent.toLowerCase();
            // Anda perlu menyimpan data kategori dan kelas di elemen card juga
            // Misalnya dengan data-attributes
            const bookData = card.onclick.toString().match(/openDetailModal\((.*?)\)/)[1];
            const data = JSON.parse(bookData.replace(/`/g, "'").replace(/'/g, '"')); // Parse JSON string

            const isTitleMatch = title.includes(searchTerm);
            const isKategoriMatch = selectedKategori === "" || data.jenis_buku === selectedKategori;
            const isKelasMatch = selectedKelas === "" || data.kelas === selectedKelas;

            if (isTitleMatch && isKategoriMatch && isKelasMatch) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });

        // Tampilkan pesan "Tidak ada buku ditemukan" jika semua tersembunyi
        const visibleBooks = Array.from(bookGrid.children).filter(card => card.style.display !== 'none');
        const noBooksMessage = document.querySelector('.text-center.text-gray-600');
        if (visibleBooks.length === 0) {
            if (!noBooksMessage) {
                const message = document.createElement('p');
                message.className = 'text-center text-gray-600';
                message.textContent = 'Tidak ada buku ditemukan dengan kriteria pencarian ini.';
                bookGrid.parentNode.appendChild(message);
            }
        } else {
            if (noBooksMessage) {
                noBooksMessage.remove();
            }
        }
    }

    searchInput.addEventListener('keyup', applyFilters);
    filterKategori.addEventListener('change', applyFilters);
    filterKelas.addEventListener('change', applyFilters);
</script>
@endpush