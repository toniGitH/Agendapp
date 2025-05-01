@extends('layouts.guest')

@section('title', 'Page not found')

@section('content')

    <div class="d-flex flex-column justify-content-center align-items-center">
        {{-- Image --}}
            <img src="{{ asset('images/not_found.svg') }}" alt="403 Page not found">
        {{-- Main text --}}
            <p class="text-center responsive-text">This page doesn't exist in this site</p>
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