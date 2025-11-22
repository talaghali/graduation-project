<nav class="navbar navbar-expand-lg p-3 gray-backgroundcolor">
    <div class="container-fluid section-maxwidth p-3 py-4">
        <!-- Logo -->
        <a class="navbar-brand" href="{{ route('index') }}">
            <img src="{{ asset('front/img/logo f.png') }}" alt="Logo" style="width:125px; height:76px;">
        </a>

        <!-- Hamburger Button for Small Screens -->
        <button class="navbar-toggler border-0 d-block d-lg-none" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="#ffffff" style="width: 30px; height: 30px">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25H12" />
            </svg>
        </button>

        <!-- Navigation Menu -->
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav gap-5 mx-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link text-color {{ request()->routeIs('index') ? 'active' : '' }}" aria-current="page" href="{{ route('index') }}">Home</a>
                </li>

                <li class="nav-item dropdown dropdown-mega">
                    <a class="nav-link text-color dropdown-toggle d-none d-lg-block" href="#" id="storiesDropdown"
                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Stories
                    </a>
                    <a class="nav-link text-color d-lg-none" href="{{ route('stories.index') }}">
                        Stories
                    </a>
                    <!-- Stories Dropdown Content -->
                    <div class="dropdown-menu" aria-labelledby="storiesDropdown">
                        <div class="container-fluid">
                            <div class="row justify-content-center dropdown-hover">
                                @if(isset($navbarStories) && $navbarStories->count() > 0)
                                    @foreach($navbarStories->chunk(3) as $chunk)
                                        <div class="col-md-2 col-sm-6 mb-2">
                                            @foreach($chunk as $story)
                                                <a href="{{ route('stories.show', $story->id) }}" class="d-block mb-2">
                                                    {{ $story->name ?? $story->title }}
                                                </a>
                                            @endforeach
                                        </div>
                                    @endforeach
                                @else
                                    <div class="col-12 text-center text-white py-4">
                                        <p>No stories available yet</p>
                                    </div>
                                @endif
                                <div class="col-12 text-end mt-3 mb-2 pe-4">
                                    <a href="{{ route('stories.index') }}"
                                       class="btn btn-sm px-3 py-1 fw-normal text-white"
                                       style="background: linear-gradient(135deg, #b70003 0%, #8b0002 100%);
                                              border: none;
                                              border-radius: 20px;
                                              box-shadow: 0 2px 6px rgba(183, 0, 3, 0.25);
                                              transition: all 0.3s ease;
                                              font-size: 0.8rem;"
                                       onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 3px 10px rgba(183, 0, 3, 0.4)';"
                                       onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 6px rgba(183, 0, 3, 0.25)';">
                                        View All <i class="bi bi-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-color" href="{{ route('share') }}">Contribute Your Story</a>
                </li>

                <li class="nav-item dropdown dropdown-mega">
                    <a class="nav-link text-color dropdown-toggle d-none d-lg-block" href="#" id="aboutDropdown"
                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        About
                    </a>
                    <a class="nav-link text-color d-lg-none" href="{{ route('about.small') }}">
                        About
                    </a>
                    <div class="dropdown-menu" aria-labelledby="aboutDropdown">
                        <div class="container-fluid">
                            <div class="d-flex justify-content-center align-items-center flex-column">
                                <h4 class="text-white">Voices Of Gaza</h4>
                                <p class="text-white text-center" style="max-width: 973px;">
                                    Voices of gaza is a digital memorial preserving the stories of those affected by
                                    conflict. It honors the lives of children, families, journalists, doctors, and
                                    countless others whose voices were silenced. Through these stories, we remember
                                    their resilience and ensure their memories live on.
                                </p>
                            </div>
                        </div>
                    </div>
                </li>

                <li class="nav-item text-color dropdown dropdown-mega">
                    <a class="nav-link text-color dropdown-toggle d-none d-lg-block" href="#" id="contentDropdown"
                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Contact
                    </a>
                    <a class="nav-link text-color d-lg-none" href="{{ route('contact.small') }}">
                        Contact
                    </a>
                    <div class="dropdown-menu" aria-labelledby="contentDropdown">
                        <div class="container-fluid">
                            <div class="d-flex justify-content-center align-items-center flex-column">
                                <h4 class="text-white">Contact Us</h4>
                                <p class="text-white text-center" style="max-width: 842px;">
                                    Have a story to share? Need more information? <br> Reach out to us via email or through our social media channels — we'd love to hear from you.
                                </p>
                                <div>
                                    <a href="#" class="fw-bold text-white">
                                        <i class="bi bi-envelope text-white fw-bold pe-2"></i>Email: info@gazamuseum.org
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>

            <!-- User Authentication Section (Large Screens) -->
            @auth
                <div class="d-none d-lg-flex gap-3 align-items-center">
                    <div class="dropdown">
                        <a class="d-flex align-items-center text-decoration-none dropdown-toggle text-white"
                           href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="d-flex align-items-center gap-2">
                                <div class="profile-avatar-small">
                                    {{ strtoupper(substr(Auth::user()->first_name, 0, 1)) }}{{ strtoupper(substr(Auth::user()->last_name, 0, 1)) }}
                                </div>
                                <span class="fw-semibold">{{ Auth::user()->first_name }}</span>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end profile-dropdown-menu" aria-labelledby="profileDropdown">
                            <li class="dropdown-header">
                                <div class="text-center py-2">
                                    <div class="profile-avatar-dropdown mb-2">
                                        {{ strtoupper(substr(Auth::user()->first_name, 0, 1)) }}{{ strtoupper(substr(Auth::user()->last_name, 0, 1)) }}
                                    </div>
                                    <h6 class="mb-0">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h6>
                                    <small class="text-muted">{{ Auth::user()->email }}</small>
                                </div>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('profile') }}">
                                    <i class="bi bi-person-fill me-2"></i>My Profile
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('settings') }}">
                                    <i class="bi bi-gear-fill me-2"></i>Settings
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item logout-item" href="#" id="logoutBtn">
                                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            @else
                <div class="d-none d-lg-flex gap-3">
                    <a href="{{ route('signup') }}"
                        class="d-flex align-items-center justify-content-center text-decoration-none border-0 btn-style signup-style text-white"
                        type="button">
                        Sign up
                    </a>
                    <a href="{{ route('login') }}"
                        class="d-flex align-items-center justify-content-center text-decoration-none btn-style login-style"
                        type="button">
                        Log in
                    </a>
                </div>
            @endauth

            <!-- User Authentication Section (Small Screens) -->
            @auth
                <div class="d-lg-none mt-3 d-flex justify-content-center gap-2">
                    <div class="dropdown">
                        <a class="d-flex align-items-center text-decoration-none dropdown-toggle text-white"
                           href="#" id="profileDropdownMobile" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="d-flex align-items-center gap-2">
                                <div class="profile-avatar-small">
                                    {{ strtoupper(substr(Auth::user()->first_name, 0, 1)) }}{{ strtoupper(substr(Auth::user()->last_name, 0, 1)) }}
                                </div>
                                <span class="fw-semibold">{{ Auth::user()->first_name }}</span>
                            </div>
                        </a>
                        <ul class="dropdown-menu profile-dropdown-menu" aria-labelledby="profileDropdownMobile">
                            <li class="dropdown-header">
                                <div class="text-center py-2">
                                    <div class="profile-avatar-dropdown mb-2">
                                        {{ strtoupper(substr(Auth::user()->first_name, 0, 1)) }}{{ strtoupper(substr(Auth::user()->last_name, 0, 1)) }}
                                    </div>
                                    <h6 class="mb-0">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h6>
                                    <small class="text-muted">{{ Auth::user()->email }}</small>
                                </div>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('profile') }}">
                                    <i class="bi bi-person-fill me-2"></i>My Profile
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('settings') }}">
                                    <i class="bi bi-gear-fill me-2"></i>Settings
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item logout-item" href="#" id="logoutBtnMobile">
                                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            @else
                <div class="d-lg-none mt-3 d-flex justify-content-center gap-2">
                    <a href="{{ route('signup') }}"
                        class="d-flex align-items-center justify-content-center text-decoration-none border-0 btn-style signup-style text-white"
                        type="button">
                        Sign up
                    </a>
                    <a href="{{ route('login') }}"
                        class="d-flex align-items-center justify-content-center text-decoration-none btn-style login-style"
                        type="button">
                        Log in
                    </a>
                </div>
            @endauth
        </div>
    </div>
</nav>

@auth
@push('scripts')
<script>
    // Logout functionality for both desktop and mobile
    async function handleLogout(e) {
        e.preventDefault();

        const result = await Swal.fire({
            title: 'Logout',
            text: 'Are you sure you want to logout?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#b70003',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, logout',
            cancelButtonText: 'Cancel'
        });

        if (result.isConfirmed) {
            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

                const response = await axios.post('{{ route("api.logout") }}', {}, {
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                });

                if (response.data.success) {
                    await Swal.fire({
                        icon: 'success',
                        title: 'Logged Out',
                        text: response.data.message,
                        confirmButtonColor: '#b70003',
                        timer: 1500,
                        showConfirmButton: false
                    });

                    window.location.href = '{{ route("index") }}';
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to logout. Please try again.',
                    confirmButtonColor: '#b70003'
                });
            }
        }
    }

    // Attach event listeners
    document.getElementById('logoutBtn')?.addEventListener('click', handleLogout);
    document.getElementById('logoutBtnMobile')?.addEventListener('click', handleLogout);
</script>
@endpush
@endauth
