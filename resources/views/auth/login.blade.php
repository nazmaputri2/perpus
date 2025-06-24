@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<section class="vh-100 gradient-custom">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card text-black">
                    <div class="card-body p-5 text-center">
                        @if($errors->any())
                            <div class="alert alert-danger mb-4">
                                @foreach($errors->all() as $error)
                                    {{ $error }}
                                @endforeach
                            </div>
                        @endif

                        @if(session('status'))
                            <div class="alert alert-success mb-4">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="mb-4">
                            <img src="{{ asset('images/sdit.jpg') }}" alt="Logo" class="mb-4 img-fluid" style="max-width: 200px;">
                            <form method="POST" action="{{ route('auth.login') }}">
                                @csrf

                                <div data-mdb-input-init class="form-outline form-black mb-4">
                                    <input type="text" class="form-control form-control-lg" name="username"
                                        id="username" placeholder="Username" required value="{{ old('username') }}" />
                                    <label class="form-label" for="username">
                                        <i class='bx bx-user'></i> Masukkan nama pengguna anda
                                    </label>
                                </div>

                                <div data-mdb-input-init class="form-outline form-black mb-4">
                                    <input type="password" class="form-control form-control-lg" name="password"
                                        id="password" placeholder="Password" required />
                                    <label class="form-label" for="password">
                                        <i class='bx bx-lock-alt'></i> Masukkan kata sandi anda
                                    </label>
                                    <span class="toggle-password" onclick="togglePassword()">
                                        <i class="fas fa-eye" id="toggleIcon"></i>
                                    </span>
                                </div>

                                <button class="btn btn-primary btn-lg px-5" type="submit">Masuk</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('toggleIcon');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        }
    }
</script>
@endpush
@endsection