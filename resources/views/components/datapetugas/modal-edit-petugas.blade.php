<div id="editDataModal" tabindex="-1" aria-hidden="true"
    class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Ubah Data Petugas</h3>
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
                        <label for="edit-nip"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIP</label>
                        <input type="text" id="edit-nip" name="nip" readonly
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                    </div>
                    <div>
                        <label for="edit-nama" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama
                            Petugas</label>
                        <input type="text" id="edit-nama" name="nama" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                    </div>
                    <div>
                        <label for="edit-nohp" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">No
                            HP</label>
                        <input type="text" id="edit-nohp" name="nohp" required minlength="10" maxlength="12"
                            pattern="0[0-9]{9,11}"
                            title="No HP harus dimulai dengan angka 0 dan terdiri dari 10–12 digit"
                            oninput="this.setCustomValidity(''); if (!this.checkValidity()) this.setCustomValidity(this.title);"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                    </div>
                    <div>
                        <label for="edit-alamat"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Alamat</label>
                        <textarea id="edit-alamat" name="alamat" rows="3"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"></textarea>
                    </div>
                    <button type="submit"
                        class="w-full text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        Simpan Perubahan
                    </button>
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
