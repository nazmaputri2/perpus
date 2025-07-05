@extends('layouts.petugas')
@section('title', 'Data Buku')

@push('modals')
    {{-- Memuat semua modal yang diperlukan --}}
    @include('components.modal-ubah-sandi')
    @include('components.modal-keluar')
    @include('components.buku.modal-tambah-buku')
    @include('components.buku.modal-detail-buku')
    @include('components.buku.modal-edit-buku')
    @include('components.buku.modal-hapus-buku')
@endpush

@section('content')
<div class="mb-6">
    <h3 class="text-3xl font-bold text-gray-900 mb-6">Data Buku</h3>
    
    {{-- Bagian Filter dan Tombol Aksi --}}
    <div class="flex flex-col lg:flex-row lg:items-center gap-4 w-full justify-between mb-6">
        <div class="flex flex-col sm:flex-row gap-4 w-full lg:w-auto flex-grow">
            {{-- Input Pencarian --}}
            <div class="relative w-full sm:w-80">
                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="text" id="search"
                    class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 block w-full pl-12 pr-4 py-3 shadow-sm transition-all duration-200 placeholder-gray-400"
                    placeholder="Cari buku berdasarkan...">
            </div>
            
            {{-- Dropdown Filter --}}
            <div class="flex gap-3">
                <div>
                    <label for="filter-kategori" class="sr-only">Filter Kategori</label>
                    <select id="filter-kategori"
                        class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-36 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                        <option value="">Semua Kategori</option>
                        @foreach ($kategoriOptions as $kategori)
                            <option value="{{ $kategori }}">{{ $kategori }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="filter-kelas" class="sr-only">Filter Kelas</label>
                    <select id="filter-kelas"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-32 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                        <option value="">Semua Kelas</option>
                        @foreach ($kelasOptions as $kelas)
                            <option value="{{ $kelas }}">Kelas {{ $kelas }}</option>
                        @endforeach
                    </select>
                </div>
                {{-- Tombol Reset Filter --}}
                <button id="reset-filter"
                    class="p-2.5 text-sm font-medium text-white bg-gray-600 rounded-lg border border-gray-700 hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-300 dark:bg-gray-500 dark:hover:bg-gray-600 dark:focus:ring-gray-700">
                    Reset
                </button>
            </div>
        </div>
        
        {{-- Tombol Tambah Buku --}}
        <button data-modal-target="crud-modal" data-modal-toggle="crud-modal" type="button"
            class="bg-blue-600   text-white font-semibold rounded-xl px-6 py-3 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5">
            <i class="fas fa-plus mr-2"></i>Tambah Buku
        </button>
    </div>
</div>

{{-- Tabel Data Buku --}}
<div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
    <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <h4 class="text-lg font-semibold text-gray-800">Daftar Buku</h4>
            <span id="buku-count" class="text-sm text-gray-500">{{ count($buku) }} buku ditemukan</span>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Gambar</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ISBN</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Detail Buku</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tahun</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Stok</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody id="buku-table-body" class="divide-y divide-gray-100">
                @foreach($buku as $index => $bukus)
                {{-- MODIFIKASI: Menambahkan class dan atribut data-* untuk filtering --}}
                <tr class="buku-row" data-kategori="{{ $bukus->jenis_buku }}" data-kelas="{{ $bukus->kelas }}">
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center w-8 h-8 bg-gradient-to-r text-black rounded-full text-sm font-semibold">
                             {{ $buku->firstItem() + $index }}
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="relative group">
                            <img src="{{ asset($bukus->gambar) }}" alt="{{ $bukus->judul }}" 
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
                            <h4 class="font-semibold text-gray-900">{{ Str::limit($bukus->judul, 30) }}</h4>
                            <p class="text-sm text-gray-600 flex items-center"><i class="fas fa-user-edit mr-2 text-gray-400"></i>{{ Str::limit($bukus->penulis, 25) }}</p>
                            <p class="text-sm text-gray-500 flex items-center"><i class="fas fa-building mr-2 text-gray-400"></i>{{ Str::limit($bukus->penerbit, 25) }}</p>
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
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 border border-green-200">{{ $bukus->stok }} Tersedia</span>
                            @elseif($bukus->stok > 0)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800 border border-yellow-200">{{ $bukus->stok }} Terbatas</span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800 border border-red-200">Habis</span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex space-x-2">
                            <button class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-lg" title="Edit Buku" data-modal-toggle="editbuku" data-modal-target="editbuku" onclick="prepareEditModal({{ json_encode($bukus) }})">
                                <i class="fas fa-edit text-sm"></i>
                            </button>
                            <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg" title="Hapus Buku" data-modal-target="deleteConfirmationModal" data-modal-toggle="deleteConfirmationModal" onclick="event.stopPropagation(); prepareDeleteModal({{ $bukus->isbn }})">
                                <i class="fas fa-trash text-sm"></i>
                            </button>
                            <button class="bg-green-500 hover:bg-green-600 text-white px-3 py-2 rounded-lg" title="Detail Buku" data-modal-toggle="detailModal" data-modal-target="detailModal" onclick="openDetailModal({ image: '{{ asset($bukus->gambar) }}', isbn: '{{ $bukus->isbn }}', title: '{{ $bukus->judul }}', author: '{{ $bukus->penulis }}', publisher: '{{ $bukus->penerbit }}', year: '{{ $bukus->tahun_terbit }}', class: '{{ $bukus->kelas }}', jenis_buku: '{{ $bukus->jenis_buku }}', stock: '{{ $bukus->stok }}', description: `{{ str_replace(["\r", "\n"], "<br>", e($bukus->sinopsis)) }}` })">
                                <i class="fas fa-eye text-sm"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Pagination --}}
@if ($buku->hasPages())
    <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-6 border-t border-gray-200">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            {{-- Info Halaman --}}
            <div class="text-sm text-gray-600">
                <span class="font-medium">Menampilkan {{ $buku->firstItem() ?? 0 }}-{{ $buku->lastItem() ?? 0 }}</span>
                dari
                <span class="font-medium">{{ $buku->total() }} buku</span>
            </div>

            {{-- Navigasi --}}
            <nav class="flex items-center space-x-1">
                {{-- Tombol Sebelumnya --}}
                @if ($buku->onFirstPage())
                    <span class="px-4 py-2 text-sm font-medium text-gray-400 bg-white border border-gray-300 rounded-l-xl cursor-not-allowed shadow-sm">
                        <i class="fas fa-chevron-left mr-1"></i>Sebelumnya
                    </span>
                @else
                    <a href="{{ $buku->previousPageUrl() }}"
                       class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-l-xl hover:bg-blue-50 hover:text-blue-700 transition transform hover:scale-105 shadow-sm">
                        <i class="fas fa-chevron-left mr-1"></i>Sebelumnya
                    </a>
                @endif

                {{-- Nomor Halaman --}}
                @php
                    $start = max(1, $buku->currentPage() - 2);
                    $end = min($buku->lastPage(), $buku->currentPage() + 2);
                @endphp

                @if ($start > 1)
                    <a href="{{ $buku->url(1) }}"
                       class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border-t border-b border-gray-300 hover:bg-blue-50 hover:text-blue-700 transition transform hover:scale-105 shadow-sm">
                        1
                    </a>
                    @if ($start > 2)
                        <span class="px-4 py-2 text-sm font-medium text-gray-500 bg-white border-t border-b border-gray-300">...</span>
                    @endif
                @endif

                @for ($page = $start; $page <= $end; $page++)
                    @if ($page == $buku->currentPage())
                        <span class="px-4 py-2 text-sm font-semibold text-white bg-blue-500 shadow-md scale-110 rounded-md">{{ $page }}</span>
                    @else
                        <a href="{{ $buku->url($page) }}"
                           class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border-t border-b border-gray-300 hover:bg-blue-50 hover:text-blue-700 transition transform hover:scale-105 shadow-sm">
                            {{ $page }}
                        </a>
                    @endif
                @endfor

                @if ($end < $buku->lastPage())
                    @if ($end < $buku->lastPage() - 1)
                        <span class="px-4 py-2 text-sm font-medium text-gray-500 bg-white border-t border-b border-gray-300">...</span>
                    @endif
                    <a href="{{ $buku->url($buku->lastPage()) }}"
                       class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border-t border-b border-gray-300 hover:bg-blue-50 hover:text-blue-700 transition transform hover:scale-105 shadow-sm">
                        {{ $buku->lastPage() }}
                    </a>
                @endif

                {{-- Tombol Berikutnya --}}
                @if ($buku->hasMorePages())
                    <a href="{{ $buku->nextPageUrl() }}"
                       class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-r-xl hover:bg-blue-50 hover:text-blue-700 transition transform hover:scale-105 shadow-sm">
                        Berikutnya<i class="fas fa-chevron-right ml-1"></i>
                    </a>
                @else
                    <span class="px-4 py-2 text-sm font-medium text-gray-400 bg-white border border-gray-300 rounded-r-xl cursor-not-allowed shadow-sm">
                        Berikutnya<i class="fas fa-chevron-right ml-1"></i>
                    </span>
                @endif
            </nav>
        </div>
    </div>
@endif

        
        {{-- Pesan jika filter tidak menemukan hasil --}}
        <div id="no-results" class="text-center py-16 hidden">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-search-minus text-gray-400 text-3xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Buku Tidak Ditemukan</h3>
            <p class="text-gray-500">Coba ubah kata kunci pencarian atau filter Anda.</p>
        </div>

        {{-- Pesan jika tabel benar-benar kosong dari database --}}
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
{{-- Skrip untuk mengelola modal (detail, edit, hapus) --}}
<script>
    // Pastikan `e()` atau `htmlspecialchars` digunakan di PHP untuk menghindari XSS
    // `e($bukus->sinopsis)` di onclick button detail sudah ditambahkan
    
    function openDetailModal(data) {
        document.getElementById('modalImage').src = data.image;
        document.getElementById('modalIsbn').textContent = data.isbn;
        document.getElementById('modalTitle').textContent = data.title;
        document.getElementById('modalAuthor').textContent = data.author;
        document.getElementById('modalPublisher').textContent = data.publisher;
        document.getElementById('modalYear').textContent = data.year;
        document.getElementById('modalStock').textContent = data.stock;
        document.getElementById('modalJenisbuku').textContent = data.jenis_buku;
        document.getElementById('modalDescription').innerHTML = data.description;
        document.getElementById('modalkelas').textContent = data['class'];

        const detailModalElement = document.getElementById('detailModal');
        detailModalElement.classList.remove('hidden');
        detailModalElement.setAttribute('aria-hidden', 'false');

        // Setup tombol edit dan hapus di dalam modal detail
        const editButton = document.getElementById('editBookBtn');
        if (editButton) {
            editButton.onclick = () => {
                detailModalElement.classList.add('hidden');
                prepareEditModal(data);
            };
        }
        const deleteButton = document.getElementById('deleteBookBtn');
        if (deleteButton) {
            deleteButton.onclick = () => {
                detailModalElement.classList.add('hidden');
                prepareDeleteModal(data.isbn);
            };
        }
    }

    function prepareEditModal(data) {
        if (!data) return;
        const editForm = document.getElementById('editBookForm');
        editForm.action = `/petugas/databuku/${data.isbn}`;
        document.getElementById('edit-isbn').value = data.isbn;
        // Gunakan properti yang sesuai dari objek data yang dilewatkan
        document.getElementById('edit-judul_buku').value = data.judul || data.title;
        document.getElementById('edit-penulis').value = data.penulis || data.author;
        document.getElementById('edit-penerbit').value = data.penerbit || data.publisher;
        document.getElementById('edit-tahun_terbit').value = data.tahun_terbit || data.year;
        document.getElementById('edit-stok').value = data.stok;
        document.getElementById('edit-sinopsis').value = data.sinopsis || data.description.replace(/<br\s*\/?>/gi, "\n");
        document.getElementById('editFotoPreview').src = data.gambar ? `{{ asset('') }}/${data.gambar}` : (data.image || 'https://via.placeholder.com/100x150');
        document.getElementById('edit-jenis_buku').value = data.jenis_buku;
        document.getElementById('edit-kelas').value = data.kelas || data.class;
        
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

{{-- Skrip baru untuk fungsionalitas filter --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('search');
        const kategoriFilter = document.getElementById('filter-kategori');
        const kelasFilter = document.getElementById('filter-kelas');
        const resetBtn = document.getElementById('reset-filter');
        const tableBody = document.getElementById('buku-table-body');
        const rows = tableBody.getElementsByClassName('buku-row');
        const bukuCountSpan = document.getElementById('buku-count');
        const noResultsMessage = document.getElementById('no-results');

        function filterBuku() {
            const searchTerm = searchInput.value.toLowerCase();
            const kategoriValue = kategoriFilter.value;
            const kelasValue = kelasFilter.value;
            let visibleCount = 0;

            for (let i = 0; i < rows.length; i++) {
                const row = rows[i];
                // Mengambil semua teks dari baris dan mengubahnya menjadi huruf kecil
                const rowText = row.querySelector('td:nth-child(4)').textContent.toLowerCase(); // Kolom Detail Buku
                const rowIsbn = row.querySelector('td:nth-child(3)').textContent.toLowerCase(); // Kolom ISBN
                const rowKategori = row.getAttribute('data-kategori');
                const rowKelas = row.getAttribute('data-kelas');

                // Kondisi pencarian: cek di detail buku atau ISBN
                const searchMatch = rowText.includes(searchTerm) || rowIsbn.includes(searchTerm);
                const kategoriMatch = (kategoriValue === "" || rowKategori === kategoriValue);
                const kelasMatch = (kelasValue === "" || rowKelas === kelasValue);

                if (searchMatch && kategoriMatch && kelasMatch) {
                    row.style.display = "";
                    visibleCount++;
                } else {
                    row.style.display = "none";
                }
            }
            
            bukuCountSpan.textContent = `${visibleCount} buku ditemukan`;

            if (visibleCount === 0 && (searchTerm || kategoriValue || kelasValue)) {
                noResultsMessage.style.display = 'block';
            } else {
                noResultsMessage.style.display = 'none';
            }
        }

        function resetFilters() {
            searchInput.value = "";
            kategoriFilter.value = "";
            kelasFilter.value = "";
            filterBuku();
        }

        searchInput.addEventListener('keyup', filterBuku);
        kategoriFilter.addEventListener('change', filterBuku);
        kelasFilter.addEventListener('change', filterBuku);
        resetBtn.addEventListener('click', resetFilters);
    });
</script>
@endpush