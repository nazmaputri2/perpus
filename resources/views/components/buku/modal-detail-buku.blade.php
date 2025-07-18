<div id="detailModal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-black bg-opacity-30 backdrop-blur-sm">
    <div class="relative w-full max-w-3xl h-full md:h-auto">
        <div class="relative bg-white rounded-xl shadow-lg dark:bg-gray-800">
            <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Detail Buku</h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                    data-modal-hide="detailModal">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 011.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </div>

            <div class="p-6 space-y-6">
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="md:w-1/3 flex justify-center">
                        <img id="modalImage" src="" class="rounded-lg max-h-60 object-contain" alt="Cover"> {{-- object-contain untuk menghindari distorsi --}}
                    </div>
                    <div class="md:w-2/3">
                        <ul class="text-sm text-gray-800 dark:text-gray-200 space-y-2"> {{-- Kurangi spacing --}}
                            <li><strong>ISBN:</strong> <span id="modalIsbn"></span></li>
                            <li><strong>Judul:</strong> <span id="modalTitle"></span></li>
                            <li><strong>Penulis:</strong> <span id="modalAuthor"></span></li>
                            <li><strong>Penerbit:</strong> <span id="modalPublisher"></span></li>
                            <li><strong>Tahun Terbit:</strong> <span id="modalYear"></span></li> {{-- Sesuaikan label --}}
                            <li><strong>Jumlah Stok:</strong> <span id="modalStock"></span></li>
                            <li><strong>Jenis Buku:</strong> <span id="modalJenisbuku"></span></li>
                            <li><strong>Kelas:</strong> <span id="modalkelas"></span></li>
                            <li>
                                <strong>Sinopsis:</strong><br>
                                <div class="max-h-40 overflow-y-auto mt-1 p-2 bg-gray-50 rounded dark:bg-gray-600 dark:text-gray-300">
                                    <span id="modalDescription"></span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>