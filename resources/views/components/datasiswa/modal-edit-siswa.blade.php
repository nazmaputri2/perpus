<div id="editDataModal" tabindex="-1" aria-hidden="true"
    class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Ubah Data Siswa
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                    data-modal-hide="editDataModal">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
            <div class="pt-2 pb-6 px-6 space-y-6">
                <form id="edit-form" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label for="edit-nis_siswa"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIS</label>
                        <input type="text" id="edit-nis_siswa" name="nis_siswa" readonly
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    </div>
                    <div>
                        <label for="edit-nama_siswa"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Siswa</label>
                        <input type="text" id="edit-nama_siswa" name="nama_siswa" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    </div>
                    <div>
                        <label for="edit-kelamin_siswa"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"> Jenis Kelamin</label>
                        <select id="edit-kelamin_siswa" name="kelamin_siswa" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div>
                        <label for="edit-kelas_siswa"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kelas</label>
                        <select id="edit-kelas_siswa" name="kelas_siswa" required
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
                        <label for="edit-nohp_siswa"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">No HP</label>
                        <input type="text" id="edit-nohp_siswa" name="nohp_siswa" required minlength="10"
                            maxlength="12" pattern="0[0-9]{9,11}"
                            title="No HP harus dimulai dengan angka 0 dan terdiri dari 10–12 digit"
                            oninput="this.setCustomValidity(''); if (!this.checkValidity()) this.setCustomValidity(this.title);"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    </div>

                    <!-- Pindahkan tombol simpan ke sini -->
                    <div>
                        <button type="submit"
                            class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            Simpan Perubahan
                        </button>
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
                </button>
                </form>
            </div>
        </div>
    </div>
</div>
