@extends('website.layouts.app')

@section('title', 'Stories - Voices Of Gaza')

@section('content')
    <div class="container-fluid p-5 ">
        <p class="mb-4 text-center red-headings pb-3">Stories</p>
        <div class="row g-4 justify-content-center align-items-center">
            <div class="col-6">
                <a class="story-link" href="{{ route('stories.eman') }}">Eman Al-Hosary</a>
            </div>
            <div class="col-6">
                <a class="story-link" href="{{ route('stories.madi') }}">Al-Madi Family</a>
            </div>
            <div class="col-6">
                <a class="story-link" href="{{ route('stories.alyan') }}">Al-Alyan Family</a>
            </div>
            <div class="col-6">
                <a class="story-link" href="{{ route('stories.sila') }}">Baby Sila Al-Faseeh</a>
            </div>
            <div class="col-6">
                <a class="story-link" href="{{ route('stories.salma') }}">Salma Al-Ajla</a>
            </div>
            <div class="col-6">
                <a class="story-link" href="{{ route('stories.journalists') }}">The Story of Journalists</a>
            </div>
            <div class="col-6">
                <a class="story-link" href="{{ route('stories.jihad') }}">Jihad Abu Amer</a>
            </div>
            <div class="col-6">
                <a class="story-link" href="{{ route('stories.sand') }}">Sand Bulbul</a>
            </div>
            <div class="col-6">
                <a class="story-link" href="{{ route('stories.malak') }}">Malak al-Qanoua</a>
            </div>
            <div class="col-6">
                <a class="story-link" href="{{ route('stories.arabeed') }}">Alaa al-Arabeed</a>
            </div>
            <div class="col-6">
                <a class="story-link" href="{{ route('stories.shaaban') }}">Shaaban Al-Dalou</a>
            </div>
            <div class="col-6">
                <a class="story-link" href="{{ route('stories.mowaddad') }}">Alaa Mowaddad</a>
            </div>
            <div class="col-6">
                <a class="story-link" href="{{ route('stories.five-journalists') }}">Five Journalists from Gaza Strip</a>
            </div>
            <div class="col-6">
                <a class="story-link" href="{{ route('stories.unrwa') }}">UNRWA Clinic Story</a>
            </div>
            <div class="col-12">
                <a class="story-link" href="{{ route('stories.saif') }}">Saif Abu Warda</a>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .red-headings {
            color: #b70003 !important;
        }

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
        }
    </style>
@endpush
