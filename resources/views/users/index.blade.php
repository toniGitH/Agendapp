@extends('layouts.app')

@section('title', 'User list')

@section('content')

    <!-- Title -->
        <div class="d-flex justify-content-center align-items-baseline page-title">
            <i class="fa-solid fa-book fa-2xl" style="color: #212529"></i>
            <h1>Users list</h1>
            <i class="fa-solid fa-address-card fa-2xl"></i>
        </div>

    <!-- Search bar -->
    <x-user-search-bar-component :search="request()->input('search')" />
    
    <!-- Users list -->
        <div class="users-container">
            <div class="pagination-wrapper">
                <!-- Left arrow (Previous) -->
                    <div class="pagination-box left">
                        @if ($users->previousPageUrl())
                            <a href="{{ $users->previousPageUrl() . '&search=' . request('search') . '&admin_filter=' . request('admin_filter') . '&user_filter=' . request('user_filter') }}" 
                            class="pagination-arrow">
                                <i class="fa-solid fa-circle-chevron-left fa-2xl"></i>
                            </a>
                        @endif
                    </div>
                <!-- User table component -->
                    <div class="pagination-box center">
                        <x-user-table-component :users="$users" />
                    </div>
                <!-- Right arrow (Next) -->
                    <div class="pagination-box right">
                        @if ($users->nextPageUrl())
                            <a href="{{ $users->nextPageUrl() . '&search=' . request('search') . '&admin_filter=' . request('admin_filter') . '&user_filter=' . request('user_filter') }}" 
                            class="pagination-arrow">
                                <i class="fa-solid fa-circle-chevron-right fa-2xl"></i>
                            </a>
                        @endif
                    </div>
            </div>
        </div>

    <!-- Pagination links -->
        <div class="d-flex justify-content-center mt-5 mt-lg-1">
            {{ $users->appends(request()->query())->links('vendor.pagination.simple-numbers') }}
        </div>

@endsection

@push('styles')
<!-- Index view custom CSS -->
<link rel="stylesheet" href="{{ asset('css/app/index.css') }}">
@endpush

@push('scripts')

@endpush
