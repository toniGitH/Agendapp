@extends('layouts.app')

@section('title')
    {{$user->username}} profile
@endsection

@section('content')

<!-- Profile title -->
    <div class="d-flex justify-content-center align-items-baseline page-title">
        <i class="fa-solid fa-id-card fa-2xl" style="color: #212529"></i>
        <h1>{{$user->username}}'s&nbsp;&nbsp;profile</h1>
        <i class="fa-solid fa-id-card fa-2xl"></i>
    </div>

<!-- Profile body -->
    <div class="container">
        <div class="row gap-3">
            <!-- Image column --> 
                <div class="col-12 col-lg-3 d-flex flex-column justify-content-start align-items-center">
                    <!-- User image-->  
                        <div id="imagePreviewContainer" class="profile-img-container">
                            @if($user->profile_img)
                                <img src="{{ asset('storage/' . $user->profile_img) }}" alt="User profile image" class="profile-img">
                            @else
                                <img src="{{ asset('images/profile1.png') }}" alt="Default profile image" class="profile-img">
                            @endif
                        </div>
                    <!-- Nav buttons -->
                        <div class="container d-none d-lg-flex flex-column justify-content-center">
                            <!-- Back to edit user view --> 
                            <div class="d-flex justify-content-center mt-3">
                                @can('edit', $user)
                                    <a href="{{ route('users.edit', array_merge(['user' => $user->id], request()->query())) }}" class="btn btn-primary w-100 edit-user">
                                        <i class="fa-solid fa-pencil-alt mx-1"></i>
                                        <span>Edit user</span>
                                    </a>
                                @endcan
                            </div>
                            <!-- Back to user/contact list view -->
                                <div class="d-flex justify-content-center mt-3">
                                    @if (auth()->user()->is_admin)
                                        @can('viewAny', App\Models\User::class) <!-- This validates if the user has permission to access to user list -->
                                            <a href="{{ route('users.index', request()->query()) }}" class="btn btn-secondary back-to-list w-100">
                                                <i class="fa-solid fa-rotate-left mx-1"></i>
                                                <span>Back to user list</span>
                                            </a>
                                        @endcan
                                    @else
                                        @can('viewAny', App\Models\Contact::class) <!-- This validates if the user has permission to access to contact list -->
                                            <a href="{{ route('contacts.index', request()->query()) }}" class="btn btn-secondary back-to-list w-100">
                                                <i class="fa-solid fa-rotate-left mx-1"></i>
                                                <span>Back to contact list</span>
                                            </a>
                                        @endcan
                                    @endif
                                </div>
                        </div>
                </div>
            <!-- User info & Danger zone column -->
                <div class="col 12 col-lg-8 d-flex flex-column flex-md-row justify-content-md-center justify-content-lg-between mt-2 mt-lg-0 gap-4 px-0 px-lg-2">   
                    <!-- User info column --> 
                        <div class="col-12 col-md-3 col-lg-3 mt-md-2"> 
                            <p class="fw-bold">USER INFO</p>
                            <p>Username: <span class="fw-bold ms-1">{{$user->username}}</span></p>
                            <p>Name:<span class="fw-bold ms-1">{{$user->name}}</span></p>
                            <p>Role:<span class="fw-bold ms-1">{{ $user->is_admin ? 'admin' : 'user' }}</span></p>
                            <!-- Md screens and higher logout link: for all users -->
                                <div class="d-none d-md-flex justify-content-start">
                                    @if(auth()->id() === $user->id)
                                        <form action="{{ route('logout') }}" method="POST" class="w-100">
                                            @csrf
                                            <button type="submit" class="btn btn-dark logout-button">
                                                <i class="fa-solid fa-right-from-bracket"></i>
                                                    Logout
                                                </button>
                                            </form>
                                    @endif
                                </div>
                        </div>
                    <!-- Danger zone column --> 
                    <div class="col-12 col-md-8 col-lg-9 mt-md-2"> 
                        <p class="fw-bold">DANGER ZONE</p>
                            @if($user->contacts->isNotEmpty())
                                <!-- Delete all user's contacts form -->
                                    @can('deleteAllContacts', $user)
                                        <div class="delete-all-option p-2 rounded mb-4 mb-lg-1">
                                            <p>Delete all {{$user->username}}'s contacts</p>
                                            <form action="{{ route('contacts.destroy.all', $user) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger delete-all-contacts-button">Delete all contacts</button>
                                            </form>
                                        </div>
                                    @endcan
                                <!-- Transfer all user's contacts form -->
                                    @can('transferAllContacts', $user)
                                        <div class="transfer-all-option p-2 rounded mb-4 mb-lg-1">
                                            <form action="{{ route('contacts.transfer', $user) }}" method="POST">
                                                @csrf
                                                <p>Transfer all {{$user->username}}'s contacts to:</p>
                                                <select name="new_owner" id="new_owner" class="form-control">
                                                    <option value="" selected disabled>-- Select a user --</option> <!-- Opción por defecto -->
                                                    @foreach($users as $u)
                                                        <option value="{{ $u->id }}">{{ $u->username }} ({{ $u->name }})</option>
                                                    @endforeach
                                                </select>
                                                <button type="submit" class="btn btn-danger transfer-all-contacts-button mt-3 mt-lg-3">Transfer contacts</button>
                                            </form>
                                        </div>
                                    @endcan
                                <!-- Delete user message-->
                                    @if($user->username=='admin')
                                        <div class="delete-acount-option py-1 ps-2 rounded">
                                            <p class="fs-6 mt-1">This user can't be deleted</p>
                                            <button class="btn btn-danger disabled mb-1">Delete user</button>
                                        </div>
                                    @else
                                        <div class="delete-acount-option py-1 ps-2 rounded">
                                            <p class="fs-6 mt-1 pe-1">If you want to delete this user, you must first <span class="text-danger">DELETE</span> all user's contacts or <span class="text-danger">TRANSFER</span> them (Edit user) to another user.</p>
                                            <button class="btn btn-danger mb-1 mt-1 disabled">Delete user</button>
                                        </div>
                                    @endif
                            @else
                                <!-- Destroy user form -->
                                @if($user->username=='admin')
                                    <div class="delete-acount-option py-2 ps-3 rounded">
                                        <button class="btn btn-danger disabled my-2">Delete user</button>
                                        <p class="fs-6">This user can't be deleted</p>
                                    </div>
                                @else
                                    @can('destroy', $user)
                                        <form id="deleteUserForm" action="{{ route('users.destroy', $user->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <div class="d-flex justify-content-center justify-content-lg-start align-content-center p-2 rounded delete-acount-option">
                                                <button class="btn btn-danger m-2 delete-acount-button">Delete user</button>
                                            </div>
                                        </form>
                                    @endcan
                                @endif
                            @endif
                    </div>
                </div> 
        </div>
    </div>

<!-- Small screens logout link: for all users -->
    <div class="container d-md-none">
        @if(auth()->id() === $user->id)
            <form action="{{ route('logout') }}" method="POST" class="mt-4 d-flex justify-content-center">
                @csrf
                <button type="submit" class="btn btn-dark logout-button">
                    <i class="fa-solid fa-right-from-bracket"></i>
                        Logout
                </button>
            </form>
        @endif
    </div>

<!-- Small screens nav buttons -->
    <div class="container d-flex d-lg-none justify-content-center mt-5 gap-5">
        <!-- Back to edit user view --> 
        <div class="d-flex justify-content-center mt-3">
            @can('edit', $user)
                <a href="{{ route('users.edit', array_merge(['user' => $user->id], request()->query())) }}" class="btn btn-primary w-100 edit-user">
                    <i class="fa-solid fa-pencil-alt mx-1"></i>
                    <span>Edit user</span>
                </a>
            @endcan
        </div>
        <!-- Back to users/contact list view -->
            <div class="d-flex justify-content-center mt-3">
                @if (auth()->user()->is_admin)
                    @can('viewAny', App\Models\User::class) <!-- This validates if the user has permission to access to user list -->
                        <a href="{{ route('users.index', request()->query()) }}" class="btn btn-secondary back-to-list w-100">
                            <i class="fa-solid fa-rotate-left mx-1"></i>
                            <span>Back to user list</span>
                        </a>
                    @endcan
                @else
                    @can('viewAny', \App\Models\Contact::class) <!-- This validates if the user has permission to access to contact list -->
                        <a href="{{ route('contacts.index', request()->query()) }}" class="btn btn-secondary back-to-list w-100">
                            <i class="fa-solid fa-rotate-left mx-1"></i>
                            <span>Back to contact list</span>
                        </a>
                    @endcan
                @endif
            </div>
    </div>

@endsection

@push('styles')
    <!-- Index view custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/app/userprofile.css') }}">
    <!-- Index SweetAlert custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/sweetalert/globalsweetalert.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/app/user-profile.js') }}"></script>
@endpush