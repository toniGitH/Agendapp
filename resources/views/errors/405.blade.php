@extends('layouts.guest')

@section('title', 'Not allowed')

@section('content')

    <div class="d-flex flex-column justify-content-center align-items-center">
        {{-- Image --}}
            <img src="{{ asset('images/not_allowed.svg') }}" alt="405 Not allowed action">
        {{-- Main text --}}
            <p class="text-center responsive-text">This action is not allowed</p>
        {{-- Back button --}}
            <div class="back-button">
                <a href="{{ route('access') }}" class="btn w-auto">
                    <i class="fa-solid fa-rotate-left mx-1"></i>
                    <span>Back</span>
                </a>
            </div>
    </div>
    

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/errors/4xx.css') }}">
@endpush