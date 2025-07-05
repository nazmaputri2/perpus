{{-- components/siswa/modal-konfirmasi-pinjam.blade.php --}}
<div id="konfirmasiPinjamModal" tabindex="-1" aria-hidden="true" 
    class="hidden fixed inset-0 z-50 overflow-y-auto overflow-x-hidden">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="relative w-full max-w-md bg-white rounded-lg shadow-xl dark:bg-gray-700">
            <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white transition-colors" data-modal-hide="konfirmasiPinjamModal" onclick="closeKonfirmasiModal()">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
            
            <div class="p-6 text-center">
                <div class="mx-auto mb-4 w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-yellow-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                </div>
                
                <h3 class="mb-6 text-xl font-semibold text-gray-900 dark:text-white">
                    Konfirmasi Peminjaman Buku
                </h3>
                
                <p class="mb-6 text-gray-600 dark:text-gray-400">
                    Apakah kamu yakin ingin meminjam buku ini?
                </p>
                
                <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <div class="flex items-start gap-3">
                        <div class="w-12 h-16 bg-blue-600 rounded flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="text-left flex-1">
                            <h4 id="konfirmasiBukuJudul" class="font-semibold text-gray-900 dark:text-white text-sm mb-1">
                                </h4>
                            <p id="konfirmasiBukuPenulis" class="text-xs text-gray-600 dark:text-gray-300">
                                </p>
                            <div class="mt-2 flex gap-2 text-xs">
                                <span id="konfirmasiBukuISBN" class="px-2 py-1 bg-gray-100 text-gray-700 rounded">
                                    </span>
                                <span id="konfirmasiBukuStok" class="px-2 py-1 bg-green-100 text-green-700 rounded">
                                    </span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mb-6 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <p class="text-sm text-yellow-800">
                        <span class="font-medium">Perhatian:</span> 
                        Pastikan untuk mengembalikan buku tepat waktu sesuai dengan ketentuan perpustakaan.
                    </p>
                </div>
                
                <div class="flex gap-3 justify-center">
                    <button id="konfirmasiPinjamBtn" type="button" 
                            class="flex items-center justify-center px-6 py-3 text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm transition-all duration-200 shadow-md hover:shadow-lg dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Ya, Pinjam Buku
                    </button>
                    
                    <button data-modal-hide="konfirmasiPinjamModal" type="button" onclick="closeKonfirmasiModal()"
                            class="px-6 py-3 text-gray-700 bg-gray-100 hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm border border-gray-300 transition-all duration-200 dark:bg-gray-600 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-gray-700">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>