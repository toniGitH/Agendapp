{{-- Search-bar-component view --}}

<div class="row mx-lg-2">
    <!-- Filter form -->
        <div class="px-2 py-2 mb-2 mb-sm-0 border-0 border-md rounded filter-box">
            <form method="GET" action="{{ route('contacts.index') }}" class="d-flex flex-column flex-md-row justify-content-md-between">
                {{-- Inputs --}}
                    <div class="d-flex flex-column flex-md-row align-items-md-center flex-grow-1">
                        {{-- Filter icon/text --}}
                            <span class="text-white fw-bold ms-1 ms-md-0 ms-lg-2 mb-2 mb-md-0 me-md-3">Filter <span class="d-md-none">contacts</span> by</span>
                        {{-- Filter inputs --}}
                            <div class="d-flex flex-column flex-sm-row mb-3 mb-md-0 gap-2 flex-grow-1">
                                {{-- User selector --}}
                                    <select name="user_id" class="form-select w-auto">
                                        <option value="all" {{ request()->query('user_id', auth()->id()) === 'all' ? 'selected' : '' }}>All contacts</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}" 
                                                @if((string) request()->query('user_id', auth()->id()) === (string) $user->id) 
                                                    selected 
                                                @endif>
                                                {{ $user->username }}'s contacts
                                            </option>
                                        @endforeach
                                    </select>
                                {{-- Search terms input --}}
                                    <input type="text" name="search" class="form-control search-input" placeholder="Name, surname, email or mobilephone" value="{{ request()->query('search') }}">
                            </div> 
                    </div>
                    {{-- Submit and Reset buttons --}}
                        <div class="d-flex justify-content-center gap-2">
                            <button type="submit" class="btn mx-auto mb-1 mb-md-0 apply-filters-button">
                                <i class="fa-solid fa-filter mx-1"></i>
                                Apply <span class="d-md-none d-lg-inline-block">filters</span>
                            </button>

                            <a href="{{ route('contacts.index') }}" class="btn mx-auto mb-1 mb-md-0 reset-filters-button">
                                <i class="fa-solid fa-rotate-left mx-1"></i>
                                <span class="d-md-none d-lg-inline-block">Reset</span>
                            </a>
                        </div>
            </form>
        </div>
</div>

<style>

    /* ==== GENERAL STYLES ==== */

    /* Filter box styles*/

    .filter-box {
        background-color: #212529;
    }
    .apply-filters-button{
        background-color: rgb(221, 221, 221);
        color:rgb(41, 35, 33);
    }
    .reset-filters-button{
        background-color:rgb(221, 221, 221);
        color: #212529;
    }
    .apply-filters-button:hover{
        background-color: rgb(255, 255, 255);
        color: rgb(0, 0, 0);
    }
    .reset-filters-button:hover{
        background-color: rgb(255, 255, 255);
        color: rgb(0, 0, 0);
    }
    /* Info button hover effect */
    .btn-info:hover {
        background-color: green;
        border-color: green;
        text-decoration: none;
        color: rgb(255, 255, 255);
    }

    /* ==== MEDIA QUERIES ==== */

    /* Reduce placeholder font size on very small screens */
    @media (max-width: 360px) {
        input::placeholder {
            font-size: 0.9rem;
        }
    }
    /* Reduce placeholder font size in a specific range */
    @media (min-width: 768px) and (max-width: 785px) {
        input::placeholder {
            font-size: 0.9rem;
        }
    }
    /* Set input width to 60% on screens wider than 768px */
    @media (min-width: 768px) {
        input.search-input {
            width: 60%;
        }
    }

</style>
