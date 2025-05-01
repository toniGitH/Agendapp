@extends('layouts.guest')

@section('title', 'Access to Agendapp')

@section('content')

    {{-- For xs, sm and md bootstrap5 screens --}}
    <div class="d-flex d-lg-none flex-column justify-content-center align-items-center mt-5 mb-5 text-white text-center">
        <img src="{{ asset('images/agendapp.png') }}" alt="AgendApp Logo" class="logo me-1 mb-4" style="max-height: 200px;">
        <h1 class="logo-color">Welcome to the Agendapp</h1>

    </div>

    {{-- For lg and upper bootstrap5 screens --}}
    <div class="d-none d-lg-flex justify-content-center align-items-center mb-5">
        <img src="{{ asset('images/agendapp.png') }}" alt="AgendApp Logo" class="logo me-1" style="max-height: 45px;">
        <span class="fs-1 fw-bold d-none d-lg-block text-center mx-3 logo-color">Welcome to the Agendapp</span>
        <img src="{{ asset('images/agendapp.png') }}" alt="AgendApp Logo" class="logo me-1" style="max-height: 45px;">
    </div>

    {{-- Div that contains the login and registration forms --}}
    <div class="row justify-content-center">

            {{-- Login Card --}}
            <div class="col-9 col-sm-11 col-md-11 col-lg-6">
                <div class="card home-card p-2 mb-0 mb-md-5">
                    <div class="card-header home-card-header text-center bg-primary">
                        <span class="fs-5 fw-bold text-white">Login</span>
                    </div>
                    <div class="card-body p-1 mt-2 mt-md-3">
                        {{-- Login form --}}
                        <form action="{{ route('login') }}" method="POST" novalidate>
                            @csrf
                            {{-- Input username --}}
                            <div class="mb-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <label for="loginUsernameId" class="form-label mb-0">Username:</label>
                                    @error('loginUsername', 'login')
                                        <span class="ms-2 error-form">{{ $message }}</span>
                                    @enderror
                                </div>
                                <input type="text" name="loginUsername" id="loginUsernameId" class="form-control form-control-sm @error('loginUsername', 'login') is-invalid @enderror" value="{{ old('loginUsername', '', 'login') }}" required placeholder="Remember that your username has been registered in lowercase">
                            </div>
                            {{-- Input password --}}
                            <div class="mb-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <label for="loginPasswordId" class="form-label mb-0">Password:</label>
                                    @error('loginPassword', 'login')
                                        <span class="ms-2 error-form">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="input-group">
                                    <input type="password" name="loginPassword" id="loginPasswordId" class="form-control form-control-sm @error('loginPassword', 'login') is-invalid @enderror" required>
                                    <button type="button" class="input-group-text primary-color" id="togglePassword3" data-target="loginPasswordId">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            {{-- Input remember me --}}
                            <div class="mt-3 mb-3 form-check">
                                <input type="checkbox" name="remember" id="rememberId" class="form-check-input">
                                <label for="rememberId" class="form-check ps-0">Remember me</label>
                            </div>
                            {{-- Submit button --}}
                            <button type="submit" class="btn btn-primary mt-2">
                                <i class="fa-solid fa-right-to-bracket mx-1"></i>
                                Login
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Small screens forms separator --}}
            <div class="col-9 col-sm-11 col-md-11 col-lg-6 my-3 d-lg-none text-center">
                <span class="fs-2 fw-bold text-white">- or -</span>
            </div>

            {{-- Register Card --}}
            <div class="col-9 col-sm-11 col-md-11 col-lg-6">
                <div class="card home-card p-2">
                    <div class="card-header home-card-header text-center bg-success">
                        <span class="fs-5 fw-bold text-white">Register</span>
                    </div>
                    <div class="card-body p-1 mt-3">
                        {{-- Register form --}}
                        <form action="{{ route('register') }}" method="POST" novalidate>
                            @csrf
                            {{-- Input name --}}
                            <div class="mb-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <label for="nameId" class="form-label mb-0">Name:</label>
                                    @error('name', 'register')
                                        <span class="ms-2 error-form">{{ $message }}</span>
                                    @enderror
                                </div>
                                <input type="text" name="name" id="nameId" class="form-control form-control-sm @error('name', 'register') is-invalid @enderror" value="{{ old('name', '', 'register') }}" required placeholder="Write here your real name (whith or without surname)">
                            </div>
                            {{-- Input username --}}
                            <div class="mb-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <label for="usernameRegisterId" class="form-label mb-0">Username:</label>
                                    @error('registerUsername', 'register')
                                        <span class="ms-2 error-form">{{ $message }}</span>
                                    @enderror
                                </div>
                                <input type="text" name="registerUsername" id="usernameRegisterId" class="form-control form-control-sm @error('registerUsername', 'register') is-invalid @enderror" value="{{ old('registerUsername', '', 'register') }}" required placeholder="Your username will always be registered in lowercase. Max 9 characters">
                            </div>
                            {{-- Input password --}}
                            <div class="mb-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <label for="registerPasswordId" class="form-label mb-0">Password:</label>
                                    @error('registerPassword', 'register')
                                        <span class="ms-2 error-form">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="input-group">
                                    <input type="password" name="registerPassword" id="registerPasswordId" class="form-control form-control-sm @error('registerPassword', 'register') is-invalid @enderror" required placeholder="Minimum 5 characters">
                                    <button type="button" class="input-group-text success-color" id="togglePassword1" data-target="registerPasswordId">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            {{-- Input password confirmation --}}
                            <div class="mb-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <label for="password_confirmation_id" class="form-label mb-0">Confirm Password:</label>
                                    @error('registerPassword_confirmation', 'register')
                                        <span class="ms-2 error-form">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="input-group">
                                    <input type="password" name="registerPassword_confirmation" id="password_confirmation_id" class="form-control form-control-sm @error('registerPassword_confirmation', 'register') is-invalid @enderror" required>
                                    <button type="button" class="input-group-text success-color" id="togglePassword2" data-target="password_confirmation_id">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </div>
                                
                            </div>
                            {{-- Submit button --}}
                            <button type="submit" class="btn btn-success mt-2">
                                <i class="fa-solid fa-address-card mx-1"></i>
                                Register
                            </button>
                        </form>
                    </div>
                </div>
            </div>
    </div>

@endsection

@push('styles')
    <!-- Access view custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/guest/access.css') }}">
    <!-- Access SweetAlert custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/sweetalert/globalsweetalert.css') }}">
@endpush

@push('scripts')
    <!-- Welcome and Access view custom JS -->
    <script>
        var successMessage = @json(session('success'));
        var errorMessages = @json($errors->login->all());
    </script>
    <script src="{{ asset('js/guest/auth.js') }}"></script>
@endpush