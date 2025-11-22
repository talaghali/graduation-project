@extends('website.layouts.app')

@section('title', 'Voices Of Gaza')

@section('content')
    <!--hero section  بداية سكشن جديد  -->

    <!-- hero section القسم الأول والرئيسي -->
    <section class="hero">
        <div class="container-fluid p-0">
            <div id="carouselFade" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="2500">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{ asset('front/img/hero1.png') }}" class="d-block w-100" alt="Gaza WAR" />
                        <!-- overlay داكن فوق الهيرو سكشن  -->
                        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-50"></div>
                        <!-- النص الخاص بالهيرو سكشن  -->
                        <div class="position-absolute top-50 start-50 translate-middle text-center text-white">
                            <p class="main-text text-start">Events and stories</p>
                            <p class="main-headings">GAZA WAR 2023-2025</p>
                        </div>
                    </div>

                    <div class="carousel-item">
                        <img src="{{ asset('front/img/hero2.png') }}" class="d-block w-100" alt="Gaza WAR" />
                        <!-- overlay داكن فوق الهيرو سكشن  -->
                        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-50"></div>
                        <!-- النص الخاص بالهيرو سكشن  -->
                        <div class="position-absolute top-50 start-50 translate-middle text-center text-white">
                            <p class="main-text text-start">Events and stories</p>
                            <p class="main-headings">GAZA WAR 2023-2025</p>
                        </div>
                    </div>

                    <div class="carousel-item">
                        <img src="{{ asset('front/img/hero3.png') }}" class="d-block w-100" alt="Gaza WAR" />
                        <!-- overlay داكن فوق الهيرو سكشن  -->
                        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-50"></div>
                        <!--النص الخاص بالهيرو سكشن  -->
                        <div class="position-absolute top-50 start-50 translate-middle text-center text-white">
                            <p class="main-text text-start">Events and stories</p>
                            <p class="main-headings">GAZA WAR 2023-2025</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--  hero section النص أسفل  -->
    <section class="section-maxwidth caption-underhero" data-aos="fade-up" data-aos-duration="1500">
        <div class="container-fluid">
            <div class="d-flex justify-content-center align-items-center text-center pt-5">
                <p class="text-underhero ">
                    Welcome to Voices of Gaza – an interactive digital archive that documents the untold stories of
                    resilience, struggle, and hope. Explore photos, videos, audio recordings, and personal stories
                    shared by people who lived through the events.
                </p>
            </div>
            <!-- share+donate أزرار المشاركة والتبرع -->
            <div class="d-flex justify-content-center gap-2 pb-5">
                <a href="{{ route('share') }}"
                    class="text-decoration-none btns-hero text-white rounded-3 d-flex justify-content-center align-items-center">
                    <i class="bi bi-plus-circle pe-2" width="30px" height="30px"></i>
                    Share your story
                </a>
                <a href="{{ route('donate') }}"
                    class="text-decoration-none btns-hero text-white rounded-3 d-flex justify-content-center align-items-center">
                    <i class="fa-solid fa-circle-dollar-to-slot pe-2" width="30px" height="30px"></i>
                    Donate
                </a>
            </div>
        </div>
    </section>
    <!-- Gaza شريط  -->
    <section class="pt-5 pb-5 gaza-bar">
        <div class="container-fluid p-0 position-relative">
            <!-- صورة الخلفية لشريط غزة  -->
            <div class="gaza-background"></div>
            <img src="{{ asset('front/img/gazabar.png') }}" class="img-fluid w-100 position-absolute top-50 start-50 translate-middle"
                alt="Gaza WAR" />
            <!-- المحتوي فوق الصورة الخاصة بشريط غزة  -->
            <div
                class="position-absolute top-50 start-50 translate-middle w-100 d-flex justify-content-center gazabar-gap">
                <div class="bar-content">
                    <div class="text-white d-flex align-items-center gap-1">
                        <span class="numbers">2500</span>
                        <span><i class="fa-solid fa-plus"></i></span>
                    </div>
                    <p class="text-white under-number">Stories Shared</p>
                </div>
                <div class="bar-content">
                    <div class="text-white d-flex align-items-center gap-1">
                        <span class="numbers">8,000</span>
                        <span><i class="fa-solid fa-plus"></i></span>
                    </div>
                    <p class="text-white under-number">Photos & Videos Uploaded</p>
                </div>
                <div class="bar-content">
                    <div class="text-white d-flex align-items-center gap-1">
                        <span class="numbers">1,200</span>
                        <span><i class="fa-solid fa-plus"></i></span>
                    </div>
                    <p class="text-white under-number">Audio Testimonies</p>
                </div>
                <div class="bar-content">
                    <div class="text-white d-flex align-items-center gap-1">
                        <span class="numbers">100</span>
                        <span><i class="fa-solid fa-plus"></i></span>
                    </div>
                    <p class="text-white under-number">Contributors from Gaza</p>
                </div>
            </div>
        </div>
    </section>

    <!-- سكشن قصصنا Small Slider -->
    <section class="mt-5 our-stories-section section-maxwidth  ">
        <div class="container-fluid px-0 ">
            <!--grid هنا قسمنا السكشن باستخدام   -->
            <div class="row justify-content-center align-items-center g-0">
                <!-- القسم الايسر الي فيه النص و(العنوان ونص وزر تصفح ) -->
                <div class="col-12 col-md-6 px-2">
                    <div>
                        <div class="leftSide" data-aos="fade-left" data-aos-duration="1500">
                            <p class="sub-headings text-center">OUR STORIES</p>
                            <p class="main-text pt-4  px-lg-5">
                                Every story matters. From daily life under siege to moments of
                                resilience and hope, these are the voices of Gaza. Through
                                photos, videos, and personal testimonies, you will discover
                                the human side of events that shaped our collective memory.
                            </p>
                            <!--  Explore زر  -->
                            <div class="d-flex justify-content-center gap-2 pb-2">
                                <a href="{{ route('stories.slider.one') }}"
                                    class="text-decoration-none explore-btn text-white rounded-3 d-flex justify-content-center align-items-center mt-3">
                                    <i class="fa-solid fa-globe pe-2" width="30px" height="30px"></i>
                                    Explore Stories
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- القسم الايمن عبارة عن سلايدر صور مع نص  -->
                <div class="col-12 col-md-6 stories-slider rightSide" data-aos="fade-right" data-aos-duration="1500">
                    <div id="carouselExampleCaptions" class="carousel slide">
                        <!-- مؤشرات الشرائح -->
                        <div class="carousel-indicators">
                            <!--  الشرائح الي أسفل الصورة التي تسمح بالتنقل بين الصور  وهم 3 -->
                            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0"
                                class="active" aria-current="true" aria-label="Slide 1"></button>
                            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
                                aria-label="Slide 2"></button>
                            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
                                aria-label="Slide 3"></button>
                        </div>
                        <!-- يحتوي على كل الشرائح  السلايدرات التي تتبدل داخل الكاروسيل -->
                        <div class="carousel-inner stories-inner">
                            <!-- الصورة الأولى -->
                            <div class="carousel-item stories-item active position-relative">
                                <img src="{{ asset('front/img/storiesSlider1.png') }}" class="d-block w-100 img-fluid" alt="stories" />
                                <!-- overlay -->
                                <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-50"></div>

                                <!-- النص -->
                                <div
                                    class="carousel-caption text-white top-0 start-0 d-flex justify-content-center align-items-center text-start">
                                    <div>
                                        <p class="img-text m-0">Explore stories</p>
                                        <p class="pic-titels m-0">hungry children</p>
                                    </div>
                                </div>


                            </div>

                            <!-- الصورة الثانية -->
                            <div class="carousel-item stories-item position-relative">
                                <img src="{{ asset('front/img/storiesSlider2.png') }}" class="d-block w-100 img-fluid" alt="..." />
                                <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-50"></div>
                                <!-- النص -->
                                <div
                                    class="carousel-caption text-white top-0 start-0 d-flex justify-content-center align-items-center flex-column text-start">
                                    <div>
                                        <p class="img-text m-0">Explore stories</p>
                                        <p class="pic-titels m-0"> Hind Rajab and her family</p>
                                    </div>
                                </div>
                            </div>

                            <!-- الصورة الثالثة -->
                            <div class="carousel-item stories-item position-relative">
                                <img src="{{ asset('front/img/storiesSlider3.png') }}" class="d-block w-100 img-fluid" alt="..." />
                                <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-50"></div>

                                <!-- النص -->
                                <div
                                    class="carousel-caption text-white top-0 start-0 d-flex justify-content-center align-items-center flex-column text-start">
                                    <div>
                                        <p class="img-text m-0">Explore stories</p>
                                        <p class="pic-titels m-0"> Mohammed Bahar</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- الاسهم على جانبي الصور  -->
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- نهاية سكشن قصصنا  -->

    <!-- سكشن من قلب غزة اليداية   -->
    <section class="mt-5 heart-gaza section-maxwidth">
        <div class="container-fluid">
            <div class="row justify-content-between align-items-center">
                <div class="col-6">
                    <span class="red-headings">Stories </span>
                    <span class="sub-headings">from the Heart of Gaza</span>
                </div>
                <div class="col-6 d-flex justify-content-end">
                    <div class="d-flex align-items-center gap-3">
                        <div>
                            <a class="text-decoration-none see-all" href="{{ route('seeall') }}">See all</a>
                        </div>
                        <div><i class="fa-solid fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center stories-text pt-3 text-center pb-4" data-aos="fade-up"
                data-aos-duration="1000">
                <p class="main-text">
                    "These clips capture moments from Gaza — voices, images, and live
                    scenes that reflect life and resilience. Here you'll witness what
                    words alone cannot express."
                </p>
            </div>
            @if($stories && $stories->count() > 0)
                <div class="row g-4">
                    @foreach($stories as $index => $story)
                        <div class="col-12 col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 300 }}">
                            <div class="position-relative">
                                @if($story->media_path && $story->media_type === 'image')
                                    <img class="img-fluid w-100" src="{{ asset('storage/' . $story->media_path) }}" alt="{{ $story->title }}"
                                        style="height: 400px; object-fit: cover;" />
                                @else
                                    <img class="img-fluid w-100" src="{{ asset('front/img/logo f.png') }}" alt="{{ $story->title }}"
                                        style="height: 400px; object-fit: cover;" />
                                @endif
                                <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark" style="opacity: 0.25"></div>

                                <div class="position-absolute bottom-0 start-50 translate-middle-x mb-3 text-center">
                                    <button class="btn read-btn">
                                        <a href="{{ route('stories.show', $story->id) }}" class="text-decoration-none">
                                            <i class="bi bi-eye"></i>
                                            Read Story
                                        </a>
                                    </button>
                                </div>
                            </div>
                            <div class="pt-3 d-flex justify-content-center">
                                <p class="pic-titels">{{ $story->name ?? $story->title }}</p>
                            </div>
                            <div class="d-flex justify-content-center text-center">
                                <p class="stories-text">
                                    {{ Str::limit(strip_tags($story->content), 80) }}
                                </p>
                            </div>
                        </div>

                        @if($index === 0)
                            <div class="col-12">
                                <hr class="hr-width">
                                <div class="d-flex justify-content-center">
                                    <p class="stories-text text-center pt-5">
                                        "Every story here carries a piece of the truth people have lived.
                                        Tales of loss, hope, resilience, and love despite pain. We share
                                        them to give a voice to every experience that deserves to be
                                        remembered, and to keep the memory alive for the world. Explore
                                        the stories, or become the storyteller yourself—your story might
                                        inspire others."
                                    </p>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <p class="main-text">No stories available yet.</p>
                </div>
            @endif
            <hr />
        </div>
    </section>
    <!-- نهاية سكشن قصص من قلب غزة  -->

    <!-- سكشن مشاركة قصة الكبير  -->
    <section class="mt-5 mb-5 share-section" data-aos="zoom-in" data-aos-duration="2000">
        <div class="container-fluid p-0">
            <div class="share-wrapper d-flex justify-content-center align-items-center position-relative">
                <!-- الخلفية -->
                <img src="{{ asset('front/img/share.png') }}" alt="" class="w-100 img-fluid h-100 object-fit-cover">

                <!-- الطبقة الداكنة -->
                <div class="overlay position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-50"></div>

                <!-- المحتوى -->
                <div class="share-content text-center text-white position-absolute ">
                    <p class="main-headings">Share Your Story</p>
                    <p class="main-text text-center pt-3 mb-lg-5" style="max-width: 534px;">
                        Your story tells resilience and gives voice to those who lived it.
                    </p>
                    <hr style="max-width: 534px; margin: 20px auto;">
                    <div class="d-flex justify-content-center align-items-center">
                        <a href="{{ route('share') }}"
                            class="text-decoration-none share-section-btn text-white rounded-3 d-flex justify-content-center align-items-center px-4 py-2">
                            <i class="bi bi-plus-circle pe-2"></i>
                            Share your story
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <hr style="max-width: 1140px; margin: auto;">

        <!--هايلايت غزة  بداية سكشن جديد شاشات كبيرة  -->
    @if($highlights && $highlights->count() > 0)
    <section class="highlight section-maxwidth mt-5 d-none d-md-block">
        <div class="container-fluid">
            <span class="sub-headings">Highlight</span><span class="red-headings">Videos </span>
            <span class="sub-headings">from Gaza</span>
            <p class="main-text pt-3 text-center mb-4" data-aos="fade-up" data-aos-duration="1500">
                "This collection features the most significant videos documenting events in Gaza from 2023 to the
                present,
                capturing moments of resilience, human experiences, and the daily challenges faced by our people. Watch
                these
                real stories that showcase strength and courage in the toughest times."
            </p>

            <!-- حاوية السلايدر -->
            <div id="highlightCarousel" class="carousel slide" data-bs-ride="false" data-bs-interval="false">
                <div class="carousel-inner">
                    @foreach($highlights->chunk(3) as $chunk_index => $chunk)
                    <div class="carousel-item {{ $chunk_index == 0 ? 'active' : '' }}">
                        <div class="d-flex gap-3 justify-content-center">
                            @foreach($chunk as $highlight)
                            <div class="position-relative card-hover" style="width: 367px; height: 409px;">
                                <img src="{{ $highlight->thumbnail_url }}" alt="{{ $highlight->title }}" class="img-fluid w-100 h-100 object-fit-cover">
                                <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark" style="opacity: 0.6;"></div>
                                
                                <div class="card-content position-absolute d-flex justify-content-center w-100 text-center" style="top: 10%;">
                                    <p class="text-white highlight-fs mt-5 mb-5 px-lg-5">
                                        {{ Str::limit($highlight->title, 50) }}
                                    </p>
                                </div>
                                
                                <div class="card-content position-absolute w-100 d-flex justify-content-center text-center" style="bottom: 10%;">
                                    <a href="#" class="btn btn-light watch-btn border-0">
                                        Watch Now
                                        <i class="bi bi-caret-right"></i>
                                    </a>
                                </div>

                                <a href="{{ $highlight->video_type === 'local' ? asset('storage/' . $highlight->video_url) : $highlight->video_url }}" target="_blank"
                                    class="hover-text position-absolute top-50 start-50 translate-middle text-white watch-circle">
                                    <i class="bi bi-caret-right"></i>
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- الأسهم -->
                @if($highlights->count() > 3)
                <div class="mb-5 pt-5">
                    <button class="carousel-control-prev" type="button" data-bs-target="#highlightCarousel"
                        data-bs-slide="prev" id="prevBtn">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">السابق</span>
                    </button>

                    <button class="carousel-control-next" type="button" data-bs-target="#highlightCarousel"
                        data-bs-slide="next" id="nextBtn">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">التالي</span>
                    </button>
                </div>
                @endif

            </div>
            <hr style="max-width: 1140px; margin: auto;">
        </div>
    </section>

    <!-- هايلايت نسخة للشاشات الصغيرة -->
    <section class="highlight-small d-block d-md-none mb-5">
        <div class="container-fluid">
            <span class="sub-headings">Highlight </span><span class="red-headings">Videos </span><span
                class="sub-headings">from Gaza</span>
            <p class="main-text pt-3 text-center mb-4">
                "This collection features the most significant videos documenting events in Gaza from 2023 to the
                present,
                capturing moments of resilience, human experiences, and the daily challenges faced by our people."
            </p>

            <div id="smallHighlightCarousel" class="carousel slide">
                <div class="carousel-inner">
                    @foreach($highlights as $index => $highlight)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                        <div class="card-hover position-relative" style="width: 100%; height: 300px;">
                            <img src="{{ $highlight->thumbnail_url }}" class="img-fluid w-100 h-100 object-fit-cover" alt="{{ $highlight->title }}">
                            <div class="position-absolute top-0 start-0 w-100 overlay-h bg-dark" style="opacity: 0.6;"></div>
                            <div class="card-content position-absolute text-center" style="top: 10%; width: 100%;">
                                <p class="text-white highlight-fs mt-5 mb-5">{{ Str::limit($highlight->title, 50) }}</p>
                            </div>
                            <div class="position-absolute w-100 d-flex justify-content-center" style="bottom: 10%;">
                                <a href="{{ $highlight->video_type === 'local' ? asset('storage/' . $highlight->video_url) : $highlight->video_url }}" target="_blank"
                                    class="btn btn-light watch-btn border-0">
                                    Watch Now <i class="bi bi-caret-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- الأسهم -->
                @if($highlights->count() > 1)
                <button class="carousel-control-prev" type="button" data-bs-target="#smallHighlightCarousel"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#smallHighlightCarousel"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
                @endif
            </div>
        </div>
    </section>
    @endif

<!-- سكشن جدير  التبرع   -->
    <section class="donate mt-4" data-aos="fade-up" data-aos-duration="1500">
        <div class="container-fluid p-0">
            <div class="donate-background">
                <div
                    class="donate-content d-flex justify-content-center align-items-center flex-column py-3 text-white ">
                    <p class="pt-5">STORIES&VIDEOS</p>
                    <p class="donate-num">2500</p>
                    <p class="main-text text-center pb-5">"Here you will find the truth — the real stories of Gaza and
                        the
                        suffering of its
                        people. Share hope and
                        make a difference; every donation helps ease the pain and build a better tomorrow."</p>
                    <div class="pb-4">
                        <a href="{{ route('donate') }}"
                            class="text-decoration-none donate-section-btn text-dark rounded-3 d-flex justify-content-center align-items-center ">
                            <i class="fa-solid fa-circle-dollar-to-slot pe-2" width="30px" height="30px"></i>
                            Donate
                        </a>
                    </div>

                </div>
            </div>
            <hr>
        </div>
    </section>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
    AOS.init();
</script>

<!-- سكربت جافا خاص بحركة الهيرو سكشن التنقل التلقائي الناعم  -->
<script>
    window.addEventListener("DOMContentLoaded", () => {
        const slides = document.querySelectorAll(".fade-slide");

        // Only run if fade-slide elements exist
        if (slides.length > 0) {
            let index = 0;

            slides[index].classList.add("active");

            setInterval(() => {
                const current = slides[index];
                index = (index + 1) % slides.length;
                const next = slides[index];

                next.style.zIndex = 3;
                next.classList.add("active");

                setTimeout(() => {
                    current.classList.remove("active");
                    current.style.zIndex = 1;
                    next.style.zIndex = 2;
                }, 1000);
            }, 2000);
        }
    });
</script>
@endpush
