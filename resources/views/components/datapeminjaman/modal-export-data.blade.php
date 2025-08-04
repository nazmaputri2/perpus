<div id="exportPeminjamanModal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-lg max-h-full">
        <div class="relative bg-white rounded-2xl shadow-2xl">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                <h3 class="text-xl font-semibold text-gray-900">
                    Export Data Peminjaman
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                    data-modal-hide="exportPeminjamanModal">
                    <i class="fas fa-times"></i>
                    <span class="sr-only">Tutup modal</span>
                </button>
            </div>

            <form action="{{ route('peminjaman.export') }}" method="GET" class="p-4 md:p-5">
                <div class="mb-4">
                    <label for="bulan" class="block mb-2 text-base font-medium text-gray-900">Pilih Bulan</label>
                    <select name="bulan" id="bulan"
                        class="block w-full p-2.5 border border-gray-300 text-sm rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Semua Bulan</option>
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}">{{ \Carbon\Carbon::create()->month($i)->locale('id')->monthName }}</option>
                        @endfor
                    </select>
                      <p id="keteranganBulan" class="mt-1 text-sm text-gray-500">Bulan yang dipilih: -</p>
                </div>

                <div class="mb-4">
                    <label for="status" class="block mb-2 text-base font-medium text-gray-900">Status Peminjaman</label>
                    <select name="status" id="status"
                        class="block w-full p-2.5 border border-gray-300 text-sm rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Semua Status</option>
                        <option value="dipinjam">Sedang Dipinjam</option>
                        <option value="dikembalikan">Sudah Dikembalikan</option>
                        <option value="terlambat">Terlambat</option>
                    </select>
                    <p id="keteranganStatus" class="mt-1 text-sm text-gray-500">Status yang dipilih: -</p>
                </div>

                <div class="flex items-center justify-end pt-4 border-t">
                    <button data-modal-hide="exportPeminjamanModal" type="button"
                        class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 me-3">
                        Batal
                    </button>
                    <button type="submit"
                        class="text-white bg-green-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        <i class="fas fa-download me-2"></i>Export Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const bulanSelect = document.getElementById('bulan');
        const statusSelect = document.getElementById('status');
        const keteranganBulan = document.getElementById('keteranganBulan');
        const keteranganStatus = document.getElementById('keteranganStatus');

        const bulanMap = {
            "1": "Januari", "2": "Februari", "3": "Maret", "4": "April",
            "5": "Mei", "6": "Juni", "7": "Juli", "8": "Agustus",
            "9": "September", "10": "Oktober", "11": "November", "12": "Desember"
        };

        const statusMap = {
            "dipinjam": "Sedang Dipinjam",
            "dikembalikan": "Sudah Dikembalikan",
            "terlambat": "Terlambat",
            "": "Semua Status"
        };

        bulanSelect.addEventListener('change', function () {
            const val = bulanSelect.value;
            keteranganBulan.textContent = `Bulan yang dipilih: ${val ? bulanMap[val] : '-'}`;
        });

        statusSelect.addEventListener('change', function () {
            const val = statusSelect.value;
            keteranganStatus.textContent = `Status yang dipilih: ${statusMap[val] || '-'}`;
        });
    });
</script>
