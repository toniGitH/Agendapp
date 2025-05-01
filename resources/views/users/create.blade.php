@extends('layouts.app')

@section('title', 'Create new user')

@section('content')

    {{-- Page title --}}
        <div class="d-flex justify-content-center align-items-baseline page-title">
            <i class="fa-solid fa-square-plus fa-2xl" style="color: #212529"></i>
            <h1>Add user</h1>
            <i class="fa-solid fa-user fa-2xl"></i>
        </div>

    {{-- Create user form --}}
        <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data"  class="mt-3" novalidate>
            
            {{-- CSRF token --}}
                @csrf

            {{-- Inputs --}}
                <div class="d-flex justify-content-evenly">
                    <div class="row container gap-2 gap-lg-4">
                        {{-- Inputs: Name, Username & Password --}}
                            <div class="col-12 col-lg-5 d-flex flex-column">
                                {{-- Input Name --}}
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="mb-2"> 
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <label for="name_id" class="form-label mb-0">Name:</label>
                                                    @error('name')
                                                        <span class="ms-2 error-form">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <input type="text" name="name" id="name_id" class="form-control form-control-sm @error('name') is-invalid @enderror" value="{{ old('name') }}" maxlength="255" required>
                                            </div>
                                        </div>
                                    </div>
                                {{-- Input Username --}}
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="mb-2"> 
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <label for="username_id" class="form-label mb-0">Username:</label>
                                                    @error('username')
                                                        <span class="ms-2 error-form">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <input type="text" name="username" id="username_id" class="form-control form-control-sm @error('username') is-invalid @enderror" value="{{ old('username') }}" maxlength="255" required placeholder="Username will always be registered in lowercase. Max 9 characters">
                                            </div>
                                        </div>
                                    </div>
                                {{-- Input Password --}}
                                    <div class="row">
                                        <div class="col-12">
                                            
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <label for="password_id" class="form-label mb-0">Password:</label>
                                                    @error('password')
                                                        <span class="ms-2 error-form">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <input type="text" name="password" id="password_id" class="form-control form-control-sm @error('password') is-invalid @enderror" required placeholder="Minimum 5 characters">
                                            </div>
                                    </div>
                            </div>
                        {{-- Inputs: Image & Role --}}
                        <div class="col-12 col-lg-6 d-flex flex-column">
                            {{-- Input Image --}}
                                    <div class="col-12 d-flex flex-column flex-lg-row justify-content-lg-between">
                                        {{-- user photo file input (customized) --}}
                                            <div class="col-12 col-lg-9 mb-2">
                                                <div class="col-12 col-lg-11">
                                                    <label for="image" class="form-label mb-1">Profile image:</label>
                                                    @error('image')
                                                        <span class="ms-2 error-form">{{ $message }}</span>
                                                    @enderror
                                                    <div class="d-flex align-items-center bg-white rounded">
                                                        <!-- Custom button -->
                                                        <div class="d-flex align-items-center fileButton rounded-start" onclick="document.getElementById('image').click();">
                                                            <i class="fa-solid fa-folder-open p-2" style="color:white"></i>
                                                        </div>
                                                        <!-- Hidden input file -->
                                                        <input type="file" name="image" id="image" class="d-none" accept="image/*" onchange="updateFileName()">
                                                        <!-- Input text that shows file name -->
                                                        <input type="text" id="file-name" class="form-control form-control-sm ms-2 @error('image') is-invalid @enderror" placeholder="No file selected" readonly>
                                                    </div>
                                                </div>                            
                                            </div>
                                        {{-- user photo preview --}}
                                            <div class="col-12 col-lg-3 d-flex flex-column user-img-prev align-self-center align-self-lg-start mt-1 mt-md-2 mt-lg-0">
                                                <div class="d-flex flex-column flex-grow-1">
                                                    <span class="form-label m-0 d-none d-md-inline-block">Preview:</span>
                                                    <div class="d-flex flex-grow-1">
                                                        <div id="imagePreviewContainer" class="w-100 d-flex align-items-stretch flex-grow-1">
                                                            <!-- Default image -->
                                                            <img src="{{ asset('images/profile1.png') }}" id="previewImage" alt="User profile image"
                                                            class="img-thumbnail w-100 flex-grow-1"
                                                            style="object-fit: cover; min-height: 100px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                            {{-- Admin/User role (radio buttons) --}}
                                <div class="mt-3 mt-lg-0 mb-5 mb-lg-3 role-checkbox">
                                    <label class="form-label me-3">Set user as admin:</label>                                 
                                    {{-- Radio buttons --}}
                                        <div class="radio-buttons-container">
                                            {{-- Set user as Admin --}}
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input @error('is_admin') is-invalid @enderror" type="radio" name="is_admin" id="is_admin_yes" value="1" 
                                                        {{ old('is_admin') == '1' ? 'checked' : '' }} required>
                                                    <label class="form-check-label" for="is_admin_yes">Yes</label>
                                                </div>
                                            {{-- Set user as no Admin --}}
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input @error('is_admin') is-invalid @enderror" type="radio" name="is_admin" id="is_admin_no" value="0" 
                                                        {{ old('is_admin') == '0' ? 'checked' : '' }} required>
                                                    <label class="form-check-label" for="is_admin_no">No</label>
                                                </div>
                                                @error('is_admin')
                                                    <span class="ms-2 error-form align-self-center">{{ $message }}</span>
                                                @enderror
                                        </div>
                                </div>
                        </div>
                    </div>
                </div>

            {{-- Submit Button --}}
                <div class="container d-flex justify-content-center mt-2">
                    <div class="row ">
                        <button type="submit" class="btn btn-primary add-user">
                            <i class="fa-solid fa-user-plus fa-flip-horizontal mx-1"></i>
                            Save User
                        </button>
                    </div>
                </div>
        </form>

    {{-- Back to users button --}}
        <div class="container d-flex justify-content-center mt-4 mt-lg-5">
            <a href="{{ route('users.index', request()->query()) }}" class="btn btn-secondary back-to-list">
                <i class="fa-solid fa-rotate-left mx-1"></i>
                <span>Back to users list</span>
            </a>
        </div>
            

@endsection

@push('scripts')
    <script src="{{ asset('js/app/create.js') }}"></script>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/app/create.css') }}">
@endpush