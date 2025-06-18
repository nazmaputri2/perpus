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
<script>
const bukuData = @json($buku);

function getBookById(isbn) {
    console.log('getBookById: Looking for book with ISBN:', isbn);
    if (!bukuData || !Array.isArray(bukuData)) {
        console.error('getBookById: bukuData not available or not an array.');
        return null;
    }
    const book = bukuData.find(book => book.isbn === isbn);
    console.log('getBookById: Found book:', book);
    return book;
}

function openDetailModal(bookIsbn) {
    console.log('openDetailModal: Opening modal for book ISBN:', bookIsbn);

    const data = getBookById(bookIsbn);

    if (!data) {
        console.error('openDetailModal: Book data not found for ISBN:', bookIsbn);
        alert('Data buku tidak ditemukan');
        return;
    }

    console.log('openDetailModal: Book data to fill modal:', data);

    const modalImage = document.getElementById('modalImage');
    const modalIsbn = document.getElementById('modalIsbn');
    const modalTitle = document.getElementById('modalTitle');
    const modalAuthor = document.getElementById('modalAuthor');
    const modalPublisher = document.getElementById('modalPublisher');
    const modalYear = document.getElementById('modalYear');
    const modalStock = document.getElementById('modalStock');
    const modalDescription = document.getElementById('modalDescription');

    if (modalImage) {
        modalImage.src = data.gambar_url || '{{ asset('images/default-book.png') }}';
        modalImage.alt = data.judul || 'Cover Buku';
        modalImage.onerror = function() {
            console.error('Image failed to load (fallback to default):', this.src);
            this.src = '{{ asset('images/default-book.png') }}';
        };
    }

    if (modalIsbn) modalIsbn.textContent = data.isbn || '-';
    if (modalTitle) modalTitle.textContent = data.judul || '-';
    if (modalAuthor) modalAuthor.textContent = data.penulis || '-';
    if (modalPublisher) modalPublisher.textContent = data.penerbit || '-';
    if (modalYear) modalYear.textContent = data.tahun_terbit || '-';
    if (modalStock) modalStock.textContent = data.stok || '0';
    if (modalDescription) modalDescription.textContent = data.sinopsis || 'Tidak ada sinopsis tersedia';

    const pinjamBtn = document.getElementById('pinjamBukuBtn');

    if (pinjamBtn) {
        const newPinjamBtn = pinjamBtn.cloneNode(true);
        pinjamBtn.parentNode.replaceChild(newPinjamBtn, pinjamBtn);

        if (data.stok <= 0) {
            newPinjamBtn.disabled = true;
            newPinjamBtn.textContent = 'Stok Habis';
            newPinjamBtn.className = 'w-full px-4 py-2 bg-gray-400 text-white rounded-lg cursor-not-allowed';
        } else {
            newPinjamBtn.disabled = false;
            newPinjamBtn.textContent = 'Pinjam Buku';
            newPinjamBtn.className = 'w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors';

            newPinjamBtn.onclick = function() {
                console.log('Pinjam button clicked with data:', data);
                showKonfirmasiPinjam(data);
            };
        }
    }

    const detailModal = document.getElementById('detailModal');
    if (detailModal) {
        if (typeof Flowbite !== 'undefined' && Flowbite.Modal) {
            const modalInstance = Flowbite.Modal.getInstance(detailModal) || new Flowbite.Modal(detailModal);
            modalInstance.show();
        } else {
            detailModal.classList.remove('hidden');
            detailModal.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
        }
    }
}

function showKonfirmasiPinjam(data) {
    console.log('showKonfirmasiPinjam received data:', data);

    if (!data || typeof data !== 'object' || !data.isbn) {
        console.error('Data buku tidak valid atau ISBN tidak ditemukan:', data);
        alert('Data buku tidak valid');
        return;
    }

    const konfirmasiBukuJudul = document.getElementById('konfirmasiBukuJudul');
    const konfirmasiBukuPenulis = document.getElementById('konfirmasiBukuPenulis');
    const konfirmasiBukuISBN = document.getElementById('konfirmasiBukuISBN');
    const konfirmasiBukuStok = document.getElementById('konfirmasiBukuStok');
    const konfirmasiPinjamBtn = document.getElementById('konfirmasiPinjamBtn');

    if (konfirmasiBukuJudul) konfirmasiBukuJudul.textContent = data.judul || 'Judul tidak tersedia';
    if (konfirmasiBukuPenulis) konfirmasiBukuPenulis.textContent = `Penulis: ${data.penulis || 'Tidak diketahui'}`;
    if (konfirmasiBukuISBN) konfirmasiBukuISBN.textContent = `ISBN: ${data.isbn || 'N/A'}`;
    if (konfirmasiBukuStok) konfirmasiBukuStok.textContent = `Stok: ${data.stok || 0}`;

    if (konfirmasiPinjamBtn) {
        const newBtn = konfirmasiPinjamBtn.cloneNode(true);
        konfirmasiPinjamBtn.parentNode.replaceChild(newBtn, konfirmasiPinjamBtn);

        newBtn.onclick = function() {
            console.log('Confirmation button clicked with data:', data);
            processPinjamBuku(data);
        };
    }

    closeDetailModal();
    showKonfirmasiModal();
}

function processPinjamBuku(data) {
    console.log('processPinjamBuku called with:', data);

    const konfirmasiPinjamBtn = document.getElementById('konfirmasiPinjamBtn');

    if (!data || typeof data !== 'object' || !data.isbn) {
        console.error('Data is null, undefined, or ISBN is missing:', data);
        alert('Data buku tidak tersedia atau ISBN-nya hilang.');
        return;
    }

    const bukuISBN = data.isbn;
    console.log('Using ISBN as identifier for request:', bukuISBN);

    if (konfirmasiPinjamBtn) {
        konfirmasiPinjamBtn.disabled = true;
        konfirmasiPinjamBtn.innerHTML = `
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Memproses...
        `;
    }

    const requestData = {
        buku_id: bukuISBN
    };

    console.log('Sending borrow request to backend:', requestData);

    fetch("/siswa/pinjam-buku", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        },
        body: JSON.stringify(requestData)
    })
    .then(response => {
        console.log('Response status:', response.status);
        if (!response.ok) {
            return response.text().then(text => {
                console.log('Error response body:', text);
                throw new Error(`HTTP error! status: ${response.status}, body: ${text}`);
            });
        }
        return response.json();
    })
    .then(responseData => {
        console.log('Response data:', responseData);
        if(responseData.success) {
            alert(responseData.message || 'Buku berhasil dipinjam!');

            const bookIndex = bukuData.findIndex(book => book.isbn === bukuISBN);
            if (bookIndex !== -1) {
                bukuData[bookIndex].stok = responseData.data.new_stock;
            }

            updateBookStockInUI(bukuISBN, responseData.data.new_stock);

            closeAllModals();

        } else {
            alert(responseData.message || 'Gagal meminjam buku');
        }
    })
    .catch(error => {
        console.error('Error detail:', error);

        let alertMessage = 'Terjadi kesalahan saat meminjam buku.';
        try {
            const errorBodyMatch = error.message.match(/body: (.*)$/);
            if (errorBodyMatch && errorBodyMatch[1]) {
                const errorBody = JSON.parse(errorBodyMatch[1]);
                if (errorBody.message) {
                    alertMessage = errorBody.message;
                } else if (errorBody.errors) {
                    const validationErrors = Object.values(errorBody.errors).flat();
                    alertMessage = 'Validasi gagal: ' + validationErrors.join(', ');
                }
            }
        } catch (e) {
            alertMessage = error.message;
        }

        if (error.message.includes('401')) {
            alertMessage = 'Anda harus login terlebih dahulu. Silakan refresh halaman dan login kembali.';
            window.location.href = '/';
        } else if (error.message.includes('422')) {
            alertMessage = 'Data tidak valid. Periksa format data yang dikirim.';
        }

        alert(alertMessage);
    })
    .finally(() => {
        if (konfirmasiPinjamBtn) {
            konfirmasiPinjamBtn.disabled = false;
            konfirmasiPinjamBtn.innerHTML = `
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                </svg>
                Ya, Pinjam Buku
            `;
        }
    });
}

function showKonfirmasiModal() {
    const modal = document.getElementById('konfirmasiPinjamModal');
    if (modal) {
        modal.classList.remove('hidden');
        modal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    }
}

function closeKonfirmasiModal() {
    const modal = document.getElementById('konfirmasiPinjamModal');
    if (modal) {
        modal.classList.add('hidden');
        modal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = 'auto';
    }
}

function closeDetailModal() {
    const modal = document.getElementById('detailModal');
    if (modal) {
        if (typeof Flowbite !== 'undefined' && Flowbite.Modal) {
            const modalInstance = Flowbite.Modal.getInstance(modal);
            if (modalInstance) {
                modalInstance.hide();
                return;
            }
        }
        modal.classList.add('hidden');
        modal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = 'auto';
    }
}

function closeAllModals() {
    closeDetailModal();
    closeKonfirmasiModal();
}

function updateBookStockInUI(bukuIsbn, newStock) {
    const modalStock = document.getElementById('modalStock');
    if (modalStock) {
        modalStock.textContent = newStock;
    }

    const card = document.querySelector(`[data-book-id="${bukuIsbn}"]`);
    if (card) {
        const stockElement = card.querySelector('.stok-value');
        if (stockElement) {
            stockElement.textContent = newStock;
        }
    }

    const pinjamBtn = document.getElementById('pinjamBukuBtn');
    if (pinjamBtn) {
        if (newStock <= 0) {
            pinjamBtn.disabled = true;
            pinjamBtn.textContent = 'Stok Habis';
            pinjamBtn.className = 'text-white bg-gray-400 cursor-not-allowed font-medium rounded-lg text-sm px-4 py-2 text-center';
        } else {
            pinjamBtn.disabled = false;
            pinjamBtn.textContent = 'Pinjam Buku';
            pinjamBtn.className = 'text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800';
        }
    }
}

function filterBooks() {
    const searchTerm = document.getElementById('search').value.toLowerCase().trim();
    const selectedJenisBuku = document.getElementById('filter-kategori').value;
    const selectedKelas = document.getElementById('filter-kelas').value;
    const bukuCards = document.querySelectorAll('.buku-card');
    const noResults = document.getElementById('no-results');

    let visibleCount = 0;

    console.log('Filtering with:', { searchTerm, selectedJenisBuku, selectedKelas });

    bukuCards.forEach(card => {
        const title = card.getAttribute('data-judul') || '';
        const author = card.getAttribute('data-penulis') || '';
        const cardJenisBuku = card.getAttribute('data-kategori') || '';
        const kelas = card.getAttribute('data-kelas') || '';

        const matchesSearch = !searchTerm ||
                               title.includes(searchTerm) ||
                               author.includes(searchTerm);
        const matchesJenisBuku = !selectedJenisBuku || cardJenisBuku === selectedJenisBuku;
        const matchesKelas = !selectedKelas || kelas == selectedKelas;

        if (matchesSearch && matchesJenisBuku && matchesKelas) {
            card.style.display = 'flex';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });

    console.log('Visible count:', visibleCount);

    if (visibleCount === 0 && bukuCards.length > 0) {
        if (noResults) {
            noResults.style.display = 'block';
            noResults.classList.remove('hidden');
        }
    } else {
        if (noResults) {
            noResults.style.display = 'none';
            noResults.classList.add('hidden');
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, bukuData:', bukuData);

    const searchInput = document.getElementById('search');
    const filterKategori = document.getElementById('filter-kategori');
    const filterKelas = document.getElementById('filter-kelas');
    const resetButton = document.getElementById('reset-filter');

    if (searchInput) {
        searchInput.addEventListener('input', filterBooks);
    }

    if (filterKategori) {
        filterKategori.addEventListener('change', filterBooks);
    }

    if (filterKelas) {
        filterKelas.addEventListener('change', filterBooks);
    }

    if (resetButton) {
        resetButton.addEventListener('click', function() {
            if (searchInput) searchInput.value = '';
            if (filterKategori) filterKategori.value = '';
            if (filterKelas) filterKelas.value = '';
            filterBooks();
        });
    }

    const allModalHideButtons = document.querySelectorAll('[data-modal-hide]');
    allModalHideButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetModalId = button.getAttribute('data-modal-hide');
            const targetModal = document.getElementById(targetModalId);
            if (targetModal) {
                if (targetModalId === 'detailModal') {
                    closeDetailModal();
                } else if (targetModalId === 'konfirmasiPinjamModal') {
                    closeKonfirmasiModal();
                }
            }
        });
    });

    const detailModal = document.getElementById('detailModal');
    if (detailModal) {
        detailModal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeDetailModal();
            }
        });
    }

    const konfirmasiModal = document.getElementById('konfirmasiPinjamModal');
    if (konfirmasiModal) {
        konfirmasiModal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeKonfirmasiModal();
            }
        });
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeAllModals();
        }
    });

    const toast = document.getElementById('toast-alert');
    if (toast) {
        setTimeout(() => {
            toast.classList.remove('opacity-0', '-translate-y-4');
            toast.classList.add('opacity-100', 'translate-y-0');
        }, 100);

        setTimeout(() => {
            toast.classList.remove('opacity-100', 'translate-y-0');
            toast.classList.add('opacity-0', '-translate-y-4');
            setTimeout(() => toast.remove(), 500);
        }, 4000);
    }
});
</script>
@endpush