@extends('website.layouts.app')

@section('title', 'Stories Gallery - Voices Of Gaza')

@section('content')
    <!-- سلايدر القصص  -->
    <section class="large-stories">
        <div class="container-fluid p-0">
            <div id="carouselExample" class="carousel slide">
                <div class="carousel-inner">
                    <div class="carousel-item active" style="
                        background-image: url('{{ asset('front/img/storiesSlider3.png') }}');
                        background-size: cover;
                        background-position: center 40%;
                        background-repeat: no-repeat;">
                        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-50"></div>
                        <div class="position-absolute top-50 start-50 translate-middle text-center text-white">
                            <p class="stories-titels">"The Story of the Young Man Mohammed Bahar"</p>
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
                <p class="d-flex justify-content-center align-items-center text-start story-padding story-text">
                    "A young man with Down syndrome and autism is attacked by dogs."
                    He was a 24-year-old Palestinian young man who had Down syndrome. His mother says that later in his
                    life, he also developed autism, which made his health condition even more complicated.
                    His mother used to change his clothes and clean him. He could hardly eat or drink except from her
                    hand, and he could not move without the help of his family members.
                    On July 3rd, Israeli occupation forces raided his family's home in Gaza after many days of intense
                    bombing across the area.
                    His mother recounts that the family members had gathered in a small house, afraid of the soldiers'
                    gunfire, while Mohammed remained in the living room — unable to run or escape.
                    Soon, a military dog trained to kill stormed into the house and began tearing apart Mohammed's body
                    — the young man who had Down syndrome and autism. As he was being attacked, he pleaded softly, "It's
                    okay, my dear, it's okay," while blood filled the chair he was sitting on.
                    The grieving mother was prevented by the Israeli soldiers from rescuing her son. They told her that
                    they had brought a military doctor to help him. She begged them to give him some water, having heard
                    his faint, desperate voice asking for a drink. They reassured her that he had already drunk and was
                    resting.
                    Soon after, Mohammed's weak voice from the living room fell silent. One of the soldiers coldly said
                    to her, "Mohammed, that's it." And the soldier was not lying — Mohammed had indeed found rest, as he
                    joined his martyred father in death.
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
                        <img src="{{ asset('front/img/storiesSlider1.png') }}" class="img-fluid w-100 h-100" style="object-fit: cover;"
                            alt="story">

                        <!-- overlay داكن -->
                        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-50"></div>

                        <!-- النصوص في المنتصف -->
                        <div
                            class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-center align-items-center text-white text-center">
                            <p class="theexplore mb-1">Explore stories</p>
                            <a href="{{ route('stories.slider.one') }}"
                                class="text-decoration-none text-white stories-titels mb-0">hungry children
                            </a>
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
        window.location.href = "{{ route('stories.slider.one') }}";
    });

    // السهم الأيسر يذهب للصفحة السابقة
    document.getElementById("prevBtn").addEventListener("click", function () {
        window.location.href = "{{ route('stories.slider.two') }}";
    });
</script>
@endpush
