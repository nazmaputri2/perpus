<div id="deleteModal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-grey bg-opacity-50 backdrop-blur-sm">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="modal-content relative bg-white rounded-xl shadow-lg dark:bg-gray-800">
            <button type="button"
                class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                data-modal-hide="deleteModal">
                <i class="fas fa-times w-3 h-3"></i>
                <span class="sr-only">Close modal</span>
            </button>
            <div class="p-4 md:p-5 text-center">
                <div class="animate-pop-in mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-red-100 dark:bg-red-800/30">
                    <svg class="animate-pulse-slow h-12 w-12 text-red-600 dark:text-red-400" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>

                <h3 class="my-5 text-lg font-medium text-gray-800 dark:text-gray-300">Apakah Anda yakin ingin menghapus data ini?</h3>
                <p class="mb-6 text-sm text-gray-500 dark:text-gray-400">Tindakan ini tidak dapat diurungkan.</p>

                <div class="flex justify-center space-x-4">
                    <button data-modal-hide="deleteModal" type="button"
                        class="py-2.5 px-5 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:scale-105 focus:ring-4 focus:outline-none focus:ring-gray-200 transition-all duration-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-gray-700">
                        Batal
                    </button>
                    <form id="delete-form" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="py-2.5 px-5 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 hover:scale-105 focus:ring-4 focus:outline-none focus:ring-red-300 transition-all duration-200 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">
                            Ya, Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>