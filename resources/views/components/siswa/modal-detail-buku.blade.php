<div id="detailModal" tabindex="-1" aria-hidden="true"
    class="hidden fixed inset-0 z-50 overflow-y-auto overflow-x-hidden">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="relative w-full max-w-3xl bg-white rounded-lg shadow-xl dark:bg-gray-700">
            <!-- Header -->
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

            <!-- Body -->
            <div class="p-6 space-y-6">
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="md:w-1/3 flex justify-center">
                        <img id="modalImage" src="{{ asset('images/default-book.png') }}" class="-lg max-h-60"
                            alt="Cover">
                    </div>
                    <div class="md:w-2/3">
                        <ul class="text-sm text-gray-800 dark:text-gray-200 space-y-4">
                            <li><strong>ISBN:</strong> <span id="modalIsbn"></span></li>
                            <li><strong>Judul:</strong> <span id="modalTitle"></span></li>
                            <li><strong>Penulis:</strong> <span id="modalAuthor"></span></li>
                            <li><strong>Penerbit:</strong> <span id="modalPublisher"></span></li>
                            <li><strong>Tahun:</strong> <span id="modalYear"></span></li>
                            <li><strong>Jumlah Stok:</strong> <span id="modalStock"></span></li>
                            <li>
                                <strong>Sinopsis:</strong><br>
                                <div class="max-h-40 overflow-y-auto mt-1 p-2 bg-gray-50 rounded">
                                    <span id="modalDescription"></span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="flex items-center justify-end p-4 border-t border-gray-200 rounded-b dark:border-gray-600">
                <button id="pinjamBukuBtn" type="button" data-modal-target="konfirmasiPinjamModal" data-modal-hide="detailModal"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Pinjam
                </button>
            </div>
        </div>
    </div>
</div>