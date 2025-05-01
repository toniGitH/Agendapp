@extends('layouts.guest')

@section('title', 'Welcome to Agendapp')

@section('content')

    {{-- Welcome view for xs and sm Bootstrap5 screens --}}
    <div class="d-flex d-md-none flex-column justify-content-center align-items-center text-center text-white">
        <img class="appIcon" src="{{ asset('images/agendapp.png') }}">
        <div class="access-button mt-5 mb-2">
            <a href="{{ route('access') }}" class="btn">
                Access to the Agendapp 
            </a>
        </div>
        <div>
            <span class="register-advice p-2">You must be registered to use the Agendapp</span>
        </div>

    </div>

    {{-- Welcome view for lager than md Bootstrap5 screens --}}
    <div class="d-none d-md-flex flex-column justify-content-center align-items-center text-center text-white">
        <img class="appIcon" src="{{ asset('images/agendapp.png') }}">
        <div class="access-button mt-5 mb-2 mb-md-4">
            <a href="{{ route('access') }}" class="btn">
                Access to the Agendapp 
            </a>
        </div>
        <div>
            <span class="register-advice p-2">You must be registered to use the Agendapp</span>
        </div>
    </div>
    
@endsection

@push('styles')
    <!-- Welcome view custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/guest/welcome.css') }}">
@endpush

@push('scripts')
    <!-- Welcome and Access view custom JS -->
    <script>
        var successMessage = @json(session('success'));
        var errorMessages = @json($errors->login->all());
    </script>
    <script src="{{ asset('js/guest/auth.js') }}"></script>
@endpush