<nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start rtl:justify-end">
                <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar"
                    aria-controls="logo-sidebar" type="button"
                    class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                    <span class="sr-only">Open sidebar</span>
                    <i class="fas fa-bars w-6 h-6"></i>
                </button>
                <a href="" class="flex ms-2 md:me-24">
                    <img src="{{ asset('images/sdit.jpg') }}" class="h-8 me-3" alt="" />
                    <span class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap dark:text-black">PUSTAKALAYA</span>
                </a>
            </div>
            <div class="flex items-center">
                <div class="flex items-center ms-3">
                    <div>
                       <button type="button" class="flex items-center justify-center w-8 h-8 text-gray-500 hover:text-gray-600 dark:text-gray-400 dark:hover:text-gray-300" aria-expanded="false" data-dropdown-toggle="dropdown-user">
    <span class="sr-only">Open menu</span>
    <i class="fas fa-ellipsis-v h-5 w-5"></i>
</button>

<!-- Dropdown menu - Enhanced Flowbite Style -->
<div id="dropdown-user" class="z-50 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700 dark:divide-gray-600">
    <div class="px-4 py-3 text-sm text-gray-900 dark:text-white">
        <div class="font-medium">
            @auth
                @if(auth()->user()->role === 'siswa' && auth()->user()->siswa)
                    {{ auth()->user()->siswa->nama_siswa }}
                @elseif(auth()->user()->role === 'petugas' && auth()->user()->petugas)
                    {{ auth()->user()->petugas->nama }}
                @else
                    {{ auth()->user()->username }} {{-- Fallback jika role lain atau data terkait tidak ditemukan --}}
                @endif
            @else
                Pengguna
            @endauth
        </div>
    </div>
    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdown-user">
        <li>
            <a href="#" class="flex items-center px-4 py-2 hover:bg-blue-100 dark:hover:bg-gray-600 dark:hover:text-white" data-modal-target="ubah-password-modal" data-modal-toggle="ubah-password-modal">
                <i class="fa fa-lock mr-3 w-4 text-center text-black dark:text-gray-300"></i>
                Ubah Sandi
            </a>
        </li>
        <li>
            <a href="#" class="flex items-center px-4 py-2 hover:bg-red-100 dark:hover:bg-gray-600 dark:hover:text-white" data-modal-target="popup-modal" data-modal-toggle="popup-modal">
                <i class="fa-solid fa-right-from-bracket mr-3 w-4 text-center text-red-800 dark:text-red-800"></i>
                Keluar
            </a>
        </li>
    </ul>
</div>                </div>
            </div>
        </div>
    </div>
</nav>