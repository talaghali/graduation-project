<footer>
    <div class="container-fluid p-0">
        <div class="footer-background">
            <div class="p-4">
                <div class="footer-content d-flex justify-content-start footer-padding flex-column text-white">
                    <a class="navbar-brand text-white pb-3 pt-3" href="{{ route('index') }}">
                        <img src="{{ asset('front/img/logo f.png') }}" alt="logo" style="width:125px; height:76px;">
                    </a>
                    <p class="footer-p">
                        "A digital platform that documents the stories and struggles of the people of Gaza —
                        through voice, image, and word — to remain a witness to the truth."
                    </p>
                    <div class="row mt-5 mobile-flex">
                        <div class="col-6">
                            <div class="row gap-sm-5 list-flex">
                                <div class="col-2">
                                    <a href="{{ route('about.small') }}" class="d-block mb-3 text-decoration-none text-white">About</a>
                                    <a href="{{ route('stories.small') }}" class="d-block mb-3 text-decoration-none text-white">Stories</a>
                                    <a href="#" class="d-block mb-3 text-decoration-none text-white">Videos</a>
                                    <a href="#" class="d-block mb-3 text-decoration-none text-white">Gallery</a>
                                </div>
                                <div class="col-2">
                                    <a href="{{ route('contact.small') }}" class="d-block mb-3 text-decoration-none text-white">Content</a>
                                    <a href="{{ route('share') }}" class="d-block mb-3 text-decoration-none text-white">News</a>
                                    <a href="{{ route('donate') }}" class="d-block mb-3 text-decoration-none text-white">Donate</a>
                                    <a href="{{ route('contact.small') }}" class="d-block mb-3 text-decoration-none text-white">Contact</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <p>Follow Us Today</p>
                            <div class="d-flex gap-2 mb-3 follow">
                                <a href="#">
                                    <img src="{{ asset('front/img/skill-icons_instagram.png') }}" alt="" width="24px" height="24px">
                                </a>
                                <a href="#">
                                    <img src="{{ asset('front/img/logos_facebook.png') }}" alt="" width="24px" height="24px">
                                </a>
                                <a href="#">
                                    <img src="{{ asset('front/img/streamline-logos_x-twitter-logo-block.png') }}" alt="" width="24px" height="24px">
                                </a>
                                <a href="#">
                                    <img src="{{ asset('front/img/skill-icons_linkedin.png') }}" alt="" width="24px" height="24px">
                                </a>
                            </div>
                            <div class="d-flex justify-content-start gap-2 pb-5 mt-4 footer-btns">
                                <a href="{{ route('share') }}"
                                    class="text-decoration-none footer-share text-white rounded-3 d-flex justify-content-center align-items-center">
                                    <i class="bi bi-plus-circle pe-2" width="30px" height="30px"></i>
                                    Share your story
                                </a>
                                <a href="{{ route('donate') }}"
                                    class="text-decoration-none footer-donate text-white rounded-3 d-flex justify-content-center align-items-center">
                                    <i class="fa-solid fa-circle-dollar-to-slot pe-2" width="30px" height="30px"></i>
                                    Donate
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="copyright d-flex justify-content-center gap-3">
                <i class="bi bi-c-circle text-white"></i>
                <p class="text-white">2025 Memory of Resilience. All rights reserved.</p>
            </div>
        </div>
    </div>
</footer>
