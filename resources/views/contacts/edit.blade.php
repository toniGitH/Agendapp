@extends('layouts.app')

@section('title')
    Edit {{ $contact->first_name }} {{ $contact->last_name_1 }} contact
@endsection

@section('content')

    {{-- Inside this view, we don't include the Bootstrap div container because we handle it in the
         app.blade layout.
    --}}

    {{-- Form to edit a contact --}}

    <form action="{{ route('contacts.update', $contact) }}" method="POST" novalidate class="mt-4" enctype="multipart/form-data"> 

        <div class="row">
            <div class="col-12 col-md-8 mb-2">
                <div class="d-flex justify-content-center align-items-baseline page-title">
                    <i class="fa-solid fa-pen-to-square fa-2xl" style="color: #212529"></i>
                    <h1>Edit contact</h1>
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
                                        {{ (old('user_id', $contact->user_id) == $user->id) ? 'selected' : '' }}>
                                        {{ $user->username }}
                                    </option>
                            @endforeach
                        </select>
                    </div>
                </div>
        </div>

        <div class="card-body p-0">
            {{-- method --}}
                @method('PUT')
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
                                <input type="text" name="first_name" id="first_name_id" class="form-control form-control-sm @error('first_name') is-invalid @enderror" value="{{ old('first_name', $contact->first_name) }}" maxlength="255" required>
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
                            <input type="text" name="last_name_1" id="last_name_1_id" class="form-control form-control-sm @error('last_name_1') is-invalid @enderror" value="{{ old('last_name_1', $contact->last_name_1) }}" maxlength="255" required>
                        </div>
                    </div>
                    <div class="col-12 col-md-4"> {{-- last_name_2 input --}}
                        <div class="mb-2"> 
                            <div class="d-flex justify-content-between align-items-center">
                                <label for="last_name_2_id" class="form-label mb-0">Last name 2:</label>
                                    @error('last_name_2')
                                        <span class="ms-2 error-form">{{ $message }}</span>
                                    @enderror
                        </div>
                            <input type="text" name="last_name_2" id="last_name_2_id" class="form-control form-control-sm @error('last_name_2') is-invalid @enderror" value="{{ old('last_name_2', $contact->last_name_2) }}" maxlength="255" placeholder="optional">
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
                            <input type="email" name="email" id="email_id" class="form-control form-control-sm @error('email') is-invalid @enderror" value="{{ old('email', $contact->email) }}" maxlength="255" required>
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
                            <input type="tel" name="mobile" id="mobile_id" class="form-control form-control-sm @error('mobile') is-invalid @enderror" value="{{ old('mobile', $contact->mobile) }}" required pattern="^\d{9}$" title="Please enter exactly 9 digits">
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
                            <input type="tel" name="landline" id="landline_id" class="form-control form-control-sm @error('landline') is-invalid @enderror" value="{{ old('landline', $contact->landline) }}" pattern="^\d{9}$" title="Please enter exactly 9 digits" placeholder="optional">
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
                            <input type="text" name="city" id="city_id" class="form-control form-control-sm @error('city') is-invalid @enderror" value="{{ old('city', $contact->city) }}" required maxlength="255">
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
                                <option value="" disabled {{ old('province', $contact->province) === null ? 'selected' : '' }}>For Spain, select the province</option>
                                <option value="Álava" {{ old('province', $contact->province) == 'Álava' ? 'selected' : '' }}>Álava</option>
                                <option value="Albacete" {{ old('province', $contact->province) == 'Albacete' ? 'selected' : '' }}>Albacete</option>
                                <option value="Alicante" {{ old('province', $contact->province) == 'Alicante' ? 'selected' : '' }}>Alicante</option>
                                <option value="Almería" {{ old('province', $contact->province) == 'Almería' ? 'selected' : '' }}>Almería</option>
                                <option value="Asturias" {{ old('province', $contact->province) == 'Asturias' ? 'selected' : '' }}>Asturias</option>
                                <option value="Ávila" {{ old('province', $contact->province) == 'Ávila' ? 'selected' : '' }}>Ávila</option>
                                <option value="Badajoz" {{ old('province', $contact->province) == 'Badajoz' ? 'selected' : '' }}>Badajoz</option>
                                <option value="Baleares" {{ old('province', $contact->province) == 'Baleares' ? 'selected' : '' }}>Baleares</option>
                                <option value="Barcelona" {{ old('province', $contact->province) == 'Barcelona' ? 'selected' : '' }}>Barcelona</option>
                                <option value="Burgos" {{ old('province', $contact->province) == 'Burgos' ? 'selected' : '' }}>Burgos</option>
                                <option value="Cáceres" {{ old('province', $contact->province) == 'Cáceres' ? 'selected' : '' }}>Cáceres</option>
                                <option value="Cádiz" {{ old('province', $contact->province) == 'Cádiz' ? 'selected' : '' }}>Cádiz</option>
                                <option value="Cantabria" {{ old('province', $contact->province) == 'Cantabria' ? 'selected' : '' }}>Cantabria</option>
                                <option value="Castellón" {{ old('province', $contact->province) == 'Castellón' ? 'selected' : '' }}>Castellón</option>
                                <option value="Ciudad Real" {{ old('province', $contact->province) == 'Ciudad Real' ? 'selected' : '' }}>Ciudad Real</option>
                                <option value="Córdoba" {{ old('province', $contact->province) == 'Córdoba' ? 'selected' : '' }}>Córdoba</option>
                                <option value="Cuenca" {{ old('province', $contact->province) == 'Cuenca' ? 'selected' : '' }}>Cuenca</option>
                                <option value="Gerona" {{ old('province', $contact->province) == 'Gerona' ? 'selected' : '' }}>Gerona</option>
                                <option value="Granada" {{ old('province', $contact->province) == 'Granada' ? 'selected' : '' }}>Granada</option>
                                <option value="Guadalajara" {{ old('province', $contact->province) == 'Guadalajara' ? 'selected' : '' }}>Guadalajara</option>
                                <option value="Guipúzcoa" {{ old('province', $contact->province) == 'Guipúzcoa' ? 'selected' : '' }}>Guipúzcoa</option>
                                <option value="Huelva" {{ old('province', $contact->province) == 'Huelva' ? 'selected' : '' }}>Huelva</option>
                                <option value="Huesca" {{ old('province', $contact->province) == 'Huesca' ? 'selected' : '' }}>Huesca</option>
                                <option value="Jaén" {{ old('province', $contact->province) == 'Jaén' ? 'selected' : '' }}>Jaén</option>
                                <option value="La Coruña" {{ old('province', $contact->province) == 'La Coruña' ? 'selected' : '' }}>La Coruña</option>
                                <option value="La Rioja" {{ old('province', $contact->province) == 'La Rioja' ? 'selected' : '' }}>La Rioja</option>
                                <option value="Las Palmas" {{ old('province', $contact->province) == 'Las Palmas' ? 'selected' : '' }}>Las Palmas</option>
                                <option value="León" {{ old('province', $contact->province) == 'León' ? 'selected' : '' }}>León</option>
                                <option value="Lérida" {{ old('province', $contact->province) == 'Lérida' ? 'selected' : '' }}>Lérida</option>
                                <option value="Lugo" {{ old('province', $contact->province) == 'Lugo' ? 'selected' : '' }}>Lugo</option>
                                <option value="Madrid" {{ old('province', $contact->province) == 'Madrid' ? 'selected' : '' }}>Madrid</option>
                                <option value="Málaga" {{ old('province', $contact->province) == 'Málaga' ? 'selected' : '' }}>Málaga</option>
                                <option value="Murcia" {{ old('province', $contact->province) == 'Murcia' ? 'selected' : '' }}>Murcia</option>
                                <option value="Navarra" {{ old('province', $contact->province) == 'Navarra' ? 'selected' : '' }}>Navarra</option>
                                <option value="Orense" {{ old('province', $contact->province) == 'Orense' ? 'selected' : '' }}>Orense</option>
                                <option value="Palencia" {{ old('province', $contact->province) == 'Palencia' ? 'selected' : '' }}>Palencia</option>
                                <option value="Pontevedra" {{ old('province', $contact->province) == 'Pontevedra' ? 'selected' : '' }}>Pontevedra</option>
                                <option value="Salamanca" {{ old('province', $contact->province) == 'Salamanca' ? 'selected' : '' }}>Salamanca</option>
                                <option value="Segovia" {{ old('province', $contact->province) == 'Segovia' ? 'selected' : '' }}>Segovia</option>
                                <option value="Sevilla" {{ old('province', $contact->province) == 'Sevilla' ? 'selected' : '' }}>Sevilla</option>
                                <option value="Soria" {{ old('province', $contact->province) == 'Soria' ? 'selected' : '' }}>Soria</option>
                                <option value="Tarragona" {{ old('province', $contact->province) == 'Tarragona' ? 'selected' : '' }}>Tarragona</option>
                                <option value="Tenerife" {{ old('province', $contact->province) == 'Tenerife' ? 'selected' : '' }}>Tenerife</option>
                                <option value="Teruel" {{ old('province', $contact->province) == 'Teruel' ? 'selected' : '' }}>Teruel</option>
                                <option value="Toledo" {{ old('province', $contact->province) == 'Toledo' ? 'selected' : '' }}>Toledo</option>
                                <option value="Valencia" {{ old('province', $contact->province) == 'Valencia' ? 'selected' : '' }}>Valencia</option>
                                <option value="Valladolid" {{ old('province', $contact->province) == 'Valladolid' ? 'selected' : '' }}>Valladolid</option>
                                <option value="Vizcaya" {{ old('province', $contact->province) == 'Vizcaya' ? 'selected' : '' }}>Vizcaya</option>
                                <option value="Zamora" {{ old('province', $contact->province) == 'Zamora' ? 'selected' : '' }}>Zamora</option>
                                <option value="Zaragoza" {{ old('province', $contact->province) == 'Zaragoza' ? 'selected' : '' }}>Zaragoza</option>
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
                            <input type="text" name="country" id="country_id" class="form-control form-control-sm @error('country') is-invalid @enderror" list="country-list" value="{{ old('country', $contact->country) }}" required maxlength="255">
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
                                <div class="d-flex flex-column flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <label for="notes_id" class="form-label mb-0">Notes:</label>
                                        @error('notes')
                                            <span class="ms-2 error-form">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <textarea name="notes" id="notes_id" class="form-control form-control-sm flex-grow-1 @error('notes') is-invalid @enderror" 
                                        placeholder="Here you can write a note about this contact. This is an optional field." 
                                        maxlength="255"
                                        style="min-height: 100px;">{{ old('notes', $contact->notes)}}</textarea>
                                </div>
                            </div>
                        </div>
                    {{-- contact photo: inputs and preview --}}
                        <div class="col-12 col-md-5 col-lg-4 d-flex flex-column flex-lg-row justify-content-lg-between">
                            {{-- contact photo file inputs: upload and delete --}}
                                <div class="col-12 col-lg-9">
                                    {{-- upload photo input (customized) --}}
                                        <div class="col-12 col-lg-11">
                                            <label for="image" class="form-label mb-1">Photo:</label>
                                            @error('image')
                                                <span class="ms-2 error-form">{{ $message }}</span>
                                            @enderror
                                            <div class="d-flex align-items-center bg-white rounded">
                                                <!-- custom button -->
                                                    <div class="d-flex align-items-center fileButton rounded-start" onclick="document.getElementById('image').click();">
                                                        <i class="fa-solid fa-folder-open p-2" style="color:white"></i>
                                                    </div>
                                                    <!-- hidden input file -->
                                                    <input type="hidden" name="current_image" value="{{ $contact->image }}">
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
                                <div class="col-12 col-lg-3 d-flex flex-column contact-img-prev align-self-center align-self-lg-start mt-1 mt-md-2 mt-lg-0">
                                    <div class="d-flex flex-column flex-grow-1">
                                        <span class="form-label m-0 d-none d-md-inline-block">Preview:</span>
                                        <div class="d-flex flex-grow-1">
                                            <div id="imagePreviewContainer" class="w-100 d-flex align-items-stretch flex-grow-1">
                                                @if($contact->image)
                                                    <img src="{{ asset('storage/' . $contact->image) }}" alt="Contact image" 
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
                    {{-- Buttons --}}
                        <div class="col-12 col-lg-4 d-flex flex-column justify-content-center align-items-center mt-4 mt-lg-2">
                            {{-- Submit button --}}
                                <div class="d-flex justify-content-center mt-3 mb-2 mb-md-0 w-100">
                                    @can('update', $contact)
                                        <!-- If the user is admin or has the permission to update this contact -->
                                        <button type="submit" class="btn btn-primary update-contact w-100">
                                            <i class="fa-solid fa-thumbs-up fa-lg mx-2"></i>
                                            Update Contact
                                        </button>
                                    @else
                                        <!-- If the user doesn't has the permission to update this contact, the button is disabled -->
                                        <button type="button" class="btn btn-primary update-contact w-100 disabled" style="opacity: 0.2; pointer-events: none;">
                                            <i class="fa-solid fa-thumbs-up fa-lg mx-2"></i>
                                            Update Contact
                                        </button>
                                    @endcan
                                </div>
                            {{-- Nav buttons --}}
                                <div class="control-buttons d-flex justify-content-between gap-4 w-100">
                                    {{-- Return to contact --}}
                                        <div class="d-flex justify-content-center align-items-center mt-3 w-100">
                                            <a href="{{ route('contacts.show', ['contact' => $contact, 'user_id' => request()->query('user_id')] + request()->only(['sort', 'direction', 'search'])) }}" class="btn btn-secondary back-to-list w-100 view-contact">
                                                <i class="fa-solid fa-eye mx-1"></i>
                                                <span>View Contact</span>
                                            </a>    
                                        </div>
                                    {{-- Back to contacts button --}}
                                        <div class="d-flex justify-content-center mt-3 w-100">
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
    <script src="{{ asset('js/app/edit.js') }}"></script>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/app/edit.css') }}">
@endpush