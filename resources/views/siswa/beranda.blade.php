@extends('layouts.siswa')

@section('title', 'Beranda Siswa')

@push('modals')
    @include('components.modal-ubah-sandi')
    @include('components.modal-keluar')
    @include('components.siswa.modal-detail-buku')
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
        
        <!-- Card Utama -->
        <div class="p-4 bg-white rounded-xl shadow-lg mb-6 border border-gray-200 max-w-7xl mx-auto">
            <!-- Kiri: Search & Dropdowns -->
            <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto flex-grow mb-6">
                <!-- Search Bar -->
                <div class="relative w-full sm:w-64">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="fas fa-search text-gray-500"></i>
                    </div>
                    <input type="text" id="search"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                        placeholder="Cari buku...">
                </div>

                <!-- Filter Kategori -->
                <select id="filter-kategori"
                    class="w-28 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                    <option selected disabled>Kategori</option>
                    @foreach($kategoriOptions as $kategori)
                    <option value="{{ $kategori }}">{{ $kategori }}</option>
                    @endforeach
                </select>

                <!-- Filter Kelas -->
                <select id="filter-kelas"
                    class="w-28 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                    <option selected disabled>Kelas</option>
                    @foreach($kelasOptions as $kelas)
                    <option value="{{ $kelas }}">Kelas {{ $kelas }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Card Buku -->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4 mb-4">
                @foreach($buku as $bukuItem)
                <div onclick="openDetailModal(@json($bukuItem))"
                data-modal-target="detailModal" data-modal-toggle="detailModal"
                    class="flex items-center justify-center flex-col rounded-lg bg-white-100 p-4 shadow-md transition-all duration-300 hover:scale-105 cursor-pointer transform-gpu origin-center">
                    <img src="{{ asset($bukuItem['gambar']) }}" alt="Book Icon" class="h-auto max-w-full" >
                    <p class="mt-2 text-sm text-center text-gray-700">{{ $bukuItem['judul'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Function to open detail modal with book data
    function openDetailModal(data) {
        // Fill in the modal data
        document.getElementById('modalImage').src = data.gambar;
        document.getElementById('modalIsbn').textContent = data.isbn;
        document.getElementById('modalTitle').textContent = data.judul;
        document.getElementById('modalAuthor').textContent = data.penulis;
        document.getElementById('modalPublisher').textContent = data.penerbit;
        document.getElementById('modalYear').textContent = data.tahun_terbit;
        document.getElementById('modalStock').textContent = data.stok;
        document.getElementById('modalDescription').textContent = data.deskripsi;

        // Set up pinjam button
        const pinjamBtn = document.getElementById('pinjamBukuBtn');
        pinjamBtn.onclick = function() {
            // AJAX request to pinjam buku
            fetch("{{ route('siswa.pinjam.buku') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    buku_id: data.id
                })
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    alert('Buku berhasil dipinjam');
                    // Close modal
                    const modal = Flowbite.getInstance(document.getElementById('detailModal'));
                    modal.hide();
                } else {
                    alert(data.message || 'Gagal meminjam buku');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat meminjam buku');
            });
        };

        // Open the detail modal
        const detailModal = document.getElementById('detailModal');
        const modal = new Flowbite.Modal(detailModal);
        modal.show();
    }

    // Search functionality
    document.getElementById('search').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const bukuCards = document.querySelectorAll('.grid > div');
        
        bukuCards.forEach(card => {
            const title = card.querySelector('p').textContent.toLowerCase();
            if(title.includes(searchTerm)) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    });

    // Filter functionality
    document.getElementById('filter-kategori').addEventListener('change', function(e) {
        // Implement filter by category
        console.log('Filter by category:', e.target.value);
    });

    document.getElementById('filter-kelas').addEventListener('change', function(e) {
        // Implement filter by class
        console.log('Filter by class:', e.target.value);
    });


</script>
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const toast = document.getElementById('toast-alert');
        if (toast) {
            // Animasi masuk
            setTimeout(() => {
                toast.classList.remove('opacity-0', 'translate-y-[-20px]');
                toast.classList.add('opacity-100', 'translate-y-0');
            }, 100);

            // Animasi keluar setelah 3 detik
            setTimeout(() => {
                toast.classList.remove('opacity-100', 'translate-y-0');
                toast.classList.add('opacity-0', 'translate-y-[-20px]');

                // Hapus dari DOM setelah transisi selesai (500ms)
                setTimeout(() => toast.remove(), 500);
            }, 3000);
        }
    });
</script>
@endpush
@endpush