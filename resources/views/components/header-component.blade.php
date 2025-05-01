<nav class="navbar navbar-expand-md navbar-dark bg-dark sticky-top shadow-sm">
    <div class="container-fluid">
        <!-- Logo and app name -->
            <a href="{{ route('contacts.index') }}" class="text-decoration-none w-auto" style="all: unset; cursor: pointer;">
                <div class="d-flex flex-column align-items-start">
                    <span class="fs-3 fw-bold logo-color">
                        <img src="{{ asset('images/agendapp.png') }}" alt="AgendApp Logo" class="logo me-1" style="max-height: 35px;">
                        Agendapp
                    </span>
                    <span class="text-white ms-5" id="userName">
                        User: {{ auth()->user()->username ?? 'Guest' }}
                    </span>
                </div>
            </a>

        <!-- Hamburguer menu button -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuNav" aria-controls="menuNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        <!-- Menu content -->
            <div class="collapse navbar-collapse" id="menuNav">
                <ul class="navbar-nav ms-auto pe-3 fs-5">
                    <!-- Create new contact: for all users with permission -->
                        @can('create', \App\Models\Contact::class)
                            @if (!request()->routeIs('contacts.create'))
                                <li class="nav-item me-3">
                                    <a class="nav-link" style="color:rgb(219, 219, 219)" href="{{ route('contacts.create', [
                                        'user_id' => request()->query('user_id'),
                                        'search' => request()->query('search'),
                                        'sort' => request()->query('sort'),
                                        'direction' => request()->query('direction'),
                                        ]) }}">
                                        New contact
                                    </a>
                                </li>
                            @endif
                        @endcan
                    <!-- Create new user: only for admins -->
                        @if (auth()->user()->is_admin && !request()->routeIs('users.create'))
                            @can('create', \App\Models\User::class)        
                                <li class="nav-item me-3">
                                    <a class="nav-link" style="color:rgb(219, 219, 219)" href="{{ route('users.create') }}">New user</a>
                                </li>
                            @endcan
                        @endif
                    <!-- Manage contacts/manage users link: only for admins -->
                        @if (auth()->user()->is_admin)
                            @can('viewAny', \App\Models\User::class)
                                @if (request()->routeIs('users.*'))
                                    <li class="nav-item me-3">
                                        <a class="nav-link" style="color:rgb(219, 219, 219)" href="{{ route('contacts.index') }}">Manage contacts</a>
                                    </li>
                                @else
                                    <li class="nav-item me-3">
                                        <a class="nav-link" style="color:rgb(219, 219, 219)" href="{{ route('users.index') }}">Manage users</a>
                                    </li>
                                @endif
                            @endcan
                        @endif
                    <!-- Manage contacts link: only for no admins -->
                        @if (!auth()->user()->is_admin)
                            @can('viewAny', \App\Models\Contact::class)
                                @if (!request()->routeIs('contacts.index'))
                                    <li class="nav-item me-3">
                                        <a class="nav-link" style="color:rgb(219, 219, 219)" href="{{ route('contacts.index') }}">Manage contacts</a>
                                    </li>
                                @endif
                            @endcan
                        @endif
                    <!-- Logout link: for all users -->
                        <li class="nav-item me-3 d-none">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <a href="#" class="nav-link" style="color:rgb(219, 219, 219)" onclick="this.closest('form').submit(); return false;">
                                    <i class="fa-solid fa-right-from-bracket"></i>
                                    Logout
                                </a>
                            </form>
                        </li>
                    <!-- Profile link: for all users -->
                    <a href="{{ route('users.profile', Auth::user()) }}">
                        <li class="nav-item mx-0 mx-md-3 my-2 my-md-0 d-flex align-items-center">
                            <img src="{{ Auth::user()->profile_img ? asset('storage/' . Auth::user()->profile_img) : asset('images/profile1.png') }}" 
                                alt="User image" 
                                class="img-thumbnail rounded-circle" 
                                style="width: 40px; height: 40px; object-fit: cover; background-color: white;">
                        </li>
                    </a>
                </ul>
            </div>
    </div>
</nav>

