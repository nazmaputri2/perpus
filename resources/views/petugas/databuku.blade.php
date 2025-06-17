
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
<div class="mb-6">
    <h3 class="text-3xl font-bold text-gray-900 mb-6">Data Buku</h3>
    
    <div class="flex flex-col lg:flex-row lg:items-center gap-4 w-full justify-between mb-6">
        <div class="flex flex-col sm:flex-row gap-4 w-full lg:w-auto flex-grow">
            <div class="relative w-full sm:w-80">
                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="text" id="search"
                    class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 block w-full pl-12 pr-4 py-3 shadow-sm transition-all duration-200 placeholder-gray-400"
                    placeholder="Cari buku berdasarkan...">
            </div>
            <div class="flex gap-3">
                <select id="filter-kategori"
                    class="w-28 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 px-4 py-3 shadow-sm transition-all duration-200 cursor-pointer">
                    <option selected disabled>Kategori</option>
                    <option value="pelajaran">Pelajaran</option>
                    <option value="fiksi">Fiksi</option>
                    <option value="nonfiksi">Non Fiksi</option>
                </select>
                <select id="filter-kelas"
                    class="w-28 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 px-4 py-3 shadow-sm transition-all duration-200 cursor-pointer">
                    <option selected disabled>Kelas</option>
                    <option value="1">Kelas 1</option>
                    <option value="2">Kelas 2</option>
                    <option value="3">Kelas 3</option>
                    <option value="4">Kelas 4</option>
                    <option value="5">Kelas 5</option>
                    <option value="6">Kelas 6</option>
                </select>
            </div>
        </div>
        <button data-modal-target="crud-modal" data-modal-toggle="crud-modal" type="button"
            class="bg-blue-600   text-white font-semibold rounded-xl px-6 py-3 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5">
            <i class="fas fa-plus mr-2"></i>Tambah Buku
        </button>
    </div>
</div>
<div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
    <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <h4 class="text-lg font-semibold text-gray-800">Daftar Buku</h4>
            <span class="text-sm text-gray-500">{{ count($buku) }} buku ditemukan</span>
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
                            <span>Gambar</span>
                        </div>
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        <div class="flex items-center space-x-1">
                            <span>ISBN</span>
                        </div>
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        <div class="flex items-center space-x-1">
                            <span>Detail Buku</span>
                        </div>
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        <div class="flex items-center space-x-1">
                            <span>Tahun</span>
                        </div>
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        <div class="flex items-center space-x-1">
                            <span>Stok</span>
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
                @foreach($buku as $index => $bukus)
                <tr>
                    <td class="px-6 py-4">
                        {{-- Menggunakan gaya dari file referensi, dengan perbaikan typo (menjadi bg-gray-100) --}}
                        <div class="flex items-center justify-center w-8 h-8 bg-gradient-to-r  text-black rounded-full text-sm font-semibold group-hover:scale-110 transition-transform duration-200">
                            {{ $index + 1 }}
                        </div>
                    </td>
                    
                    <td class="px-6 py-4">
                        <div class="relative group">
                            <img src="{{ asset($bukus->gambar) }}" 
                                 alt="{{ $bukus->judul }}" 
                                 class="h-20 w-14 object-cover rounded-lg shadow-md group-hover:shadow-xl transition-all duration-300 transform group-hover:scale-105"
                                 onerror="this.src='https://via.placeholder.com/56x80/e5e7eb/6b7280?text=No+Image'">
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 rounded-lg transition-all duration-300 flex items-center justify-center">
                                <i class="fas fa-search-plus text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300"></i>
                            </div>
                        </div>
                    </td>
                    
                    <td class="px-6 py-4">
                        <div class="bg-gray-100 rounded-lg px-3 py-1 inline-block">
                            <span class="text-sm font-mono text-gray-700">{{ $bukus->isbn }}</span>
                        </div>
                    </td>
                    
                    <td class="px-6 py-4">
                        <div class="space-y-1">
                            <h4 class="font-semibold text-gray-900 group-hover:text-blue-600 transition-colors duration-200">
                                {{ Str::limit($bukus->judul, 30) }}
                            </h4>
                            <p class="text-sm text-gray-600 flex items-center">
                                <i class="fas fa-user-edit mr-2 text-gray-400"></i>
                                {{ Str::limit($bukus->penulis, 25) }}
                            </p>
                            <p class="text-sm text-gray-500 flex items-center">
                                <i class="fas fa-building mr-2 text-gray-400"></i>
                                {{ Str::limit($bukus->penerbit, 25) }}
                            </p>
                        </div>
                    </td>
                    
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-calendar-alt text-gray-400"></i>
                            <span class="text-sm font-medium text-gray-700">{{ $bukus->tahun_terbit }}</span>
                        </div>
                    </td>
                    
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-2">
                            @if($bukus->stok > 10)
                                <div class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></div>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 border border-green-200">
                                    {{ $bukus->stok }} Tersedia
                                </span>
                            @elseif($bukus->stok > 0)
                                <div class="w-3 h-3 bg-yellow-400 rounded-full animate-pulse"></div>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800 border border-yellow-200">
                                    {{ $bukus->stok }} Terbatas
                                </span>
                            @else
                                <div class="w-3 h-3 bg-red-400 rounded-full"></div>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800 border border-red-200">
                                    Habis
                                </span>
                            @endif
                        </div>
                    </td>
                    
                    <td class="px-6 py-4">
                        <div class="flex space-x-2">
                             <button class=" relative overflow-hidden bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-lg transition-all duration-300 transform hover:scale-105 hover:shadow-lg"
                                    title="Edit Buku"
                                    data-modal-toggle="editbuku" data-modal-target="editbuku"   
                                    onclick=" prepareEditModal({{ json_encode($bukus) }})">
                                <i class="fas fa-edit text-sm group-hover/btn:scale-110 transition-transform duration-200"></i>
                                <div class="absolute inset-0 bg-white opacity-0 group-hover/btn:opacity-20 transition-opacity duration-300"></div>
                            </button>
                            <button class="group/btn relative overflow-hidden bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg transition-all duration-300 transform hover:scale-105 hover:shadow-lg"
                                    title="Hapus Buku"
                                    data-modal-target="deleteConfirmationModal"
                                    data-modal-toggle="deleteConfirmationModal"
                                    onclick="event.stopPropagation(); prepareDeleteModal({{ $bukus->isbn }})">
                                <i class="fas fa-trash text-sm group-hover/btn:scale-110 transition-transform duration-200"></i>
                                <div class="absolute inset-0 bg-white opacity-0 group-hover/btn:opacity-20 transition-opacity duration-300"></div>
                            </button>
                            <button class="group/btn relative overflow-hidden bg-green-500 hover:bg-green-600 text-white px-3 py-2 rounded-lg transition-all duration-300 transform hover:scale-105 hover:shadow-lg"
                                    title="Detail Buku"
                                    data-modal-toggle="detailModal" data-modal-target="detailModal"
                                   onclick="openDetailModal({
                                        image: '{{ asset($bukus->gambar) }}',
                                        isbn: '{{ $bukus->isbn }}',
                                        title: '{{ $bukus->judul }}',
                                        author: '{{ $bukus->penulis }}',
                                        publisher: '{{ $bukus->penerbit }}',
                                        year: '{{ $bukus->tahun_terbit }}',
                                        class: '{{ $bukus->kelas }}',
                                        jenis_buku: '{{ $bukus->jenis_buku }}',
                                        stock: '{{ $bukus->stok }}',
                                        description: `{{ str_replace(["\r", "\n"], "<br>", $bukus->sinopsis) }}`
                                    })">
                                <i class="fas fa-eye text-sm group-hover/btn:scale-110 transition-transform duration-200"></i>
                                <div class="absolute inset-0 bg-white opacity-0 group-hover/btn:opacity-20 transition-opacity duration-300"></div>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        @if($buku->isEmpty())
        <div class="text-center py-16">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-book-open text-gray-400 text-3xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Data Buku</h3>
            <p class="text-gray-500 mb-6">Silakan tambahkan buku pertama Anda untuk memulai</p>
            <button data-modal-target="crud-modal" data-modal-toggle="crud-modal" 
                class="bg-blue-600  text-white font-semibold rounded-xl px-6 py-3 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5">
                <i class="fas fa-plus mr-2"></i>Tambah Buku Pertama
            </button>
        </div>
        @endif
    </div>
</div>
@endsection
@push('scripts')
<script>
    
    function openDetailModal(data) {
        // Log data untuk debugging, bisa dihapus nanti
        console.log('Data yang diterima modal detail:', data);
        // Isi modal detail dengan data yang diterima
        document.getElementById('modalImage').src = data.image;
        document.getElementById('modalIsbn').textContent = data.isbn;
        document.getElementById('modalTitle').textContent = data.title;
        document.getElementById('modalAuthor').textContent = data.author;
        document.getElementById('modalPublisher').textContent = data.publisher;
        document.getElementById('modalYear').textContent = data.year;
        
        // PERBAIKAN DATA YANG TIDAK MUNCUL
        document.getElementById('modalStock').textContent = data.stock;
        document.getElementById('modalJenisbuku').textContent = data.jenis_buku;
        document.getElementById('modalDescription').innerHTML = data.description; // innerHTML agar <br> berfungsi
        
        // PERBAIKAN UNTUK 'KELAS'
        // Gunakan notasi kurung siku ['class'] karena 'class' adalah reserved keyword di JS
        document.getElementById('modalkelas').textContent = data['class'];
        // Sisa fungsi tetap sama
        window.currentBookData = data;
        const detailModalElement = document.getElementById('detailModal');
        detailModalElement.classList.remove('hidden');
        detailModalElement.setAttribute('aria-hidden', 'false');
        const editButton = document.getElementById('editBookBtn');
        if (editButton) {
            editButton.onclick = function () {
                detailModalElement.classList.add('hidden');
                detailModalElement.setAttribute('aria-hidden', 'true');
                prepareEditModal(window.currentBookData); // Kirim data saat memanggil edit
            };
        }
        const deleteButton = document.getElementById('deleteBookBtn');
        if (deleteButton) {
            deleteButton.onclick = function () {
                detailModalElement.classList.add('hidden');
                detailModalElement.setAttribute('aria-hidden', 'true');
                prepareDeleteModal(data.isbn); // Gunakan ISBN untuk hapus
            };
        }
    }
    // Pastikan fungsi lain juga disertakan
    function prepareEditModal(data) {
        if (!data) return;
        const editForm = document.getElementById('editBookForm');
        editForm.action = `/petugas/databuku/${data.isbn}`;
        document.getElementById('edit-isbn').value = data.isbn;
        document.getElementById('edit-judul_buku').value = data.judul; // sesuaikan dengan properti di data
        document.getElementById('edit-penulis').value = data.penulis;
        document.getElementById('edit-penerbit').value = data.penerbit;
        document.getElementById('edit-tahun_terbit').value = data.tahun_terbit;
        document.getElementById('edit-stok').value = data.stok;
        document.getElementById('edit-sinopsis').value = data.sinopsis; 
        document.getElementById('editFotoPreview').src = `{{ asset('') }}/${data.gambar}`;
        document.getElementById('edit-jenis_buku').value = data.jenis_buku;
        document.getElementById('edit-kelas').value = data.kelas;
        const editModalElement = document.getElementById('editbuku');
        editModalElement.classList.remove('hidden');
        editModalElement.setAttribute('aria-hidden', 'false');
    }
    function prepareDeleteModal(isbn) {
        const deleteForm = document.getElementById('deleteBookForm');
        deleteForm.action = `/petugas/databuku/${isbn}`;
        const deleteModalElement = document.getElementById('deleteConfirmationModal');
        deleteModalElement.classList.remove('hidden'); 
        deleteModalElement.setAttribute('aria-hidden', 'false');
    }
</script>
@endpush
