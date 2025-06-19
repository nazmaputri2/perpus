<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-0 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
    aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
        <ul class="space-y-2 font-medium">
            <li>
                <a href="{{ route('petugas.beranda') }}"
                    class="flex items-center p-2 text-black-900 rounded-lg dark:text-white hover:bg-blue-100 dark:hover:bg-black-700 group">
                    <i class="fas fa-home shrink-0 w-5 h-5 text-black-500 transition duration-75 dark:text-black-400 group-hover:text-black-900 dark:group-hover:text-white"></i>
                    <span class="ms-3">Beranda</span>
                </a>
            </li>
                        <li>
                <a href="#"
                    class="flex items-center p-2 text-black-900 rounded-lg dark:text-white hover:bg-blue-100 dark:hover:bg-black-700 group">
                    <i class="fas fa-book shrink-0 w-5 h-5 text-black-500 transition duration-75 dark:text-black-400 group-hover:text-black-900 dark:group-hover:text-white"></i>
                    <span class="flex-1 ms-3 whitespace-nowrap">Koleksi Buku</span>
                </a>
            </li>

            <li>
                <a href="{{ route('petugas.datasiswa') }}"
                    class="flex items-center p-2 text-black-900 rounded-lg dark:text-white hover:bg-blue-100 dark:hover:bg-black-700 group">
                    <i class="fas fa-user shrink-0 w-5 h-5 text-black-500 transition duration-75 dark:text-black-400 group-hover:text-black-900 dark:group-hover:text-white"></i>
                    <span class="flex-1 ms-3 whitespace-nowrap">Data Siswa</span>
                </a>
            </li>
             <li>
                <a href="{{ route('petugas.datapetugas') }}"
                    class="flex items-center p-2 text-black-900 rounded-lg dark:text-white hover:bg-blue-100 dark:hover:bg-black-700 group">
                    <i class="fas fa-user-tie shrink-0 w-5 h-5 text-black-500 transition duration-75 dark:text-black-400 group-hover:text-black-900 dark:group-hover:text-white"></i>
                    <span class="flex-1 ms-3 whitespace-nowrap">Data Petugas</span>
                </a>
            </li>
            <li>
                <a href="{{ route('petugas.databuku') }}"
                    class="flex items-center p-2 text-black-900 rounded-lg dark:text-white hover:bg-blue-100 dark:hover:bg-black-700 group">
                    <i class="fas fa-book shrink-0 w-5 h-5 text-black-500 transition duration-75 dark:text-black-400 group-hover:text-black-900 dark:group-hover:text-white"></i>
                    <span class="flex-1 ms-3 whitespace-nowrap">Data Buku</span>
                </a>
            </li>
            <li>
                <a href="#"
                    class="flex items-center p-2 text-black-900 rounded-lg dark:text-white hover:bg-blue-100 dark:hover:bg-black-700 group">
                    <i class="fas fa-exchange-alt shrink-0 w-5 h-5 text-black-500 transition duration-75 dark:text-black-400 group-hover:text-black-900 dark:group-hover:text-white"></i>
                    <span class="flex-1 ms-3 whitespace-nowrap">Data Peminjaman</span>
                </a>
            </li>
            <li>
                <a href="{{ route('petugas.riwayat') }}"
                    class="flex items-center p-2 text-black-900 rounded-lg dark:text-white hover:bg-blue-100 dark:hover:bg-black-700 group">
                    <i class="fas fa-history shrink-0 w-5 h-5 text-black-500 transition duration-75 dark:text-black-400 group-hover:text-black-900 dark:group-hover:text-white"></i>
                    <span class="flex-1 ms-3 whitespace-nowrap">Riwayat Aktivitas</span>
                </a>
            </li>
        </ul>
    </div>
</aside>