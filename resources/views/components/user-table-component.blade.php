<div class="container">
    <div class="row justify-content-center gy-1 gy-sm-3">
        @foreach ($users as $user)
            <div class="col-12 col-sm-6 col-lg-3 mb-3 d-flex justify-content-center user-item">
                <!-- Not mobile view -->
                <div class="card text-center shadow-sm d-sm-block d-none" style="width: 14rem;">
                    @can('profile', $user)
                        <a href="{{ route('users.profile', array_merge(['user' => $user->id], request()->query())) }}">
                            <div class="card-body rounded {{ $user->is_admin ? 'admin-bg' : 'user-bg' }}">
                                <img src="{{ $user->profile_img ? asset('storage/' . $user->profile_img) : asset('images/profile1.png') }}" 
                                    alt="User image" 
                                    class="img-thumbnail rounded-circle mb-2" 
                                    style="width: 60px; height: 60px; object-fit: cover; background-color: white;">
                                <h5 class="card-title">{{ $user->username }}</h5>
                                <div class="span-name mb-2">({{ $user->name }})</div>
                                <p class="card-text role">
                                    {{ $user->is_admin ? 'Admin' : 'User' }}
                                </p>
                            </div>
                        </a>
                    @endcan
                </div>
                    
                <!-- Mobile view -->
                <div class="d-flex justify-content-between align-items-center w-100 d-sm-none user-list ms-1 p-1">
                    @can('profile', $user)
                        <a href="{{ route('users.profile', $user) }}">
                            <img src="{{ $user->profile_img ? asset('storage/' . $user->profile_img) : asset('images/profile1.png') }}" 
                                alt="User image" 
                                class="img-thumbnail rounded-circle col-3 me-1" 
                                style="width: 40px; height: 40px; object-fit: cover; background-color: white;">
                            <span class="col-3">{{ $user->username }}</span>
                        </a>
                        <span class="text-muted col-4 ms-3 hidden">{{ $user->is_admin ? 'admin' : 'user' }}</span>
                    @endcan
                    
                </div>
            </div>
        @endforeach
    </div>

    @if ($users->isEmpty())
        <div class="text-center py-3 no-contacts">
            <i class="fa-solid fa-users-slash"></i>
            <div class="mx-4">
                <span>-</span>
                <span class="mx-3">No users found</span>
                <span>-</span>
            </div>
            <i class="fa-solid fa-users-slash"></i>
        </div>
    @endif
</div>

<style>

    /* ==== CARDS LINK STYLE ANULATION ==== */
    .user-item a{
        text-decoration: none;
        color: inherit;
    }
    .user-item a .card-title{
        margin-bottom: 0px;
    }
    .user-item a .span-name{
        opacity: 70%;
        margin-bottom: 20px;
        font-size: medium;
        color: rgb(255, 255, 255);
    }

    /* ==== CARDS FOR MD AND LARGER ==== */
    .card {
        border: 1px solid #ddd;
        border-radius: 10px;
        transition: transform 0.2s;
    }
    .card:hover {
        transform: scale(1.05);
    }

    /* ==== LIST STYLE FOR SM AND SMALLER==== */
    .no-contacts {
        font-size: 1.3rem;
        background-color: rgb(95, 95, 95);
        color: white;
    }

    /* ==== MEDIAQUERIES ==== */

    @media (max-width: 380px) {
        .hidden{
            display: none;
        }
    }

    @media (max-width: 575px) {
        .user-list:hover {
            background-color: rgb(214, 214, 214);
            border-radius: 5%;
        }
    }

    @media (min-width: 576px) {
        .admin-bg, .user-bg {
            background-color:rgba(33, 37, 41, 0.64);
            color: white;
        }
        .admin-bg .role, .user-bg .role {
            color: rgba(247, 245, 245, 0.4);
            background-color:rgba(33, 37, 41, 0.23);
            border-radius: 25px;
        }
    }

</style>