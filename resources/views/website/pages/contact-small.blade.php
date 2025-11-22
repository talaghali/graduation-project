@extends('website.layouts.app')

@section('title', 'Contact - Voices Of Gaza')

@section('content')
    <div class="container-fluid p-5">
        <div class=" d-flex justify-content-center align-items-center flex-column">
            <h4 class="text-white" style="font-size: 35px;"> Contact Us </h4>
            <p class="text-white text-center" style="max-width: 973px; font-size: 25px;">Have a story to share?
                Need more information? Reach out to us via email or through our social media
                channels — we'd love to hear from you.</p>
            <div>
                <a href="#" class="fw-bold text-white text-decoration-none"><i
                        class="bi bi-envelope text-white fw-bold pe-2"></i>Email:
                    info@gazamuseum.org
                </a>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .story-link {
            text-decoration: none;
            color: #ffffff;
            text-align: center;
            transition: all 0.2s ease-in-out;
        }

        .story-link:hover {
            color: #b70003;
        }

        body {
            background-color: #3C3B39;
            height: 100%;
        }
    </style>
@endpush
