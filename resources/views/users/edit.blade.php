@extends('layouts.app')

@section('title', 'Edit user profile')

@section('content')

<div class="container">

    {{-- Title --}}
        <div class="d-flex justify-content-center align-items-baseline page-title mb-lg-3">
            <i class="fa-solid fa-pen-to-square fa-2xl" style="color: #212529"></i>
            <h1>Edit user</h1>
            <i class="fa-solid fa-user fa-2xl"></i>
        </div>

    {{-- Edit form --}}
        @can('update', $user)
            <form action="{{ route('users.update', $user) }}" method="POST" enctype="multipart/form-data">
                    
                {{-- csrf token --}}
                    @csrf

                {{-- method --}}
                    @method('PUT')

                {{--Inputs name, username & password --}}
                    <div class="row">
                        {{-- input name --}}
                            <div class="col-12 col-lg-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <label for="name" class="form-label mb-0 ms-1">Name:</label>
                                        @error('name')
                                            <span class="ms-2 error-form">{{ $message }}</span>
                                        @enderror
                                </div>
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror mb-3" value="{{ old('name', $user->name) }}">
                            </div>

                        {{-- input username --}}
                            <div class="col-12 col-lg-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <label for="username" class="form-label mb-0 ms-1">Username:</label>
                                        @error('username')
                                            <span class="ms-2 error-form">{{ $message }}</span>
                                        @enderror
                                </div>
                                <input type="text" name="username" id="username" class="form-control @error('username') is-invalid @enderror mb-3" value="{{ old('username', $user->username) }}">
                            </div>

                        {{-- input password --}}
                            <div class="col-12 col-lg-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <label for="password" class="form-label mb-0 ms-1">New password:</label>
                                        @error('password')
                                            <span class="ms-2 error-form">{{ $message }}</span>
                                        @enderror
                                </div>
                                <input type="text" name="password" id="password" class="form-control @error('password') is-invalid @enderror mb-3" placeholder="Leave empty to keep current password">
                            </div>
                    </div>

                {{--Inputs image, role select & transfer contacts --}}
                    <div class="row">
                        {{-- input image --}}
                            <div class="mb-3 col-12 col-lg-4 mb-0">
                                {{-- user profile photo: inputs and photo preview --}}
                                    <div class="col-12 d-flex flex-column flex-lg-row justify-content-lg-between">
                                        {{-- user profile photo file inputs: upload and delete --}}
                                            <div class="col-12 col-lg-9">
                                                {{-- upload photo input (customized) --}}
                                                    <div class="col-12 col-lg-11">
                                                        <label for="image" class="form-label mb-1">Profile photo:</label>
                                                        @error('image')
                                                            <span class="ms-2 error-form">{{ $message }}</span>
                                                        @enderror
                                                        <div class="d-flex align-items-center bg-white rounded">
                                                            <!-- custom button -->
                                                                <div class="d-flex align-items-center fileButton rounded-start" onclick="document.getElementById('image').click();">
                                                                    <i class="fa-solid fa-folder-open p-2" style="color:white"></i>
                                                                </div>
                                                                <!-- hidden input file -->
                                                                <input type="hidden" name="current_image" value="{{ $user->profile_img }}">
                                                                <input type="file" name="image" id="image" class="d-none" accept="image/*" onchange="updateFileName()">
                                                                <!-- input text that shows file name -->
                                                                <input type="text" id="file-name" class="form-control form-control-sm ms-2 @error('image') is-invalid @enderror" placeholder="No file selected" readonly>
                                                        </div>
                                                    </div>
                                                {{-- separator --}}
                                                    <div class="col-12 col-lg-11 mb-1 mt-1">
                                                        <span>or</span>
                                                    </div> 
                                                {{-- delete photo checkbox --}}
                                                    <div class="col-12 col-lg-11 form-check mt-2 mt-lg-0 mb-3 mb-md-0">
                                                        <input type="checkbox" class="form-check-input" id="delete_image" name="delete_image">
                                                        <label class="form-check-label" for="delete_image">Remove current photo</label>
                                                    </div>
                                            </div>
                                        {{-- contact photo preview --}}
                                            <div class="col-12 col-lg-3 d-flex flex-column user-img-prev align-self-center align-self-lg-start mt-1 mt-md-2 mt-lg-0">
                                                <div class="d-flex flex-column flex-grow-1">
                                                    <span class="form-label d-none d-lg-inline-block mb-lg-1 label-preview">Preview:</span>
                                                    <div class="d-flex flex-grow-1">
                                                        <div id="imagePreviewContainer" class="w-100 d-flex align-items-stretch flex-grow-1">
                                                            @if($user->profile_img)
                                                                <img src="{{ asset('storage/' . $user->profile_img) }}" alt="User profile image" 
                                                                    class="img-thumbnail w-100 flex-grow-1" 
                                                                    style="object-fit: cover; min-height: 100px;">
                                                            @else
                                                                <img src="{{ asset('images/profile1.png') }}" alt="Default profile image" 
                                                                    class="img-thumbnail w-100 flex-grow-1" 
                                                                    style="object-fit: cover; min-height: 100px;">
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                            </div>

                        {{-- role select --}}
                            @can('assignRole', $user)
                                <div class="mb-3 col-12 col-lg-4">
                                    <label for="is_admin" class="form-label mb-0">Role</label>
                                    <select name="is_admin" id="is_admin" class="form-select @error('is_admin') is-invalid @enderror">
                                        <option value="0" {{ $user->is_admin == 0 ? 'selected' : '' }}>User</option>
                                        <option value="1" {{ $user->is_admin == 1 ? 'selected' : '' }}>Administrator</option>
                                    </select>
                                    @error('is_admin')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endcan
                            
                        {{-- transfer contacts select (hidden for future uses) --}}
                            @can('transferAllContacts', $user)
                                @if($user->contacts->isNotEmpty())
                                    <div class="d-none mb-3 col-12 col-lg-4">
                                        <label for="new_owner" class="form-label mb-0">Transfer all contacts to:</label>
                                        <select name="new_owner" id="new_owner" class="form-select @error('new_owner') is-invalid @enderror">
                                            <option value="">-- Select a user --</option>
                                            @foreach($users as $otherUser)
                                                @if($otherUser->id !== $user->id)
                                                    <option value="{{ $otherUser->id }}" {{ old('new_owner') == $otherUser->id ? 'selected' : '' }}>
                                                        {{ $otherUser->username }} ({{ $otherUser->name }})
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('new_owner')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endif
                            @endcan
                    </div>

                {{-- submit button --}}
                    <div class="d-flex justify-content-center justify-content-lg-start">
                        <button type="submit" class="btn btn-primary update-contact mt-2">
                            <i class="fa-solid fa-thumbs-up fa-lg mx-2"></i>
                            Update User
                        </button>
                    </div>
            </form>
        @endcan
    
    {{-- Nav buttons --}}
        <div class="row justify-content-end mt-5 mt-lg-1 mb-5 mb-lg-1">
            {{-- Back to user list --}}
                <div class="col-12 col-lg-3 d-flex justify-content-end mt-3">
                    @can('viewAny', App\Models\User::class) <!-- This validates if the user has permission to access to users list -->
                        <a href="{{ route('users.index', request()->query()) }}" class="btn btn-secondary back-to-list w-100">
                            <i class="fa-solid fa-rotate-left mx-1"></i>
                            <span>Back to user list</span>
                        </a>
                    @endcan
                </div>
            {{-- Back to user profile --}}
                <div class="col-12 col-lg-3 d-flex justify-content-end mt-3">
                    @can('profile', $user)
                        <a href="{{ route('users.profile', array_merge(['user' => $user->id], request()->query())) }}" class="btn btn-secondary back-to-list w-100">
                            <i class="fa-solid fa-rotate-left mx-1"></i>
                            <span>Back to user profile</span>
                        </a>
                    @endcan
                </div>
        </div>

    </div>


@endsection

@push('scripts')
    <script src="{{ asset('js/app/edit.js') }}"></script>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/app/edit.css') }}">
@endpush