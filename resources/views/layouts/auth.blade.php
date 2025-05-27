<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - PUSTAKALAYA</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/login.png') }}">

    <!-- External CSS Libraries -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />

    <!-- Bootstrap and MDB CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/8.0.0/mdb.min.css" rel="stylesheet" />

    <!-- Custom CSS -->
    <link href="{{ asset('css/index.css') }}" rel="stylesheet">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }

        .vh-100 {
            background-image: url('{{ asset('images/bg.jpg') }}');
            background-size: cover;
            background-position: center;
        }

        .card {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 5rem;
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }

        .form-outline {
            position: relative;
        }
    </style>

    @stack('styles')
</head>
<body>
    @yield('content')

    <!-- JavaScript Libraries -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/8.0.0/mdb.umd.min.js"></script>

    @stack('scripts')
</body>
</html>