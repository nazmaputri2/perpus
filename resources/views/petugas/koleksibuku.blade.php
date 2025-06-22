{{-- resources/views/petugas/koleksibuku.blade.php --}}

@extends('layouts.petugas')

@section('title', 'Data Peminjaman - Pilih Buku')

@push('modals')
    {{-- Ini adalah modal yang akan digunakan. Pastikan ID dan strukturnya sesuai. --}}
    @include('components.modal-ubah-sandi')
    @include('components.modal-keluar')
    @include('components.koleksibuku.modal-detail-buku')
    @include('components.koleksibuku.modal-pilih-siswa')
@endpush

@section('content')
<div class="p-4 bg-white rounded-xl shadow-lg mb-6 border border-gray-200 max-w-7xl mx-auto">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Pilih Buku untuk Peminjaman</h2>

    <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto flex-grow mb-6">
        {{-- Filter dan Pencarian --}}
        <div class="flex-grow">
            <label for="search" class="sr-only">Cari Buku</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <input type="text" id="search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Cari Judul, Penulis...">
            </div>
        </div>

        <div class="flex gap-3">
            <div>
                <label for="filter-kategori" class="sr-only">Filter Kategori</label>
                <select id="filter-kategori" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoriOptions as $kategori)
                        <option value="{{ $kategori }}">{{ $kategori }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="filter-kelas" class="sr-only">Filter Kelas</label>
                <select id="filter-kelas" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                    <option value="">Semua Kelas</option>
                    @foreach($kelasOptions as $kelas)
                        <option value="{{ $kelas }}">Kelas {{ $kelas }}</option>
                    @endforeach
                </select>
            </div>
            <button id="reset-filter" class="p-2.5 text-sm font-medium text-white bg-gray-600 rounded-lg border border-gray-700 hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-300 dark:bg-gray-500 dark:hover:bg-gray-600 dark:focus:ring-gray-700">
                Reset
            </button>
        </div>
    </div>

    <div id="buku-container" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4 mb-4">
        @forelse($buku as $bukuItem)
        <div class="buku-card flex items-center justify-center flex-col rounded-lg bg-white-100 p-4 shadow-md transition-all duration-300 hover:scale-105 cursor-pointer transform-gpu origin-center"
             onclick="openDetailModal('{{ $bukuItem->isbn }}')"
             data-modal-target="detailModal"
             data-modal-toggle="detailModal"
             data-isbn="{{ $bukuItem->isbn }}"
             data-judul="{{ strtolower($bukuItem->judul) }}"
             data-penulis="{{ strtolower($bukuItem->penulis ?? '') }}"
             data-penerbit="{{ strtolower($bukuItem->penerbit ?? '') }}"
             data-tahun-terbit="{{ $bukuItem->tahun_terbit ?? '' }}"
             data-sinopsis="{{ $bukuItem->sinopsis ?? '' }}"
             data-stok="{{ $bukuItem->stok }}"
             data-jenis-buku="{{ $bukuItem->jenis_buku ?? '' }}"
             data-kelas="{{ $bukuItem->kelas ?? '' }}"
             data-gambar="{{ $bukuItem->gambar }}">

            <img src="{{ $bukuItem->gambar }}"
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
                <p class="text-lg">Belum ada buku tersedia.</p>
            </div>
        </div>
        @endforelse
    </div>

    <div id="no-results" class="hidden col-span-full text-center py-8">
        <div class="text-gray-500">
            <i class="fas fa-search text-4xl mb-4"></i>
            <p class="text-lg">Tidak ada buku yang sesuai dengan pencarian atau filter.</p>
        </div>
    </div>
</div>

@endsection

@push('scripts')
{{-- Sertakan Flowbite JS di sini, jika belum di layouts/petugas --}}
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script> --}}
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js.map"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Data yang dilewatkan dari Laravel
    const bukuData = @json($buku);
    const siswaData = @json($siswa);

    let currentSelectedBookIsbn = null; // Menyimpan ISBN buku yang sedang dipilih

    /**
     * Mengambil data buku berdasarkan ISBN.
     * @param {string} isbn
     * @returns {object|undefined} Objek buku atau undefined jika tidak ditemukan.
     */
    function getBookById(isbn) {
        return bukuData.find(book => book.isbn === isbn);
    }

    /**
     * Mengatur textContent dari elemen HTML berdasarkan ID.
     * Tidak akan menampilkan warning jika elemen tidak ditemukan, sesuai permintaan.
     * @param {string} elementId - ID dari elemen HTML.
     * @param {string|number|null} value - Nilai yang akan diatur.
     * @param {string} defaultValue - Nilai default jika 'value' kosong/null.
     */
    function safeSetTextContent(elementId, value, defaultValue = '-') {
        const element = document.getElementById(elementId);
        if (element) {
            element.textContent = value !== null && value !== undefined && value !== '' ? value : defaultValue;
        }
    }

    /**
     * Memeriksa apakah Flowbite Modal API tersedia.
     * @returns {boolean} True jika tersedia, false jika tidak.
     */
    function isFlowbiteAvailable() {
        return typeof Flowbite !== 'undefined' && Flowbite.Modal && typeof Flowbite.Modal === 'function';
    }

    // --- FUNGSI UTILITY UNTUK MODAL MANUAL (FALLBACK JIKA FLOWBITE TIDAK ADA) ---

    /**
     * Menampilkan modal secara manual (tanpa Flowbite).
     * @param {HTMLElement} modalElement - Elemen modal yang akan ditampilkan.
     */
    function showModal(modalElement) {
        if (modalElement) {
            modalElement.classList.remove('hidden');
            modalElement.setAttribute('aria-hidden', 'false');
            modalElement.style.display = 'flex'; // Atau 'block' tergantung kebutuhan layout modal

            // Tambahkan backdrop
            const backdrop = document.createElement('div');
            backdrop.classList.add('modal-backdrop', 'bg-gray-900/50', 'fixed', 'inset-0', 'z-40');
            backdrop.id = modalElement.id + '-backdrop';
            document.body.appendChild(backdrop);

            // Event listener untuk menutup modal ketika klik backdrop
            backdrop.addEventListener('click', () => hideModal(modalElement));

            // Menambah kelas untuk mencegah scroll body saat modal aktif
            document.body.classList.add('overflow-hidden');
        }
    }

    /**
     * Menyembunyikan modal secara manual (tanpa Flowbite).
     * @param {HTMLElement} modalElement - Elemen modal yang akan disembunyikan.
     */
    function hideModal(modalElement) {
        if (modalElement) {
            modalElement.classList.add('hidden');
            modalElement.setAttribute('aria-hidden', 'true');
            modalElement.style.display = 'none';

            // Hapus backdrop
            const backdrop = document.getElementById(modalElement.id + '-backdrop');
            if (backdrop) {
                backdrop.remove();
            }

            // Hapus kelas untuk mengizinkan scroll body kembali
            document.body.classList.remove('overflow-hidden');
        }
    }

    // --- FUNGSI UNTUK MODAL DETAIL BUKU ---

    /**
     * Membuka modal detail buku dengan data buku yang dipilih.
     * @param {string} bookIsbn - ISBN buku yang akan ditampilkan detailnya.
     */
    function openDetailModal(bookIsbn) {
        const data = getBookById(bookIsbn);

        if (!data) {
            Swal.fire('Error', 'Data buku tidak ditemukan.', 'error');
            console.error(`Buku dengan ISBN ${bookIsbn} tidak ditemukan di bukuData.`);
            return;
        }

        currentSelectedBookIsbn = bookIsbn; // Simpan ISBN buku yang sedang dilihat

        // Isi data ke elemen modal
        const modalImage = document.getElementById('modalImage');
        if (modalImage) {
            modalImage.src = data.gambar || '{{ asset('images/default-book.png') }}';
            modalImage.alt = data.judul || 'Cover Buku';
        }

        safeSetTextContent('modalIsbn', data.isbn);
        safeSetTextContent('modalTitle', data.judul);
        safeSetTextContent('modalAuthor', data.penulis);
        safeSetTextContent('modalPublisher', data.penerbit);
        safeSetTextContent('modalYear', data.tahun_terbit);
        safeSetTextContent('modalStock', data.stok !== null ? data.stok : '0');
        safeSetTextContent('modalDescription', data.sinopsis, 'Tidak ada sinopsis tersedia');

        // Atur status tombol 'Pinjam' berdasarkan stok
        const pinjamButton = document.getElementById('pinjamBukuBtn');
        if (pinjamButton) {
            if (data.stok <= 0) {
                pinjamButton.setAttribute('disabled', 'true');
                pinjamButton.classList.add('opacity-50', 'cursor-not-allowed');
                pinjamButton.textContent = 'Stok Habis';
            } else {
                pinjamButton.removeAttribute('disabled');
                pinjamButton.classList.remove('opacity-50', 'cursor-not-allowed');
                pinjamButton.textContent = 'Pinjam';
            }
        }

        const detailModalTargetEl = document.getElementById('detailModal');
        if (detailModalTargetEl) {
            if (isFlowbiteAvailable()) {
                try {
                    // Inisialisasi Flowbite Modal jika tersedia
                    const detailModal = new Flowbite.Modal(detailModalTargetEl, {
                        placement: 'center',
                        backdrop: 'dynamic',
                        backdropClasses: 'bg-gray-900/50 dark:bg-gray-900/80 fixed inset-0 z-40',
                        closable: true,
                    });
                    detailModal.show();
                } catch (error) {
                    console.warn('Flowbite Modal error, using manual modal:', error);
                    showModal(detailModalTargetEl);
                }
            } else {
                console.warn('Flowbite not available, using manual modal');
                showModal(detailModalTargetEl);
            }
        } else {
            console.error('Element with ID "detailModal" not found.');
        }
    }

    // --- FUNGSI UNTUK MODAL PILIH SISWA ---

    /**
     * Membuka modal pilih siswa.
     * @param {string} isbn - ISBN buku yang akan dipinjam.
     * @param {string} judulBuku - Judul buku yang akan dipinjam.
     */
    function openPilihSiswaModal(isbn, judulBuku) {
        const pilihSiswaBukuIsbnEl = document.getElementById('pilihSiswaBukuIsbn');
        const pilihSiswaBukuJudulEl = document.getElementById('pilihSiswaBukuJudul');
        const filterKelasSiswaEl = document.getElementById('filterKelasSiswa');
        const cariSiswaEl = document.getElementById('cariSiswa');
        const pilihSiswaModalTargetEl = document.getElementById('pilihSiswaModal');

        // Isi detail buku di modal pilih siswa
        if (pilihSiswaBukuIsbnEl) pilihSiswaBukuIsbnEl.value = isbn;
        if (pilihSiswaBukuJudulEl) pilihSiswaBukuJudulEl.textContent = judulBuku;

        // Reset filter dan pencarian siswa setiap kali modal dibuka
        if (filterKelasSiswaEl) filterKelasSiswaEl.value = '';
        if (cariSiswaEl) cariSiswaEl.value = '';

        // Render daftar siswa (tanpa filter awal)
        renderSiswaList(siswaData);

        // Isi opsi filter kelas siswa secara dinamis
        if (filterKelasSiswaEl) {
            filterKelasSiswaEl.innerHTML = '<option value="">Semua Kelas</option>';
            const uniqueKelas = [...new Set(siswaData.map(siswa => siswa.kelas_siswa))].sort();
            uniqueKelas.forEach(kelas => {
                if (kelas) {
                    const option = document.createElement('option');
                    option.value = kelas;
                    option.textContent = `Kelas ${kelas}`;
                    filterKelasSiswaEl.appendChild(option);
                }
            });
        }

        // Tampilkan modal pilih siswa (menggunakan Flowbite atau manual)
        if (pilihSiswaModalTargetEl) {
            if (isFlowbiteAvailable()) {
                try {
                    const pilihSiswaModal = new Flowbite.Modal(pilihSiswaModalTargetEl, {
                        placement: 'center',
                        backdrop: 'dynamic',
                        backdropClasses: 'bg-gray-900/50 dark:bg-gray-900/80 fixed inset-0 z-40',
                        closable: true,
                    });
                    pilihSiswaModal.show();
                } catch (error) {
                    console.warn('Flowbite Modal error for pilihSiswaModal, using manual modal:', error);
                    showModal(pilihSiswaModalTargetEl);
                }
            } else {
                console.warn('Flowbite not available for pilihSiswaModal, using manual modal');
                showModal(pilihSiswaModalTargetEl);
            }
        } else {
            console.error('Element with ID "pilihSiswaModal" not found.');
        }
    }

    /**
     * Merender daftar siswa di modal pilih siswa berdasarkan data filter.
     * @param {Array<object>} filteredSiswa - Array objek siswa yang sudah difilter.
     */
    function renderSiswaList(filteredSiswa) {
        const daftarSiswaList = document.getElementById('daftarSiswaList');
        const noSiswaResults = document.getElementById('noSiswaResults');

        if (!daftarSiswaList || !noSiswaResults) {
            console.warn('Elements for student list in modal not found.');
            return;
        }

        daftarSiswaList.innerHTML = ''; // Kosongkan daftar yang ada

        if (filteredSiswa.length === 0) {
            noSiswaResults.classList.remove('hidden');
        } else {
            noSiswaResults.classList.add('hidden');
            filteredSiswa.forEach(siswa => {
                const listItem = document.createElement('li');
                listItem.classList.add('py-2', 'px-3', 'hover:bg-gray-100', 'cursor-pointer', 'rounded-md');
                listItem.innerHTML = `
                    <p class="font-medium text-gray-900">${siswa.nama_siswa}</p>
                    <p class="text-sm text-gray-500">NISN: ${siswa.nis_siswa} | Kelas: ${siswa.kelas_siswa}</p>
                `;
                listItem.addEventListener('click', () => confirmPeminjaman(siswa.nis_siswa, siswa.nama_siswa));
                daftarSiswaList.appendChild(listItem);
            });
        }
    }

    /**
     * Menerapkan filter dan pencarian pada daftar siswa di modal.
     */
    function filterAndSearchSiswa() {
        const selectedKelas = document.getElementById('filterKelasSiswa')?.value || '';
        const searchTerm = document.getElementById('cariSiswa')?.value.toLowerCase() || '';

        const filtered = siswaData.filter(siswa => {
            const matchesKelas = selectedKelas === '' || siswa.kelas_siswa == selectedKelas;
            const matchesSearch = siswa.nama_siswa.toLowerCase().includes(searchTerm) ||
                                  siswa.nis_siswa.toLowerCase().includes(searchTerm);
            return matchesKelas && matchesSearch;
        });
        renderSiswaList(filtered);
    }

    // --- FUNGSI KONFIRMASI DAN PROSES PEMINJAMAN ---

    /**
     * Menampilkan konfirmasi peminjaman menggunakan SweetAlert2.
     * @param {string} nisSiswa - NISN siswa yang akan meminjam.
     * @param {string} namaSiswa - Nama siswa yang akan meminjam.
     */
    function confirmPeminjaman(nisSiswa, namaSiswa) {
        const isbnBuku = document.getElementById('pilihSiswaBukuIsbn')?.value;
        const judulBuku = document.getElementById('pilihSiswaBukuJudul')?.textContent;

        if (!isbnBuku || !judulBuku) {
            Swal.fire('Error', 'Data buku atau siswa tidak lengkap untuk konfirmasi.', 'error');
            return;
        }

        Swal.fire({
            title: 'Konfirmasi Peminjaman',
            html: `Anda akan meminjamkan buku <strong>"${judulBuku}"</strong> kepada siswa <strong>${namaSiswa} (NISN: ${nisSiswa})</strong>.`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Pinjam!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                performPeminjaman(isbnBuku, nisSiswa);
            }
        });
    }

    /**
     * Melakukan permintaan API POST untuk mencatat peminjaman.
     * @param {string} isbnBuku - ISBN buku yang dipinjam.
     * @param {string} nisSiswa - NISN siswa yang meminjam.
     */
    function performPeminjaman(isbnBuku, nisSiswa) {
        // Tutup modal pemilihan siswa terlebih dahulu secara eksplisit
        const pilihSiswaModalElement = document.getElementById('pilihSiswaModal');
        hideModal(pilihSiswaModalElement); // Pastikan modal ini ditutup

        Swal.fire({
            title: 'Memproses...',
            text: 'Sedang mencatat peminjaman buku...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        fetch('{{ route('peminjaman.store') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                isbn_buku: isbnBuku, // Pastikan ini sesuai dengan validasi di Controller
                nis_siswa: nisSiswa
            })
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(errorData => {
                    // Log error dari server
                    console.error('Server response error:', errorData);
                    throw new Error(errorData.message || 'Terjadi kesalahan pada server.');
                });
            }
            return response.json();
        })
        .then(data => {
            Swal.close(); // Tutup SweetAlert loading
            if (data.success) {
                Swal.fire({
                    title: 'Berhasil!',
                    text: data.message,
                    icon: 'success'
                }).then(() => {
                    // Opsional: refresh halaman atau update UI tanpa refresh penuh
                    // Untuk kesederhanaan dan memastikan data terbaru, kita bisa refresh
                    location.reload(); 

                    // Atau jika ingin update UI tanpa reload:
                    // updateStokBukuUI(isbnBuku, data.new_stok);
                    // updateStokBukuData(isbnBuku, data.new_stok);
                });
            } else {
                Swal.fire('Gagal!', data.message || 'Peminjaman gagal.', 'error');
            }
        })
        .catch(error => {
            Swal.close(); // Tutup SweetAlert loading
            console.error('Error saat melakukan peminjaman:', error);
            Swal.fire('Error!', error.message || 'Terjadi kesalahan yang tidak terduga saat melakukan peminjaman.', 'error');
        });
    }

    /**
     * Memperbarui tampilan stok buku di kartu buku.
     * (Opsional, jika tidak ingin reload halaman)
     */
    function updateStokBukuUI(isbn, newStok) {
        const bookCard = document.querySelector(`.buku-card[data-isbn="${isbn}"]`);
        if (bookCard) {
            const stokValueSpan = bookCard.querySelector('.stok-value');
            if (stokValueSpan) {
                stokValueSpan.textContent = newStok;
            }
        }
    }

    /**
     * Memperbarui data stok buku di array JavaScript.
     * (Opsional, jika tidak ingin reload halaman)
     */
    function updateStokBukuData(isbn, newStok) {
        const bookDataInJs = bukuData.find(book => book.isbn === isbn);
        if (bookDataInJs) {
            bookDataInJs.stok = newStok;
        }
    }

    // --- INISIALISASI DAN EVENT LISTENERS ---

    document.addEventListener('DOMContentLoaded', function() {
        // Event listener untuk tombol "Pinjam" di modal detail buku
        const pinjamBtn = document.getElementById('pinjamBukuBtn');
        if (pinjamBtn) {
            pinjamBtn.addEventListener('click', function() {
                if (!currentSelectedBookIsbn) {
                    Swal.fire('Error', 'Tidak ada buku yang dipilih.', 'error');
                    return;
                }
                const book = getBookById(currentSelectedBookIsbn);
                if (!book || book.stok <= 0) {
                    Swal.fire('Informasi', 'Stok buku ini sudah habis atau data tidak valid.', 'info');
                    return;
                }

                // Tutup modal detail buku secara eksplisit sebelum membuka modal siswa
                const detailModalTargetEl = document.getElementById('detailModal');
                hideModal(detailModalTargetEl);

                openPilihSiswaModal(currentSelectedBookIsbn, book.judul);
            });
        }

        // Event listener untuk semua tombol close modal (data-modal-hide)
        const closeButtons = document.querySelectorAll('[data-modal-hide]');
        closeButtons.forEach(button => {
            button.addEventListener('click', function() {
                const modalId = this.getAttribute('data-modal-hide');
                const modalElement = document.getElementById(modalId);
                // Cek jika Flowbite tersedia, gunakan metode hide-nya
                if (isFlowbiteAvailable() && modalElement.classList.contains('flex')) { // Cek apakah modal aktif Flowbite
                    try {
                        const flowbiteModalInstance = new Flowbite.Modal(modalElement);
                        flowbiteModalInstance.hide();
                    } catch (e) {
                        // Fallback ke manual jika Flowbite instance gagal
                        hideModal(modalElement);
                    }
                } else {
                    hideModal(modalElement); // Gunakan fungsi manual hide
                }
            });
        });

        // Event listener untuk filter dan pencarian buku utama
        const searchInput = document.getElementById('search');
        const filterKategori = document.getElementById('filter-kategori');
        const filterKelas = document.getElementById('filter-kelas');
        const resetFilterBtn = document.getElementById('reset-filter');
        const allBukuCards = document.querySelectorAll('.buku-card');

        function applyFiltersBuku() { // Rename fungsi agar lebih spesifik
            const searchTerm = searchInput?.value.toLowerCase() || '';
            const selectedKategori = filterKategori?.value || '';
            const selectedKelas = filterKelas?.value || '';
            let resultsFound = false;

            allBukuCards.forEach(card => {
                const judul = card.dataset.judul || '';
                const penulis = card.dataset.penulis || '';
                const kategori = card.dataset.jenisBuku || '';
                const kelas = card.dataset.kelas || '';

                const matchesSearch = judul.includes(searchTerm) || penulis.includes(searchTerm);
                const matchesKategori = selectedKategori === '' || kategori === selectedKategori;
                const matchesKelas = selectedKelas === '' || kelas === selectedKelas;

                if (matchesSearch && matchesKategori && matchesKelas) {
                    card.style.display = 'flex';
                    resultsFound = true;
                } else {
                    card.style.display = 'none';
                }
            });

            const noResultsMessage = document.getElementById('no-results');
            if (noResultsMessage) {
                if (resultsFound) {
                    noResultsMessage.classList.add('hidden');
                } else {
                    noResultsMessage.classList.remove('hidden');
                }
            }
        }

        if (searchInput) searchInput.addEventListener('keyup', applyFiltersBuku);
        if (filterKategori) filterKategori.addEventListener('change', applyFiltersBuku);
        if (filterKelas) filterKelas.addEventListener('change', applyFiltersBuku);
        if (resetFilterBtn) {
            resetFilterBtn.addEventListener('click', function() {
                if (searchInput) searchInput.value = '';
                if (filterKategori) filterKategori.value = '';
                if (filterKelas) filterKelas.value = '';
                applyFiltersBuku();
            });
        }

        applyFiltersBuku(); // Terapkan filter saat halaman pertama kali dimuat

        // Event listener untuk filter dan pencarian siswa di modal
        const filterKelasSiswaModal = document.getElementById('filterKelasSiswa');
        const cariSiswaModal = document.getElementById('cariSiswa');

        if (filterKelasSiswaModal) filterKelasSiswaModal.addEventListener('change', filterAndSearchSiswa);
        if (cariSiswaModal) cariSiswaModal.addEventListener('keyup', filterAndSearchSiswa);
    });
</script>
@endpush