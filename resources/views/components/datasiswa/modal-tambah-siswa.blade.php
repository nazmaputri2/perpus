<div id="tambahDataModal" tabindex="-1" aria-hidden="true"
    class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-start justify-between px-4 pt-4 pb-2 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Tambah Data Siswa
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                    data-modal-hide="tambahDataModal">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
            <div class="pt-2 pb-6 px-6 space-y-6">
                <form action="{{ route('petugas.datasiswa.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="nis_siswa"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIS</label>
                        <input type="text" id="nis_siswa" name="nis_siswa" required minlength="10" maxlength="10"
                            oninput=" validateExactLength(this, 10, 'NIS harus tepat 10 digit' )"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    </div>

                    <div>
                        <label for="nama_siswa"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Siswa</label>
                        <input type="text" id="nama_siswa" name="nama_siswa" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    </div>
                    <div>
                        <label for="kelamin_siswa" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Jenis Kelamin</label>
                        <select id="kelamin_siswa" name="kelamin_siswa" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option value="" disabled selected>Pilih Kelamin</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div>
                        <label for="kelas_siswa"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kelas</label>
                        <select id="kelas_siswa" name="kelas_siswa" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option value="" disabled selected>Pilih Kelas</option>
                            <option value="1">Kelas 1</option>
                            <option value="2">Kelas 2</option>
                            <option value="3">Kelas 3</option>
                            <option value="4">Kelas 4</option>
                            <option value="5">Kelas 5</option>
                            <option value="6">Kelas 6</option>
                        </select>
                    </div>

                    <div>
                        <label for="nohp_siswa" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">No
                            HP</label>
                        <input type="text" id="nohp_siswa" name="nohp_siswa" required minlength="12" maxlength="12"
                            oninput="validateExactLength(this, 12, 'No HP harus tepat 12 digit')"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    </div>
                    <button type="submit"
                        class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Simpan</button>
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
</div>