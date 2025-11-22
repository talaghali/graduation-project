@extends('website.layouts.app')

@section('title', $story->title . ' - Voices Of Gaza')

@section('content')
    <!-- Story Header -->
    <section class="py-5" style="background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <!-- Story Title -->
                    <div class="text-center text-white mb-4">
                        @if($story->story_type)
                            <span class="badge bg-danger mb-3">{{ $story->story_type }}</span>
                        @endif
                        <h1 class="display-4 fw-bold mb-3">{{ $story->title }}</h1>

                        @if($story->name)
                            <h2 class="h3 fw-normal mb-3">{{ $story->name }}</h2>
                        @endif

                        <div class="d-flex justify-content-center align-items-center gap-4 flex-wrap">
                            @if($story->location)
                                <span class="text-white-50">
                                    <i class="bi bi-geo-alt-fill me-2"></i>{{ $story->location }}
                                </span>
                            @endif

                            @if($story->age)
                                <span class="text-white-50">
                                    <i class="bi bi-person-fill me-2"></i>Age: {{ $story->age }}
                                </span>
                            @endif

                            <span class="text-white-50">
                                <i class="bi bi-calendar-fill me-2"></i>{{ $story->created_at->format('F d, Y') }}
                            </span>
                        </div>
                    </div>

                    <!-- Story Media -->
                    @if($story->media_path)
                        <div class="my-5">
                            @if($story->media_type === 'image')
                                <img src="{{ asset('storage/' . $story->media_path) }}"
                                     alt="{{ $story->title }}"
                                     class="img-fluid w-100 rounded shadow-lg"
                                     style="max-height: 600px; object-fit: cover;">
                            @elseif($story->media_type === 'video')
                                <video controls class="w-100 rounded shadow-lg" style="max-height: 600px;">
                                    <source src="{{ asset('storage/' . $story->media_path) }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Story Content -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-5">
                            <!-- Story Content with HTML formatting -->
                            <div class="story-content">
                                {!! $story->content !!}
                            </div>

                            <!-- Share Section -->
                            <hr class="my-5">
                            <div class="text-center">
                                <h4 class="mb-3">Share This Story</h4>
                                <div class="d-flex justify-content-center gap-3">
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('stories.show', $story->id)) }}"
                                       target="_blank"
                                       class="btn btn-outline-primary">
                                        <i class="bi bi-facebook"></i> Facebook
                                    </a>
                                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('stories.show', $story->id)) }}&text={{ urlencode($story->title) }}"
                                       target="_blank"
                                       class="btn btn-outline-info">
                                        <i class="bi bi-twitter"></i> Twitter
                                    </a>
                                    <a href="https://wa.me/?text={{ urlencode($story->title . ' - ' . route('stories.show', $story->id)) }}"
                                       target="_blank"
                                       class="btn btn-outline-success">
                                        <i class="bi bi-whatsapp"></i> WhatsApp
                                    </a>
                                </div>
                            </div>

                            <!-- Back to Stories -->
                            <div class="text-center mt-5">
                                <a href="{{ route('stories.index') }}" class="btn btn-lg btn-dark">
                                    <i class="bi bi-arrow-left me-2"></i>Back to All Stories
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-5 text-center" style="background: linear-gradient(135deg, #b70003 0%, #8b0002 100%);">
        <div class="container">
            <h3 class="text-white mb-3">Have a Story to Share?</h3>
            <p class="text-white mb-4">Your voice matters. Share your story with the world.</p>
            <a href="{{ route('share') }}" class="btn btn-light btn-lg">
                <i class="bi bi-pencil-fill me-2"></i>Share Your Story
            </a>
        </div>
    </section>
@endsection

@push('styles')
<style>
    .story-content {
        font-size: 1.1rem;
        line-height: 1.8;
        color: #333;
    }

    .story-content p {
        margin-bottom: 1.5rem;
    }

    .story-content strong {
        color: #000;
        font-weight: 600;
    }

    .story-content .lead {
        font-size: 1.3rem;
        font-weight: 500;
        color: #1a1a1a;
    }

    .story-content ul {
        padding-left: 1.5rem;
    }

    .story-content .text-muted {
        color: #6c757d !important;
    }

    .story-content .bg-light {
        background-color: #f8f9fa !important;
    }

    .story-content .bg-dark {
        background-color: #343a40 !important;
    }

    .story-content .border-start {
        border-left: 4px solid !important;
    }

    .story-content .border-danger {
        border-color: #dc3545 !important;
    }

    .story-content .border-primary {
        border-color: #0d6efd !important;
    }
</style>
@endpush
