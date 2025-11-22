@extends('website.layouts.app')

@section('title', 'All Stories - Voices Of Gaza')

@section('content')
    <!-- Hero Section -->
    <section class="hero">
        <div class="container-fluid p-0">
            <div id="carouselFade" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="2500">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{ asset('front/img/hero1.png') }}" class="d-block w-100" alt="Gaza WAR" />
                        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-50"></div>
                        <div class="position-absolute top-50 start-50 translate-middle text-center text-white">
                            <p class="main-text text-start">Events and stories</p>
                            <p class="main-headings">GAZA WAR 2023-2025</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('front/img/hero2.png') }}" class="d-block w-100" alt="Gaza WAR" />
                        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-50"></div>
                        <div class="position-absolute top-50 start-50 translate-middle text-center text-white">
                            <p class="main-text text-start">Events and stories</p>
                            <p class="main-headings">GAZA WAR 2023-2025</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('front/img/hero3.png') }}" class="d-block w-100" alt="Gaza WAR" />
                        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-50"></div>
                        <div class="position-absolute top-50 start-50 translate-middle text-center text-white">
                            <p class="main-text text-start">Events and stories</p>
                            <p class="main-headings">GAZA WAR 2023-2025</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stories Section -->
    <div class="mt-5">
        <p class="text-center d-flex align-items-center justify-content-center" style="font-size: 30px;">See All Stories</p>
    </div>

    <section class="mt-5 heart-gaza section-maxwidth">
        <div class="container-fluid">
            <div class="d-flex justify-content-center stories-text pt-3 text-center pb-4">
                <p class="main-text">
                    "These clips capture moments from Gaza — voices, images, and live
                    scenes that reflect life and resilience. Here you'll witness what
                    words alone cannot express."
                </p>
            </div>

            @if($stories->count() > 0)
                <div class="row g-4">
                    @foreach($stories as $index => $story)
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="card h-100 shadow-sm border-0">
                                <div class="position-relative">
                                    @if($story->media_path && $story->media_type === 'image')
                                        <img src="{{ asset('storage/' . $story->media_path) }}"
                                             class="card-img-top"
                                             alt="{{ $story->title }}"
                                             style="height: 300px; object-fit: cover;">
                                    @else
                                        <img src="{{ asset('front/img/logo f.png') }}"
                                             class="card-img-top"
                                             alt="{{ $story->title }}"
                                             style="height: 300px; object-fit: cover;">
                                    @endif
                                    <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark" style="opacity: 0.25"></div>

                                    <!-- Read Story Button -->
                                    <div class="position-absolute bottom-0 start-50 translate-middle-x mb-3 text-center">
                                        <a href="{{ route('stories.show', $story->id) }}" class="btn read-btn text-decoration-none">
                                            <i class="bi bi-eye"></i> Read Story
                                        </a>
                                    </div>
                                </div>

                                <div class="card-body text-center">
                                    <h5 class="pic-titels">{{ $story->name ?? $story->title }}</h5>

                                    @if($story->location)
                                        <p class="text-muted small">
                                            <i class="bi bi-geo-alt-fill"></i> {{ $story->location }}
                                        </p>
                                    @endif

                                    @if($story->story_type)
                                        <span class="badge bg-secondary mb-2">{{ $story->story_type }}</span>
                                    @endif

                                    <p class="stories-text">
                                        {{ Str::limit(strip_tags($story->content), 100) }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        @if(($index + 1) % 6 === 0 && $index + 1 < $stories->count())
                            <div class="col-12">
                                <hr class="my-5" />
                                <div class="d-flex justify-content-center">
                                    <p class="stories-text text-center">
                                        "Every story here carries a piece of the truth people have lived.
                                        Tales of loss, hope, resilience, and love despite pain. We share
                                        them to give a voice to every experience that deserves to be
                                        remembered, and to keep the memory alive for the world."
                                    </p>
                                </div>
                                <hr class="my-5" />
                            </div>
                        @endif
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-5">
                    {{ $stories->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <p class="main-text">No stories available yet.</p>
                    <p class="stories-text">Be the first to share your story.</p>
                    <a href="{{ route('share') }}" class="btn btn-primary mt-3">Share Your Story</a>
                </div>
            @endif
        </div>
    </section>
@endsection
