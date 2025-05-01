@extends('layouts.app')

@section('title', 'Contact list')

@section('content')

    <!-- Title -->
        <div class="d-flex justify-content-center align-items-baseline page-title">
            <i class="fa-solid fa-book fa-2xl" style="color: #212529"></i>
            <h1>Contact list</h1>
            <i class="fa-solid fa-address-card fa-2xl"></i>
        </div>

    <!-- Search bar (collapsible) -->
        <div class="row">
            <div class="col text-start search-bar mt-1" id="searchBar">
                <x-contact-search-bar-component />
            </div>
        </div>

    <!-- Contact table component -->
        <div class="row">
            <div class="col text-start">
                <x-contact-table-component :contacts="$contacts" :sort="$sort" :direction="$direction" />
            </div>
        </div>

    <!-- Pagination links -->
        <div class="d-flex justify-content-center">
            {{ $contacts->links() }}
        </div>

@endsection

@push('styles')
<!-- Index view custom CSS -->
<link rel="stylesheet" href="{{ asset('css/app/index.css') }}">
<!-- Index SweetAlert custom CSS -->
<link rel="stylesheet" href="{{ asset('css/sweetalert/globalsweetalert.css') }}">
@endpush

@push('scripts')
<!-- Home view custom JS -->
<script src="{{ asset('js/app/index.js') }}"></script>
@endpush