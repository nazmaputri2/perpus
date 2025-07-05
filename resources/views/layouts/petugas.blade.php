<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('tiitle', 'PUSTAKALAYA')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
    <link rel="icon" href="{{ asset('images/sdit.jpg') }}" type="image/jpg">

</head>

<body>
    @include('layouts.navbar')
    @include('layouts.sidebar')

    <div class="p-4 sm:ml-64 mt-16">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        @if (session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 3000
                });
            </script>
        @endif

        @if (session('error'))
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: '{{ session('error') }}',
                    showConfirmButton: false,
                    timer: 5000
                });
            </script>
        @endif

        {{-- Menampilkan pesan validasi spesifik di bawah input --}}
        @error('current_password', 'updatePassword')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror

        @error('new_password', 'updatePassword')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror

        @error('new_password_confirmation', 'updatePassword')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror

        @stack('toasts')
        @yield('content')
    </div>

    @stack('modals')

    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>



    @stack('scripts')

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>

    
</body>

</html>