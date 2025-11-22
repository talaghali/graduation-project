@extends('website.layouts.app')

@section('title', 'About - Voices Of Gaza')

@section('content')
    <div class="container-fluid p-5">
        <div class=" d-flex justify-content-center align-items-center flex-column">
            <h4 class="text-white" style="font-size: 35px;">Voices Of Gaza</h4>
            <p class="text-white text-center" style="max-width: 973px; font-size: 23px;">Voices Of Gaza is a digital
                memorial
                preserving the stories of
                those
                affected by
                conflict. It honors the lives of children, families, journalists, doctors, and
                countless others whose voices were silenced.Through these stories, we remember
                their resilience and ensure their memories live on.</p>
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
