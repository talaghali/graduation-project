@extends('website.layouts.app')

@section('title', 'Stories Gallery - Voices Of Gaza')

@section('content')
    <!-- سلايدر القصص  -->
    <section class="large-stories">
        <div class="container-fluid p-0">
            <div id="carouselExample" class="carousel slide">
                <div class="carousel-inner">
                    <div class="carousel-item active" style="
                        background-image: url('{{ asset('front/img/storiesSlider2.png') }}');
                        background-size: cover;
                        background-position: center 20%;
                        background-repeat: no-repeat;">
                        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-50"></div>
                        <div class="position-absolute top-50 start-50 translate-middle text-center text-white">
                            <p class="stories-titels">Hind Rajab and her family were killed by occupation tanks in the
                                Tel al-Hawa neighborhood of Gaza in January 2024 (Reuters).</p>
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
                <p class="d-flex justify-content-center align-items-center text-start story-padding story-text">The
                    story of the little girl Hind
                    Hind Rajab and her family were killed by occupation tanks in the Tel al-Hawa neighborhood of Gaza in
                    January 2024 (Reuters).
                    A beautiful face radiating innocence, with skin bronzed by the sun of Gaza and glowing like a
                    shining star — this was the Palestinian girl Hind Rajab. She was cold-bloodedly killed along with
                    her family and several paramedics by the Israeli occupation forces, after being the only survivor of
                    Israeli tank fire that struck the car she was escaping in with six of her relatives in January 2024,
                    as they tried to flee to a safer place in Gaza City. They were surrounded by several tanks that
                    directly targeted them.
                    Hind cries for help.
                    The little girl Hind called her mother, pleading and begging her to come and rescue her from inside
                    the car that was being fired upon by Israeli tank machine guns. Shortly after, the Palestinian Red
                    Crescent received a call from Layan Hamada, Hind's relative who was with her, asking desperately for
                    help.
                    Layan Hamada reported that an Israeli tank opened fire on their car in the "Al-Maliya roundabout"
                    area of the Tel al-Hawa neighborhood (southwest of Gaza City). During the phone call, Layan's
                    screams could be heard along with the sound of heavy gunfire — then the call suddenly ended.
                    The Palestinian Red Crescent later released an audio recording in which Layan's voice can be heard
                    as she tried to describe what was happening around her, saying:
                    "Uncle, they're shooting at us! The tank is right next to us. We're in the car, and the tank is
                    beside us!"
                    Moments later, a barrage of gunfire is heard as Layan screams — and the connection is cut off.
                    After that, members of the Palestinian Red Crescent tried to reconnect and discovered that Hind was
                    still alive. Her family kept in touch with her, trying to calm her down and reassure her that an
                    ambulance was on its way to rescue her from the site.
                    In a desperate and time-sensitive mission that seemed nearly impossible, a Red Crescent rescue team
                    set out — in coordination with the Palestinian liaison — to save her. However, contact with the team
                    was lost just a few hours after they began their mission to reach Hind. Twelve days passed.
                    In February, after Israeli forces withdrew from the area where Hind's car had been stopped, her body
                    and those of her family members were found inside the vehicle near the "Al-Maliya roundabout" in the
                    Tel al-Hawa neighborhood. Her relatives had been killed instantly, and just a few meters away, the
                    bodies of the paramedics who had rushed to rescue her were also discovered.
                    According to an investigation by The Washington Post, which used satellite imagery, four Israeli
                    military vehicles were located less than 300 meters from the spot where Hind and her family were
                    found — within clear line of sight.
                    According to the same investigation, the ammunition that struck both the family's car and the
                    ambulance matched the type used by the Israeli military. Experts and weapons specialists consulted
                    by the newspaper confirmed that an analysis of the phone call revealed the family's car was hit by
                    approximately 72 bullets within six seconds during the time the child was on the line.
                    A report by Forensic Architecture, published in April 2024, stated that the family's car had been
                    fired upon by an Israeli tank, whose crew had a clear line of sight to the vehicle and its occupants
                    — including Hind.
                    The report also indicated that the Red Crescent rescue team, which rushed to save Hind, was itself
                    struck and hit by fire from another Israeli tank.
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
                        <img src="{{ asset('front/img/storiesSlider3.png') }}" class="img-fluid w-100 h-100" style="object-fit: cover;"
                            alt="story">

                        <!-- overlay داكن -->
                        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-50"></div>

                        <!-- النصوص في المنتصف -->
                        <div
                            class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-center align-items-center text-white text-center">
                            <p class="theexplore mb-1">Explore stories</p>
                            <a href="{{ route('stories.slider.three') }}"
                                class="text-decoration-none text-white stories-titels mb-0">Mohammed Bahar
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
        window.location.href = "{{ route('stories.slider.three') }}";
    });

    // السهم الأيسر يذهب للصفحة السابقة
    document.getElementById("prevBtn").addEventListener("click", function () {
        window.location.href = "{{ route('stories.slider.one') }}";
    });
</script>
@endpush
