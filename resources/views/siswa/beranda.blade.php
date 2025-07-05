@extends('layouts.siswa')

@section('title', 'Beranda Siswa')

@push('modals')
    @include('components.modal-ubah-sandi')
    @include('components.modal-keluar')
    @include('components.siswa.modal-detail-buku')
    @include('components.siswa.modal-konfirmasi-pinjam')
@endpush

@section('content')

@push('toasts')
<div id="toast-alert"
     class="fixed inset-x-0 top-6 mx-auto z-50 flex items-center gap-3 w-fit max-w-lg p-4 text-green-800 bg-green-100 border border-green-300 rounded-xl shadow-lg
     opacity-0 -translate-y-4 transition-all duration-500 ease-out">
    <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
    </svg>
    <div class="text-sm font-medium">
        <span class="font-bold">Selamat Datang!</span> Gunakan fitur pencarian dan filter untuk menemukan buku.
    </div>
</div>
@endpush

<div class="p-4 bg-white rounded-xl shadow-lg mb-6 border border-gray-200 max-w-7xl mx-auto">
    <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto flex-grow mb-6">
        <div class="relative w-full sm:w-64">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <i class="fas fa-search text-gray-500"></i>
            </div>
            <input type="text" id="search"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                placeholder="Cari buku...">
        </div>

        <select id="filter-kategori" class="w-36 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
            <option value="">Semua Kategori</option>
            @foreach($kategoriOptions as $kategori)
            <option value="{{ $kategori }}">{{ $kategori }}</option>
            @endforeach
        </select>

        <select id="filter-kelas"
            class="w-36 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
            <option value="">Semua Kelas</option>
            @foreach($kelasOptions as $kelas)
            <option value="{{ $kelas }}">Kelas {{ $kelas }}</option>
            @endforeach
        </select>

        <button id="reset-filter"
            class="px-4 py-2 bg-gray-500 text-white text-sm rounded-lg hover:bg-gray-600 transition-colors">
            Reset
        </button>
    </div>

    <div id="buku-container" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4 mb-4">
        @forelse($buku as $bukuItem)
        <div class="buku-card flex items-center justify-center flex-col rounded-lg bg-white-100 p-4 shadow-md transition-all duration-300 hover:scale-105 cursor-pointer transform-gpu origin-center"
             onclick="openDetailModal('{{ $bukuItem->isbn }}')" data-modal-target="detailModal"
             data-modal-toggle="detailModal"
             data-kategori="{{ $bukuItem->jenis_buku ?? '' }}"
             data-kelas="{{ $bukuItem->kelas ?? '' }}"
             data-judul="{{ strtolower($bukuItem->judul) }}"
             data-penulis="{{ strtolower($bukuItem->penulis ?? '') }}"
             data-book-id="{{ $bukuItem->isbn }}">

            <img src="{{ $bukuItem->gambar_url }}"
                 alt="{{ $bukuItem->judul }}"
                 class="h-auto max-w-full rounded"
                 onerror="this.src='{{ asset('images/default-book.png') }}'">

            <p class="mt-2 text-sm text-center text-gray-700 line-clamp-2">{{ $bukuItem->judul }}</p>

            <div class="mt-1 text-xs text-gray-500 text-center">
                <span class="block">Stok: <span class="stok-value">{{ $bukuItem->stok }}</span></span>
                @if($bukuItem->jenis_buku)
                    <span class="block">{{ $bukuItem->jenis_buku }}</span>
                @endif
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-8">
            <div class="text-gray-500">
                <i class="fas fa-book text-4xl mb-4"></i>
                <p class="text-lg">Belum ada buku tersedia</p>
            </div>
        </div>
        @endforelse
    </div>

    <div id="no-results" class="hidden col-span-full text-center py-8">
        <div class="text-gray-500">
            <i class="fas fa-search text-4xl mb-4"></i>
            <p class="text-lg">Tidak ada buku yang sesuai dengan pencarian</p>
        </div>
    </div>
</div>

@endsection

@push('scripts')
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const bukuData = @json($buku);

    // --- Element References ---
    const searchInput = document.getElementById('search');
    const filterKategori = document.getElementById('filter-kategori');
    const filterKelas = document.getElementById('filter-kelas');
    const resetButton = document.getElementById('reset-filter');
    const noResults = document.getElementById('no-results');
    const bukuContainer = document.getElementById('buku-container');
    const detailModal = document.getElementById('detailModal');
    const konfirmasiModal = document.getElementById('konfirmasiPinjamModal');
    const toast = document.getElementById('toast-alert');

    // --- Modal Element References ---
    const modalImage = document.getElementById('modalImage');
    const modalIsbn = document.getElementById('modalIsbn');
    const modalTitle = document.getElementById('modalTitle');
    const modalAuthor = document.getElementById('modalAuthor');
    const modalPublisher = document.getElementById('modalPublisher');
    const modalYear = document.getElementById('modalYear');
    const modalStock = document.getElementById('modalStock');
    const modalDescription = document.getElementById('modalDescription');
    const pinjamBukuBtn = document.getElementById('pinjamBukuBtn');

    const konfirmasiBukuJudul = document.getElementById('konfirmasiBukuJudul');
    const konfirmasiBukuPenulis = document.getElementById('konfirmasiBukuPenulis');
    const konfirmasiBukuISBN = document.getElementById('konfirmasiBukuISBN');
    const konfirmasiBukuStok = document.getElementById('konfirmasiBukuStok');
    let konfirmasiPinjamBtn = document.getElementById('konfirmasiPinjamBtn'); // Use 'let' to allow reassignment

    // --- Utility Functions ---
    const getBookById = (isbn) => bukuData.find(book => book.isbn === isbn);

    const updateBookStockInUI = (bukuIsbn, newStock) => {
        // Update stock in detail modal
        if (modalStock) modalStock.textContent = newStock;

        // Update stock on the book card
        const card = document.querySelector(`.buku-card[data-book-id="${bukuIsbn}"]`);
        if (card) {
            const stockElement = card.querySelector('.stok-value');
            if (stockElement) stockElement.textContent = newStock;
        }

        // Update pinjam button state
        if (pinjamBukuBtn) {
            if (newStock <= 0) {
                pinjamBukuBtn.disabled = true;
                pinjamBukuBtn.textContent = 'Stok Habis';
                pinjamBukuBtn.className = 'w-full px-4 py-2 bg-gray-400 text-white rounded-lg cursor-not-allowed';
            } else {
                pinjamBukuBtn.disabled = false;
                pinjamBukuBtn.textContent = 'Pinjam';
                pinjamBukuBtn.className = 'text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800';
            }
        }
    };

    // --- Modal Management ---
    const showModal = (modalElement) => {
        if (!modalElement) return;
        modalElement.classList.remove('hidden');
        modalElement.classList.add('flex', 'items-center', 'justify-center');
        modalElement.style.backgroundColor = 'rgba(0, 0, 0, 0.5)';
        document.body.classList.add('overflow-hidden');
    };

    const hideModal = (modalElement) => {
        if (!modalElement) return;
        modalElement.classList.add('hidden');
        modalElement.classList.remove('flex', 'items-center', 'justify-center');
        modalElement.style.backgroundColor = '';
        // Only remove overflow-hidden if no other modals are open
        if (!detailModal.classList.contains('flex') && !konfirmasiModal.classList.contains('flex')) {
            document.body.classList.remove('overflow-hidden');
        }
    };

    const openDetailModal = (bookIsbn) => {
        const data = getBookById(bookIsbn);
        if (!data) {
            alert('Data buku tidak ditemukan');
            return;
        }

        // Populate modal content
        if(modalImage) {
            modalImage.src = data.gambar_url || '{{ asset('images/default-book.png') }}';
            modalImage.onerror = () => { modalImage.src = '{{ asset('images/default-book.png') }}'; };
        }
        if(modalIsbn) modalIsbn.textContent = data.isbn || '-';
        if(modalTitle) modalTitle.textContent = data.judul || '-';
        if(modalAuthor) modalAuthor.textContent = data.penulis || '-';
        if(modalPublisher) modalPublisher.textContent = data.penerbit || '-';
        if(modalYear) modalYear.textContent = data.tahun_terbit || '-';
        if(modalStock) modalStock.textContent = data.stok || '0';
        if(modalDescription) modalDescription.textContent = data.sinopsis || 'Tidak ada sinopsis tersedia';

        // Setup pinjam button
        updateBookStockInUI(data.isbn, data.stok); // Initial setup
        pinjamBukuBtn.onclick = (e) => {
            e.stopPropagation();
            showKonfirmasiPinjam(data);
        };

        showModal(detailModal);
    };

    const showKonfirmasiPinjam = (data) => {
        if (!data || !data.isbn) {
            alert('Data buku tidak valid');
            return;
        }
        
        // Populate confirmation modal
        if (konfirmasiBukuJudul) konfirmasiBukuJudul.textContent = data.judul || 'Judul tidak tersedia';
        if (konfirmasiBukuPenulis) konfirmasiBukuPenulis.textContent = `Penulis: ${data.penulis || 'Tidak diketahui'}`;
        if (konfirmasiBukuISBN) konfirmasiBukuISBN.textContent = `ISBN: ${data.isbn || 'N/A'}`;
        if (konfirmasiBukuStok) konfirmasiBukuStok.textContent = `Stok: ${data.stok || 0}`;

        // Re-attach event listener to avoid stale closures
        const newBtn = konfirmasiPinjamBtn.cloneNode(true);
        konfirmasiPinjamBtn.parentNode.replaceChild(newBtn, konfirmasiPinjamBtn);
        konfirmasiPinjamBtn = newBtn; // Update reference
        
        konfirmasiPinjamBtn.onclick = (e) => {
            e.preventDefault();
            processPinjamBuku(data);
        };

        hideModal(detailModal);
        setTimeout(() => showModal(konfirmasiModal), 150); // Delay for smoother transition
    };
    
    // --- Book Borrowing Process ---
    const processPinjamBuku = (data) => {
        if (!data || !data.isbn) {
            alert('Data buku tidak tersedia.');
            return;
        }

        // Show loading state
        konfirmasiPinjamBtn.disabled = true;
        konfirmasiPinjamBtn.innerHTML = `<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Memproses...`;

        fetch("/siswa/pinjam-buku", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify({ buku_id: data.isbn })
        })
        .then(response => response.json().then(json => ({ ok: response.ok, data: json })))
        .then(({ ok, data: responseData }) => {
            if (ok && responseData.success) {
                alert(responseData.message || 'Buku berhasil dipinjam!');
                
                // Update local data and UI
                const bookIndex = bukuData.findIndex(book => book.isbn === data.isbn);
                if (bookIndex !== -1) {
                    bukuData[bookIndex].stok = responseData.data.new_stock;
                }
                updateBookStockInUI(data.isbn, responseData.data.new_stock);
                
                hideModal(konfirmasiModal);
            } else {
                throw new Error(responseData.message || 'Gagal meminjam buku.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert(error.message);
        })
        .finally(() => {
            // Reset button state
            konfirmasiPinjamBtn.disabled = false;
            konfirmasiPinjamBtn.innerHTML = `<svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg> Ya, Pinjam Buku`;
        });
    };
    
    // --- Filtering Logic ---
    const filterBooks = () => {
        const searchTerm = searchInput.value.toLowerCase().trim();
        const selectedKategori = filterKategori.value;
        const selectedKelas = filterKelas.value;
        const bukuCards = document.querySelectorAll('.buku-card');
        let visibleCount = 0;

        bukuCards.forEach(card => {
            const title = card.dataset.judul || '';
            const author = card.dataset.penulis || '';
            const kategori = card.dataset.kategori || '';
            const kelas = card.dataset.kelas || '';

            const matchesSearch = title.includes(searchTerm) || author.includes(searchTerm);
            const matchesKategori = !selectedKategori || kategori === selectedKategori;
            const matchesKelas = !selectedKelas || kelas == selectedKelas;

            if (matchesSearch && matchesKategori && matchesKelas) {
                card.style.display = 'flex';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        noResults.style.display = visibleCount === 0 ? 'block' : 'none';
    };

    // --- Event Listeners ---
    if(searchInput) searchInput.addEventListener('input', filterBooks);
    if(filterKategori) filterKategori.addEventListener('change', filterBooks);
    if(filterKelas) filterKelas.addEventListener('change', filterBooks);
    
    if(resetButton) {
        resetButton.addEventListener('click', () => {
            if(searchInput) searchInput.value = '';
            if(filterKategori) filterKategori.value = '';
            if(filterKelas) filterKelas.value = '';
            filterBooks();
        });
    }

    // Assign click events to book cards
    document.querySelectorAll('.buku-card').forEach(card => {
        card.addEventListener('click', () => {
            openDetailModal(card.dataset.bookId);
        });
    });

    // Handle modal closing
    document.querySelectorAll('[data-modal-hide]').forEach(button => {
        button.addEventListener('click', (e) => {
            e.stopPropagation();
            const modalId = button.getAttribute('data-modal-hide');
            const modalToHide = document.getElementById(modalId);
            hideModal(modalToHide);
        });
    });

    // Handle backdrop clicks to close
    if (detailModal) detailModal.addEventListener('click', (e) => { if (e.target === detailModal) hideModal(detailModal); });
    if (konfirmasiModal) konfirmasiModal.addEventListener('click', (e) => { if (e.target === konfirmasiModal) hideModal(konfirmasiModal); });

    // Handle 'Escape' key to close
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            if (konfirmasiModal.classList.contains('flex')) {
                hideModal(konfirmasiModal);
            } else if (detailModal.classList.contains('flex')) {
                hideModal(detailModal);
            }
        }
    });

    // --- Initial Toast Animation ---
    if (toast) {
        setTimeout(() => {
            toast.classList.remove('opacity-0', '-translate-y-4');
        }, 100);
        setTimeout(() => {
            toast.classList.add('opacity-0', '-translate-y-4');
            setTimeout(() => toast.remove(), 500);
        }, 4000);
    }
});
</script>
@endpush