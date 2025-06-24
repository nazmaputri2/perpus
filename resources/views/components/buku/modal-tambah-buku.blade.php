<div id="crud-modal" tabindex="-1" aria-hidden="true"
    class="hidden fixed top-0 left-0 right-0 z-50 w-full p-4 overflow-x-hidden overflow-y-auto h-[calc(100%-1rem)] max-h-full justify-center items-center">
    <div class="relative w-full max-w-lg max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-center justify-between p-4 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Tambah Data Buku</h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 rounded-lg text-sm w-8 h-8 flex items-center justify-center"
                    data-modal-toggle="crud-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>

            <form action="{{ route('petugas.databuku.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="isbn"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ISBN</label>
                        <input type="text" id="isbn" name="isbn" required minlength="10" maxlength="10"
                            oninput=" validateExactLength(this, 10, 'ISBN harus tepat 10 digit' )"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                    </div>
                    <div>
                        <label for="judul"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Judul Buku</label>
                        <input type="text" id="judul" name="judul" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="penulis"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Penulis</label>
                        <input type="text" id="penulis" name="penulis" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                    </div>
                    <div>
                        <label for="penerbit"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Penerbit</label>
                        <input type="text" id="penerbit" name="penerbit" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="tahun_terbit"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tahun Terbit</label>
                        <select id="tahun_terbit" name="tahun_terbit" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                            <option value="" disabled selected>Pilih Tahun</option>
                            @php
                                $currentYear = date("Y");
                                for ($year = $currentYear; $year >= 1900; $year--) {
                                    echo "<option value=\"$year\">$year</option>";
                                }
                            @endphp
                        </select>
                    </div>
                    <div>
                        <label for="stok"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Stok</label>
                        <input type="number" id="stok" name="stok" min="0" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                    </div>
                </div>

                <div>
                    <label for="sinopsis"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Sinopsis</label>
                    <textarea id="sinopsis" name="sinopsis" rows="3" required
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"></textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="jenis_buku"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jenis Buku</label>
                        <select id="jenis_buku" name="jenis_buku" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                            <option value="" disabled selected>Pilih</option> {{-- Perbaiki default option --}}
                            <option value="Pelajaran">Pelajaran</option>
                            <option value="Fiksi">Fiksi</option>
                            <option value="Non-Fiksi">Non-Fiksi</option>
                        </select>
                    </div>
                    <div>
                        <label for="kelas"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kelas</label>
                        <select id="kelas" name="kelas" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                            <option value="" disabled selected>Pilih</option> {{-- Perbaiki default option --}}
                            <option value="Tidak Ada">Tidak Ada</option>
                            <option value="6">6</option>
                            <option value="5">5</option>
                            <option value="4">4</option>
                            <option value="3">3</option>
                            <option value="2">2</option>
                            <option value="1">1</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label for="gambar"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Gambar</label> {{-- Ubah label --}}
                    <input type="file" id="gambar" name="gambar" accept="image/*" required
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50">
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5">Simpan</button>
                </div>
            </form>
            <script>
                    function validateExactLength(input, requiredLength, message) {
                        if (input.value.length !== requiredLength) {
                            input.setCustomValidity(message);
                        } else {
                            input.setCustomValidity('');
                        }
                    }
                </script>
        </div>
    </div>
</div>