<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-30 w-64 h-full pt-20 transition-transform -translate-x-full bg-white shadow-md sm:translate-x-0 dark:bg-gray-900"
    aria-label="Sidebar">
    <div class="h-full px-4 pb-4 overflow-y-auto">
        <div class="mb-6">
            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3 dark:text-gray-400">Menu Utama</h3>
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('petugas.beranda') }}"
                        class="flex items-center px-4 py-2.5 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-100 hover:text-blue-700 transition-colors duration-200 dark:text-gray-300 dark:hover:bg-gray-800">
                        <i class="fas fa-home w-4 h-4 mr-3"></i>
                        Beranda
                    </a>
                </li>
                <li>
                    <a href="{{ route('petugas.koleksibuku') }}"
                        class="flex items-center px-4 py-2.5 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-100 hover:text-blue-700 transition-colors duration-200 dark:text-gray-300 dark:hover:bg-gray-800">
                        <i class="fas fa-book w-4 h-4 mr-3"></i>
                        Koleksi Buku
                    </a>
                </li>
            </ul>
        </div>
        
        <div class="mb-6">
            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3 dark:text-gray-400">Manajemen Data</h3>
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('petugas.datasiswa') }}"
                        class="flex items-center px-4 py-2.5 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-100 hover:text-blue-700 transition-colors duration-200 dark:text-gray-300 dark:hover:bg-gray-800">
                        <i class="fas fa-user w-4 h-4 mr-3"></i>
                        Data Siswa
                    </a>
                </li>
                <li>
                    <a href="{{ route('petugas.datapetugas') }}"
                        class="flex items-center px-4 py-2.5 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-100 hover:text-blue-700 transition-colors duration-200 dark:text-gray-300 dark:hover:bg-gray-800">
                        <i class="fas fa-user-tie w-4 h-4 mr-3"></i>
                        Data Petugas
                    </a>
                </li>
                <li>
                    <a href="{{ route('petugas.databuku') }}"
                        class="flex items-center px-4 py-2.5 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-100 hover:text-blue-700 transition-colors duration-200 dark:text-gray-300 dark:hover:bg-gray-800">
                        <i class="fas fa-book w-4 h-4 mr-3"></i>
                        Data Buku
                    </a>
                </li>
                <li>
                    <a href="{{ route('petugas.datapeminjaman') }}"
                        class="flex items-center px-4 py-2.5 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-100 hover:text-blue-700 transition-colors duration-200 dark:text-gray-300 dark:hover:bg-gray-800">
                        <i class="fas fa-exchange-alt w-4 h-4 mr-3"></i>
                        Data Peminjaman
                    </a>
                </li>
            </ul>
        </div>
        
        <div>
            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3 dark:text-gray-400">Aktivitas</h3>
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('petugas.riwayat') }}"
                        class="flex items-center px-4 py-2.5 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-100 hover:text-blue-700 transition-colors duration-200 dark:text-gray-300 dark:hover:bg-gray-800">
                        <i class="fas fa-history w-4 h-4 mr-3"></i>
                        Riwayat Aktivitas
                    </a>
                </li>
            </ul>
        </div>
    </div>
</aside>
<div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden sm:hidden"></div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const sidebar = document.getElementById("logo-sidebar");
        const toggleBtn = document.querySelector("[data-drawer-toggle='logo-sidebar']");
        const overlay = document.getElementById("sidebar-overlay");

        toggleBtn.addEventListener("click", () => {
            sidebar.classList.toggle("-translate-x-full");
            overlay.classList.toggle("hidden");
        });

        overlay.addEventListener("click", () => {
            sidebar.classList.add("-translate-x-full");
            overlay.classList.add("hidden");
        });
    });
</script>
