<!-- NAVBAR -->
<nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start rtl:justify-end">
                <a href="{{ route('siswa.beranda') }}" class="flex ms-2 md:me-24">
                    <img src="{{ asset('images/logopbl.png') }}" class="h-8 me-3" alt="" />
                    <span
                        class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap dark:text-black">PUSTAKALAYA</span>
                </a>
            </div>
            <div class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
                <button type="button"
                    class="flex text-sm bg-gray-800 rounded-full md:me-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                    id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown"
                    data-dropdown-placement="bottom">
                    <span class="sr-only">Open user menu</span>
                    <div class="relative w-8 h-8 overflow-hidden bg-gray-100 rounded-full dark:bg-gray-600">
                        <svg class="absolute w-10 h-10 text-gray-400 -left-1" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>

                </button>

                <!-- Dropdown menu -->
                <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600"
                    id="user-dropdown">
                    <div class="px-4 py-3">
                        <span class="block text-sm text-gray-900 dark:text-white">Nama Pengguna</span>
                    </div>
                   <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="user-menu-button">
    <li>
        <a href="{{ route('siswa.profile') }}"
           class="block px-4 py-2 hover:bg-blue-100 dark:hover:bg-gray-600 dark:hover:text-white">
            <i class="fa-solid fa-user mr-2"></i>
            Profil
        </a>
    </li>
                        <li>
                            <a href="#"
                                class="block px-4 py-2 hover:bg-blue-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                <i class="fas fa-exchange mr-2"></i>
                                Peminjaman
                            </a>
                        </li>
                               <li>
            <a href="#" class="flex items-center px-4 py-2 hover:bg-blue-100 dark:hover:bg-gray-600 dark:hover:text-white" data-modal-target="ubah-password-modal" data-modal-toggle="ubah-password-modal">
                <i class="fa fa-lock mr-3 w-4 text-center text-black dark:text-gray-300"></i>
                Ubah Sandi
            </a>
        </li>
                    </ul>
                    <div class="py-2">
                        <a href="#"
                            class="block px-4 py-2 text-sm text-red-700 hover:bg-red-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white"
                            data-modal-target="popup-modal" data-modal-toggle="popup-modal">
                            <i class="fa-solid fa-right-from-bracket mr-2"></i>
                            Keluar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>