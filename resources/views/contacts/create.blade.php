@extends('layouts.app')

@section('title', 'New contact')

@section('content')

    {{-- Form to add a new contact --}}
    <form action="{{ route('contacts.store') }}" method="POST" novalidate class="mt-4" enctype="multipart/form-data"> 
        <div class="row">
            {{-- form name --}}
                <div class="col-12 col-md-8 mb-2">
                    <div class="d-flex justify-content-center align-items-baseline page-title">
                        <i class="fa-solid fa-square-plus fa-2xl" style="color: #212529"></i>
                        <h1>Add contact</h1>
                        <i class="fa-solid fa-address-card fa-2xl"></i>
                    </div>
                </div>
            {{-- User assignment input --}}
                <div class="col-12 col-md-4 mb-2">
                    <div class="mb-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <label for="user_id" class="form-label mb-0">Assign User:</label>
                            @error('user_id')
                                <span class="ms-2 error-form">{{ $message }}</span>
                            @enderror
                        </div>
                        <select name="user_id" id="user_id" class="form-select form-select-sm @error('user_id') is-invalid @enderror" required>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" 
                                    {{ old('user_id', auth()->id()) == $user->id ? 'selected' : '' }}>
                                    {{ $user->username }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            {{-- form inputs --}}
            <div class="card-body p-0">

                {{-- csrf token --}}
                    @csrf
                {{-- contact name inputs --}}
                    <div class="row">
                        <div class="col-12 col-md-4"> {{-- first_name input --}}
                            <div class="mb-2"> 
                                <div class="d-flex justify-content-between align-items-center">
                                    <label for="first_name_id" class="form-label mb-0">First name:</label>
                                        @error('first_name')
                                            <span class="ms-2 error-form">{{ $message }}</span>
                                        @enderror
                                </div>
                                    <input type="text" name="first_name" id="first_name_id" class="form-control form-control-sm @error('first_name') is-invalid @enderror" value="{{ old('first_name') }}" maxlength="255" required>
                            </div>
                        </div>
                        <div class="col-12 col-md-4"> {{-- last_name_1 input --}}
                            <div class="mb-2"> 
                                <div class="d-flex justify-content-between align-items-center">
                                    <label for="last_name_1_id" class="form-label mb-0">Last name 1:</label>
                                        @error('last_name_1')
                                            <span class="ms-2 error-form">{{ $message }}</span>
                                        @enderror
                                </div>
                                <input type="text" name="last_name_1" id="last_name_1_id" class="form-control form-control-sm @error('last_name_1') is-invalid @enderror" value="{{ old('last_name_1') }}" maxlength="255" required>
                            </div>
                        </div>
                        <div class="col-12 col-md-4"> {{-- last_name_2 input --}}
                            <div class="mb-2"> 
                                <div class="d-flex justify-content-between align-items-center">
                                    <label for="last_name_2_id" class="form-label mb-0">Last name 2:</label>
                                        @error('last_name_2')
                                            <span class="ms-2 error-form">{{ $message }}</span>                                        @enderror
                                </div>
                                <input type="text" name="last_name_2" id="last_name_2_id" class="form-control form-control-sm @error('last_name_2') is-invalid @enderror" value="{{ old('last_name_2') }}" maxlength="255" placeholder="optional">
                            </div>
                        </div>
                    </div>
                {{-- contact email and phone inputs --}}
                    <div class="row">
                        <div class="col-12 col-md-4"> {{-- email input --}}
                            <div class="mb-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <label for="email_id" class="form-label mb-0">Email:</label>
                                        @error('email')
                                            <span class="ms-2 error-form">{{ $message }}</span>
                                        @enderror
                                </div>
                                <input type="email" name="email" id="email_id" class="form-control form-control-sm @error('email') is-invalid @enderror" value="{{ old('email') }}" maxlength="255" required>
                            </div>
                        </div>
                        <div class="col-12 col-md-4"> {{-- mobile phone input --}}
                            <div class="mb-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <label for="mobile_id" class="form-label mb-0">Mobile phone:</label>
                                    @error('mobile')
                                        <span class="ms-2 error-form">{{ $message }}</span>
                                    @enderror
                                </div>
                                <input type="tel" name="mobile" id="mobile_id" class="form-control form-control-sm @error('mobile') is-invalid @enderror" value="{{ old('mobile') }}" required pattern="^\d{9}$" title="Please enter exactly 9 digits">
                            </div>
                        </div>
                        <div class="col-12 col-md-4"> {{-- landline input --}}
                            <div class="mb-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <label for="landline_id" class="form-label mb-0">Landline:</label>
                                    @error('landline')
                                        <span class="ms-2 error-form">{{ $message }}</span>
                                    @enderror
                                </div>
                                <input type="tel" name="landline" id="landline_id" class="form-control form-control-sm @error('landline') is-invalid @enderror" value="{{ old('landline') }}" pattern="^\d{9}$" title="Please enter exactly 9 digits" placeholder="optional">
                            </div>
                        </div>
                    </div>
                {{-- contact address inputs--}}
                    <div class="row">
                        <div class="col-12 col-md-4"> {{-- city input --}}
                            <div class="mb-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <label for="city_id" class="form-label mb-0">City:</label>
                                    @error('city')
                                        <span class="ms-2 error-form">{{ $message }}</span>
                                    @enderror
                                </div>
                                <input type="text" name="city" id="city_id" class="form-control form-control-sm @error('city') is-invalid @enderror" value="{{ old('city') }}" required maxlength="255">
                            </div>
                        </div>
                        <div class="col-12 col-md-4"> {{-- province input --}}
                            <div class="mb-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <label for="province_id" class="form-label mb-0">Province:</label>
                                    @error('province')
                                        <span class="ms-2 error-form">{{ $message }}</span>
                                    @enderror
                                </div>
                                <select name="province" id="province_id" class="form-control form-control-sm @error('province') is-invalid @enderror" required maxlength="255">
                                    <option value="">For Spain, select the province</option>
                                    <option value="Álava" {{ old('province') == 'Álava' ? 'selected' : '' }}>Álava</option>
                                    <option value="Albacete" {{ old('province') == 'Albacete' ? 'selected' : '' }}>Albacete</option>
                                    <option value="Alicante" {{ old('province') == 'Alicante' ? 'selected' : '' }}>Alicante</option>
                                    <option value="Almería" {{ old('province') == 'Almería' ? 'selected' : '' }}>Almería</option>
                                    <option value="Asturias" {{ old('province') == 'Asturias' ? 'selected' : '' }}>Asturias</option>
                                    <option value="Ávila" {{ old('province') == 'Ávila' ? 'selected' : '' }}>Ávila</option>
                                    <option value="Badajoz" {{ old('province') == 'Badajoz' ? 'selected' : '' }}>Badajoz</option>
                                    <option value="Baleares" {{ old('province') == 'Baleares' ? 'selected' : '' }}>Baleares</option>
                                    <option value="Barcelona" {{ old('province') == 'Barcelona' ? 'selected' : '' }}>Barcelona</option>
                                    <option value="Burgos" {{ old('province') == 'Burgos' ? 'selected' : '' }}>Burgos</option>
                                    <option value="Cáceres" {{ old('province') == 'Cáceres' ? 'selected' : '' }}>Cáceres</option>
                                    <option value="Cádiz" {{ old('province') == 'Cádiz' ? 'selected' : '' }}>Cádiz</option>
                                    <option value="Cantabria" {{ old('province') == 'Cantabria' ? 'selected' : '' }}>Cantabria</option>
                                    <option value="Castellón" {{ old('province') == 'Castellón' ? 'selected' : '' }}>Castellón</option>
                                    <option value="Ciudad Real" {{ old('province') == 'Ciudad Real' ? 'selected' : '' }}>Ciudad Real</option>
                                    <option value="Córdoba" {{ old('province') == 'Córdoba' ? 'selected' : '' }}>Córdoba</option>
                                    <option value="Cuenca" {{ old('province') == 'Cuenca' ? 'selected' : '' }}>Cuenca</option>
                                    <option value="Gerona" {{ old('province') == 'Gerona' ? 'selected' : '' }}>Gerona</option>
                                    <option value="Granada" {{ old('province') == 'Granada' ? 'selected' : '' }}>Granada</option>
                                    <option value="Guadalajara" {{ old('province') == 'Guadalajara' ? 'selected' : '' }}>Guadalajara</option>
                                    <option value="Guipúzcoa" {{ old('province') == 'Guipúzcoa' ? 'selected' : '' }}>Guipúzcoa</option>
                                    <option value="Huelva" {{ old('province') == 'Huelva' ? 'selected' : '' }}>Huelva</option>
                                    <option value="Huesca" {{ old('province') == 'Huesca' ? 'selected' : '' }}>Huesca</option>
                                    <option value="Jaén" {{ old('province') == 'Jaén' ? 'selected' : '' }}>Jaén</option>
                                    <option value="La Coruña" {{ old('province') == 'La Coruña' ? 'selected' : '' }}>La Coruña</option>
                                    <option value="La Rioja" {{ old('province') == 'La Rioja' ? 'selected' : '' }}>La Rioja</option>
                                    <option value="Las Palmas" {{ old('province') == 'Las Palmas' ? 'selected' : '' }}>Las Palmas</option>
                                    <option value="León" {{ old('province') == 'León' ? 'selected' : '' }}>León</option>
                                    <option value="Lérida" {{ old('province') == 'Lérida' ? 'selected' : '' }}>Lérida</option>
                                    <option value="Lugo" {{ old('province') == 'Lugo' ? 'selected' : '' }}>Lugo</option>
                                    <option value="Madrid" {{ old('province') == 'Madrid' ? 'selected' : '' }}>Madrid</option>
                                    <option value="Málaga" {{ old('province') == 'Málaga' ? 'selected' : '' }}>Málaga</option>
                                    <option value="Murcia" {{ old('province') == 'Murcia' ? 'selected' : '' }}>Murcia</option>
                                    <option value="Navarra" {{ old('province') == 'Navarra' ? 'selected' : '' }}>Navarra</option>
                                    <option value="Orense" {{ old('province') == 'Orense' ? 'selected' : '' }}>Orense</option>
                                    <option value="Palencia" {{ old('province') == 'Palencia' ? 'selected' : '' }}>Palencia</option>
                                    <option value="Pontevedra" {{ old('province') == 'Pontevedra' ? 'selected' : '' }}>Pontevedra</option>
                                    <option value="Salamanca" {{ old('province') == 'Salamanca' ? 'selected' : '' }}>Salamanca</option>
                                    <option value="Segovia" {{ old('province') == 'Segovia' ? 'selected' : '' }}>Segovia</option>
                                    <option value="Sevilla" {{ old('province') == 'Sevilla' ? 'selected' : '' }}>Sevilla</option>
                                    <option value="Soria" {{ old('province') == 'Soria' ? 'selected' : '' }}>Soria</option>
                                    <option value="Tarragona" {{ old('province') == 'Tarragona' ? 'selected' : '' }}>Tarragona</option>
                                    <option value="Tenerife" {{ old('province') == 'Tenerife' ? 'selected' : '' }}>Tenerife</option>
                                    <option value="Teruel" {{ old('province') == 'Teruel' ? 'selected' : '' }}>Teruel</option>
                                    <option value="Toledo" {{ old('province') == 'Toledo' ? 'selected' : '' }}>Toledo</option>
                                    <option value="Valencia" {{ old('province') == 'Valencia' ? 'selected' : '' }}>Valencia</option>
                                    <option value="Valladolid" {{ old('province') == 'Valladolid' ? 'selected' : '' }}>Valladolid</option>
                                    <option value="Vizcaya" {{ old('province') == 'Vizcaya' ? 'selected' : '' }}>Vizcaya</option>
                                    <option value="Zamora" {{ old('province') == 'Zamora' ? 'selected' : '' }}>Zamora</option>
                                    <option value="Zaragoza" {{ old('province') == 'Zaragoza' ? 'selected' : '' }}>Zaragoza</option>
                                </select>
                                
                            </div>
                        </div>
                        <div class="col-12 col-md-4"> {{-- country input --}}
                            <div class="mb-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <label for="country_id" class="form-label mb-0">Country:</label>
                                    @error('country')
                                        <span class="ms-2 error-form">{{ $message }}</span>
                                    @enderror
                                </div>
                                <input type="text" name="country" id="country_id" class="form-control form-control-sm @error('country') is-invalid @enderror" list="country-list" value="{{ old('country') }}" required maxlength="255">
                                <datalist id="country-list">
                                    <option value="Austria">
                                    <option value="Belgium">
                                    <option value="Bulgaria">
                                    <option value="Croatia">
                                    <option value="Cyprus">
                                    <option value="Czech Republic">
                                    <option value="Denmark">
                                    <option value="Estonia">
                                    <option value="Finland">
                                    <option value="France">
                                    <option value="Germany">
                                    <option value="Greece">
                                    <option value="Hungary">
                                    <option value="Ireland">
                                    <option value="Italy">
                                    <option value="Latvia">
                                    <option value="Lithuania">
                                    <option value="Luxembourg">
                                    <option value="Malta">
                                    <option value="Netherlands">
                                    <option value="Poland">
                                    <option value="Portugal">
                                    <option value="Romania">
                                    <option value="Slovakia">
                                    <option value="Slovenia">
                                    <option value="Spain">
                                    <option value="Sweden">
                                </datalist>
                            </div>
                        </div>
                    </div>
                {{-- contact notes, image and buttons --}}
                    <div class="row align-items-stretch">
                        {{-- contact notes input --}}
                            <div class="col-12 col-md-7 col-lg-4 d-flex flex-column mb-2 mb-md-0">
                                <div class="flex-grow-1 d-flex flex-column">
                                    <div class="d-flex flex-column flex-grow-1 mb-4 mb-lg-0">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <label for="notes_id" class="form-label mb-0">Notes:</label>
                                            @error('notes')
                                                <span class="ms-2 error-form">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <textarea name="notes" id="notes_id" class="form-control form-control-sm flex-grow-1 @error('notes') is-invalid @enderror"
                                            placeholder="Here you can write a note about this contact. This is an optional field."
                                            maxlength="255"
                                            style="min-height: 100px;">{{ old('notes') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        {{-- contact photo: input and preview --}}
                            <div class="col-12 col-md-5 col-lg-4 d-flex flex-column flex-lg-row justify-content-lg-between">
                                {{-- contact photo file input (customized) --}}
                                    <div class="col-12 col-lg-9 mb-2">
                                        <div class="col-12 col-lg-11">
                                            <label for="image" class="form-label mb-1">Photo:</label>
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
                                {{-- contact photo preview --}}
                                    <div class="col-12 col-lg-3 d-flex flex-column contact-img-prev align-self-center align-self-lg-start mt-1 mt-md-2 mt-lg-0">
                                        <div class="d-flex flex-column flex-grow-1 mb-4 mb-lg-0">
                                            <span class="form-label m-0 d-none d-md-inline-block">Preview:</span>
                                            <div class="d-flex flex-grow-1">
                                                <div id="imagePreviewContainer" class="w-100 d-flex align-items-stretch flex-grow-1">
                                                    <!-- Default image -->
                                                    <img src="{{ asset('images/profile1.png') }}" id="previewImage" alt="Contact image"
                                                    class="img-thumbnail w-100 flex-grow-1"
                                                    style="object-fit: cover; min-height: 100px;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        {{-- Buttons --}}
                            <div class="col-12 col-lg-4 d-flex flex-lg-column align-items-center mt-4 mb-4 mb-lg-0 mt-lg-2">
                                {{-- Submit button --}}
                                    <div class="d-flex justify-content-center mt-lg-3 mb-md-0 mb-lg-2 w-100">
                                        <button type="submit" class="btn btn-primary add-contact w-100 mx-4 mx-lg-0">
                                            <i class="fa-solid fa-user-plus fa-flip-horizontal mx-1"></i>
                                            Save Contact
                                        </button>
                                    </div>
                                {{-- Back to contacts --}}
                                    <div class="control-buttons d-flex justify-content-between gap-4 w-100">
                                        {{-- Back to index button --}}
                                            <div class="d-flex justify-content-center mt-lg-3 w-100 mx-4 mx-lg-0">
                                                <a href="{{ route('contacts.index', request()->query()) }}" class="btn btn-secondary back-to-list w-100">
                                                    <i class="fa-solid fa-rotate-left mx-1"></i>
                                                    <span>Back to contacts</span>
                                                </a>
                                            </div>
                                    </div>
                            </div>
                    </div>
        </div>
    </form>

@endsection

@push('scripts')
    <script src="{{ asset('js/app/create.js') }}"></script>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/app/create.css') }}">
@endpush