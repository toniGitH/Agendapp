@extends('layouts.app')

@section('title')
    {{ $contact->first_name }} {{ $contact->last_name_1 }} details
@endsection

@section('content')
    
    <div class="row d-flex justify-content-center mt-4">
        <div class="col-12 col-sm-10 col-md-11 col-lg-9 col-xl-8 p-2">
            {{-- Contact container --}}
                <div class="row contact-container">
                    {{-- Left section: contact photo --}}
                        <div class="col-12 col-md-4 col-lg-4 col-xl-4 d-none d-md-flex justify-content-center align-items-stretch mb-4 mb-md-0">
                            <img src="{{ $contact->image ? asset('storage/' . $contact->image) : asset('images/profile1.png') }}"
                                alt="Profile picture" class="img-fluid rounded" style="object-fit: cover; height: 100%;">
                        </div>
                    {{-- Right section: contact information and buttons --}}
                        <div class="col-12 col-md-8 col-lg-8 col-xl-8">
                            {{-- Contact header: name and contact owner --}}
                                <div class="card-header d-flex flex-column flex-lg-row justify-content-md-between">
                                    {{-- Contact name --}}
                                    <div class="d-flex align-items-center justify-content-start">
                                        <div class="d-flex align-items-center py-md-1">
                                            <div class="d-flex justify-content-center align-items-center me-1"
                                                style="width: 2rem; height: 2rem;">
                                                <i class="fa-solid fa-user fa-xl"></i>
                                            </div>
                                        </div>
                                        <span class="contact-title">{{ $contact->first_name }} {{ $contact->last_name_1 }}
                                            {{ $contact->last_name_2 }}</span>
                                    </div>
                                    {{-- Contact belongs to --}}
                                    <div class="d-flex align-items-center justify-content-lg-end px-lg-2 py-lg-2 contact-owner">
                                        <div class="d-flex align-items-center">
                                            <div class="d-flex justify-content-center align-items-center"
                                                style="width: 2rem; height: 2rem;">
                                                <i class="fa-solid fa-user-lock"></i>
                                            </div>
                                        </div>
                                        <span>
                                            <span>Owner: </span>
                                            {{ $contact->user->username }}
                                        </span>
                                    </div>
                                </div>
                            {{-- Contact body: contact info and address info --}}
                                <div class="card-body">
                                    {{-- Main info --}}
                                        <div class="d-flex justify-content-between justify-content-md-center">
                                            {{-- Data --}}
                                                <div class="d-flex flex-column flex-md-row info-columns justify-content-md-between">
                                                    {{-- Left column: email, mobile phone and landline --}}
                                                        <div class="left-column-card-body">
                                                            {{-- Contact email --}}
                                                            <div class="row mb-2 me-md-4">
                                                                <div class="col d-flex justify-content-start">
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="d-flex align-items-center p-1">
                                                                            <div class="d-flex justify-content-center align-items-center"
                                                                                style="width: 2rem; height: 2rem;">
                                                                                <i class="fa-solid fa-envelope fa-lg"></i>
                                                                            </div>
                                                                        </div>
                                                                        <span class="fs-6 fs-md-5">{{ $contact->email }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            {{-- Contact Mobile phone --}}
                                                            <div class="row mb-2 me-md-4">
                                                                <div class="col d-flex justify-content-start">
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="d-flex align-items-center p-1">
                                                                            <div class="d-flex justify-content-center align-items-center"
                                                                                style="width: 2rem; height: 2rem;">
                                                                                <i class="fa-solid fa-mobile-screen-button fa-xl fa-rotate-by"
                                                                                            style="--fa-rotate-angle: -15deg;"></i>
                                                                            </div>
                                                                        </div>
                                                                        <span class="fs-6 fs-md-5">{{ $contact->mobile }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            {{-- Contact Landline --}}
                                                            <div class="row mb-2 me-md-4">
                                                                <div class="col d-flex justify-content-start">
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="d-flex align-items-center p-1">
                                                                            <div class="d-flex justify-content-center align-items-center"
                                                                                style="width: 2rem; height: 2rem;">
                                                                                <i class="fa-solid fa-phone fa-xl"></i>
                                                                            </div>
                                                                        </div>
                                                                        <span
                                                                                    class="fs-6 fs-md-5">{{ $contact->landline ? $contact->landline : 'Not available' }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    {{-- Right column: city, province and country --}}
                                                        <div class="right-column-card-body">
                                                            {{-- Contact city --}}
                                                            <div class="row mb-2">
                                                                <div class="col d-flex justify-content-start">
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="d-flex align-items-center p-1">
                                                                            <div class="d-flex justify-content-center align-items-center"
                                                                                style="width: 2rem; height: 2rem;">
                                                                                <i class="fa-solid fa-city fa-lg"></i>
                                                                            </div>
                                                                        </div>
                                                                        <span class="fs-6 fs-md-5">{{ $contact->city }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                                {{-- Contact province --}}
                                                                <div class="row mb-2">
                                                                    <div class="col d-flex justify-content-start">
                                                                        <div class="d-flex align-items-center">
                                                                            <div class="d-flex align-items-center p-1">
                                                                                <div class="d-flex justify-content-center align-items-center"
                                                                                    style="width: 2rem; height: 2rem;">
                                                                                    <i class="fa-solid fa-map-location-dot fa-lg"></i>
                                                                                </div>
                                                                            </div>
                                                                            <span class="fs-6 fs-md-5">{{ $contact->province ? $contact->province : 'Not available' }}</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                {{-- Contact country --}}
                                                                <div class="row">
                                                                    <div class="col d-flex justify-content-start">
                                                                        <div class="d-flex align-items-center">
                                                                            <div class="d-flex align-items-center p-1">
                                                                                <div class="d-flex justify-content-center align-items-center"
                                                                                    style="width: 2rem; height: 2rem;">
                                                                                    <i class="fa-solid fa-earth-europe fa-lg"></i>
                                                                                </div>
                                                                            </div>
                                                                            <span class="fs-6 fs-md-5">{{ $contact->country }}</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                        </div>
                                                </div>
                                            {{-- Image --}}
                                                <div class="d-flex d-md-none justify-content-start align-items-center">
                                                    <img src="{{ $contact->image ? asset('storage/' . $contact->image) : asset('images/profile1.png') }}"
                                                            alt="Profile picture">
                                                </div>
                                        </div>
                                    {{-- Separator--}}
                                        <hr>
                                    {{-- Additional info --}}
                                        <div class="additional-info d-flex justify-content-start">
                                            <div class="icon-additional-info">
                                                <div class="d-flex align-items-start p-1">
                                                    <div class="d-flex justify-content-start align-items-center"
                                                        style="width: 2rem; height: 1.4rem;">
                                                        <i class="fa-solid fa-message fa-lg"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-additional-info">
                                                <span>{{ $contact->notes ? $contact->notes : 'Additional information not available' }}</span>
                                            </div>
                                        </div>
                                </div>
                            {{-- Separator--}}
                                <hr>
                            {{-- Contact footer: control buttons --}}
                                    <div class="d-flex flex-column flex-sm-row justify-content-evenly align-items-center">
                                        {{-- Edit contact button --}}
                                        <div class="d-flex justify-content-center mt-4">
                                            @can('update', $contact)
                                                <a href="{{ route('contacts.edit', ['contact' => $contact] + request()->only(['user_id', 'sort', 'direction', 'search'])) }}" class="btn btn-primary mt-0 edit-contact">
                                                    <i class="fa-solid fa-pen-to-square mx-1"></i>
                                                    <span>Edit contact</span>
                                                </a>
                                            @else
                                                <a href="#" class="btn btn-primary mt-0 edit-contact disabled" style="opacity: 0.2; pointer-events: none;">
                                                    <i class="fa-solid fa-pen-to-square mx-1"></i>
                                                    <span>Edit contact</span>
                                                </a>
                                            @endcan
                                        </div>
                                        {{-- Back to index button --}}
                                        <div class="d-flex justify-content-center mt-4">
                                            <a href="{{ route('contacts.index', request()->query()) }}" class="btn btn-secondary mt-0 back-to-list">
                                                <i class="fa-solid fa-rotate-left mx-1"></i>
                                                <span>Back to contacts</span>
                                            </a>
                                            
                                        </div>
                                    </div>
                        </div>
                </div>
        </div>
    </div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/app/show.css') }}">
@endpush
