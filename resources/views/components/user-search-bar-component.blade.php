<div class="d-flex justify-content-center mb-2 mb-sm-5 mb-lg-2 filter-component-container">
    
    <!-- Users Search Form -->
        <div class="filter-box p-2 rounded">
            <!-- Filter icon/text -->
                <div class="text-white fw-bold ms-1">Filter users by</div>
            <!-- Filter form -->
            <form action="{{ route('users.index') }}" method="GET" class="d-flex flex-column justify-content-lg-between gap-lg-3">
                <!-- Search bar inputs -->
                    <div class="search-inputs flex-lg-grow-1 p-1 rounded mb-2 mb-sm-0">
                        <!-- Search bar input text -->
                            <input type="text" name="search" class="form-control mb-2" placeholder="Type name or username" value="{{ $search }}">
                        <!-- Search bar checkboxes for Admin and User Filter -->
                            <div class="d-inline-flex justify-content-start gap-4 mt-2 text-white">
                                <!-- Filter by admin box -->
                                    <div class="form-check">
                                        <input type="checkbox" name="admin_filter" id="adminFilter" value="1" class="form-check-input"
                                            {{ request('admin_filter') == '1' ? 'checked' : '' }}>
                                        <label for="adminFilter" class="form-check-label">Admin</label>
                                    </div>
                                <!-- Filter by no admin box -->
                                    <div class="form-check">
                                        <input type="checkbox" name="user_filter" id="userFilter" value="1" class="form-check-input"
                                            {{ request('user_filter') == '1' ? 'checked' : '' }}>
                                        <label for="userFilter" class="form-check-label">No admin</label>
                                    </div>
                            </div>
                    </div>
                <!-- Search and reset buttons -->
                    <div class="w-auto align-self-end filter-buttons">
                        <div class="d-flex justify-content-center justify-content-sm-end gap-3 gap-lg-3 me-2 rounded">
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn w-auto apply-filters-button">
                                    <i class="fa-solid fa-filter mx-1"></i>
                                    Apply <span class="d-none">filters</span>
                                </button>
                            </div>
                            <div class="d-flex justify-content-center">
                                <a href="{{ route('users.index') }}" class="btn w-auto reset-filters-button">
                                    <i class="fa-solid fa-broom mx-1"></i>
                                    Reset <span class="d-none">filters</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    
            </form>

        </div>
    
</div>

<style>

    .filter-box {
        background-color: #212529;
        display: inline-block;
        width: 100%;
        margin: 20px 0;
    }

    .apply-filters-button{
        background-color:rgb(255, 255, 255);
        color: #212529;
    }

    .apply-filters-button:hover{
        background-color: rgb(221, 221, 221);
        color: rgb(0, 0, 0);
    }

    .reset-filters-button{
        background-color:rgba(78, 194, 10, 0.94);
        color: #212529;
    }

    .reset-filters-button:hover{
        background-color: rgb(221, 221, 221);
        color: rgb(0, 0, 0);
    }

    @media (min-width: 576px) {
        .filter-box{
            width: 80%
        }
    }

    @media (min-width: 620px) {
        .filter-buttons{
            margin-top: -30px;
        }
    }

    @media (min-width: 768px) {
        .filter-buttons{
            margin-top: -30px;
        }
    }

    @media (min-width: 993px) {
        .filter-component-container{
        margin-top: -20px;
        }
        .filter-buttons{
            margin-top: -45px;
        }
    }

</style>