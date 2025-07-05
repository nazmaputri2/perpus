{{-- resources/views/components/koleksibuku/modal-pilih-siswa.blade.php --}}

<div id="pilihSiswaModal" data-modal-toggle="pilihSiswaModal" data-modal-target="pilihSiswaModal" data-modal-hide="pilihSiswaModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Pilih Siswa untuk Peminjaman
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="pilihSiswaModal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <div class="p-4 md:p-5">
                <input type="hidden" id="pilihSiswaBukuIsbn">
                <p class="text-sm text-gray-500 mb-4">Buku: <span id="pilihSiswaBukuJudul" class="font-semibold text-gray-700"></span></p>

                <div class="mb-4">
                    <label for="filterKelasSiswa" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Filter Kelas:</label>
                    <select id="filterKelasSiswa" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                        <option value="">Semua Kelas</option>
                        {{-- Opsi kelas akan dimuat secara dinamis oleh JavaScript --}}
                    </select>
                </div>

                <div class="mb-4">
                    <label for="cariSiswa" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cari Siswa:</label>
                    <input type="text" id="cariSiswa" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="Cari NISN atau Nama Siswa">
                </div>

                <div id="daftarSiswaContainer" class="max-h-60 overflow-y-auto border rounded-lg p-2 bg-gray-50">
                    <ul id="daftarSiswaList" class="divide-y divide-gray-200">
                        {{-- Daftar siswa akan dimuat secara dinamis oleh JavaScript --}}
                    </ul>
                    <p id="noSiswaResults" class="text-center text-gray-500 hidden py-4">Tidak ada siswa ditemukan.</p>
                </div>

            </div>
            <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                <button data-modal-hide="pilihSiswaModal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 
                dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Batal</button>
            </div>
        </div>
    </div>
</div>