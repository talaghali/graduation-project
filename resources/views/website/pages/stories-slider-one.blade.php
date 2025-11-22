@extends('website.layouts.app')

@section('title', 'Stories Gallery - Voices Of Gaza')

@section('content')
    <!-- سلايدر القصص  -->
    <section class="large-stories">
        <div class="container-fluid p-0">
            <div id="carouselExample" class="carousel slide">
                <div class="carousel-inner">
                    <div class="carousel-item active" style="
                        background-image: url('{{ asset('front/img/storiesSlider1.png') }}');
                        background-size: cover;
                        background-position: center 20%;
                        background-repeat: no-repeat;">
                        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-50"></div>
                        <div class="position-absolute top-50 start-50 translate-middle text-center text-white">
                            <p class="stories-titels">A Bowl of Hope in the Ruins</p>
                        </div>
                    </div>
                </div>
                <!-- سهم يسار  -->
                <div id="prevBtn" class="carousel-control-prev" style="cursor: pointer;">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </div>

                <!-- سهم يمين -->
                <div id="nextBtn" class="carousel-control-next" style="cursor: pointer;">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </div>
            </div>
            <div class="thestory">
                <p class="d-flex justify-content-center align-items-center text-start story-padding story-text">Fatima,
                    a little Palestinian girl from Gaza, woke up before sunrise, her stomach empty for the third day.
                    She held her mother's hand tightly as they walked through destroyed streets toward a food
                    distribution point. The air smelled of smoke and dust, but hope pushed them forward — maybe today,
                    they would get a meal.
                    When they arrived, hundreds of people were already waiting, their faces pale from hunger. The noise
                    of crying children mixed with the distant sound of drones. Fatima clutched a small plastic bowl, her
                    only treasure, and waited quietly in line.
                    Suddenly, a loud explosion shook the ground. People screamed and ran in all directions. Fatima fell,
                    the bowl slipping from her hands and breaking on the ground. Her mother shouted her name, trying to
                    reach her through the chaos.
                    In the rush and fear, Fatima could barely breathe — dust filled her lungs and tears blurred her
                    vision. A stranger grabbed her arm and pulled her behind a wall just as another blast hit nearby.
                    When the smoke cleared, she found her mother, trembling but alive.
                    They didn't get any food that day. But as the sun set over the ruins, Fatima whispered, "At least
                    we're still together." Her mother hugged her tightly, knowing that surviving another day in Gaza had
                    become their only victory.
                </p>
                <hr>

                <div class="sec-m px-3 mb-5">
                    <div class="gap-2 pb-3 mt-4 explore-link">
                        <a href="#"
                            class="text-decoration-none text-dark rounded-3 d-flex justify-content-start align-items-center">
                            <i class="fa-solid fa-globe pe-2"></i>
                            Explore Stories
                        </a>
                    </div>

                    <div class="position-relative w-100" style="max-width: 580px; height: 381px;">
                        <img src="{{ asset('front/img/storiesSlider2.png') }}" class="img-fluid w-100 h-100" style="object-fit: cover;"
                            alt="story">

                        <!-- overlay داكن -->
                        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-50"></div>

                        <!-- النصوص في المنتصف -->
                        <div
                            class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-center align-items-center text-white text-center">
                            <p class="theexplore mb-1">Explore stories</p>
                            <a href="{{ route('stories.slider.two') }}"
                                class="text-decoration-none text-white stories-titels mb-0">Hind
                                Rajab and her
                                family</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    // السهم الأيمن يذهب للصفحة التالية
    document.getElementById("nextBtn").addEventListener("click", function () {
        window.location.href = "{{ route('stories.slider.two') }}";
    });

    // السهم الأيسر يذهب للصفحة السابقة
    document.getElementById("prevBtn").addEventListener("click", function () {
        window.location.href = "{{ route('stories.slider.three') }}";
    });
</script>
@endpush
