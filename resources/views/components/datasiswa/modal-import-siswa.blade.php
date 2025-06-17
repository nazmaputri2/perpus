<div id="importDataModal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-lg max-h-full">
        <div class="relative bg-white rounded-2xl shadow-2xl">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                <h3 class="text-xl font-semibold text-gray-900">
                    Import Data Siswa
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                    data-modal-hide="importDataModal">
                    <i class="fas fa-times"></i>
                    <span class="sr-only">Tutup modal</span>
                </button>
            </div>
            <form action="{{-- route('siswa.import') --}}" method="POST" enctype="multipart/form-data" class="p-4 md:p-5">
                @csrf
                <div class="mb-4">
                    <p class="text-sm text-gray-600 mb-2">
                        Pastikan file Anda sesuai dengan format yang kami sediakan.
                    </p>
                   
                </div>

                <div class="mb-6">
                    <label for="file_import" class="block mb-2 text-sm font-medium text-gray-900">Pilih File untuk Diunggah</label>
                    <input type="file" name="file" id="file_import"
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none file:bg-gray-200 file:text-gray-800 file:p-2.5 file:border-0"
                        required accept=".xls,.xlsx">
                    <p class="mt-1 text-xs text-gray-500" id="file_input_help">Hanya file .XLS atau .XLSX yang diterima.</p>
                </div>

                <div class="flex items-center justify-end pt-4 border-t">
                     <button data-modal-hide="importDataModal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 me-3">
                        Batal
                    </button>
                    <button type="submit"
                        class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        <i class="fas fa-upload me-2"></i>Upload & Import
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>