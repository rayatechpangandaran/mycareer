<nav class="navbar navbar-expand-lg navbar-dark sticky-top shadow-sm custom-navbar">
    <div class="container">

        <!-- BRAND -->
        <a class="navbar-brand d-flex align-items-center gap-2" href="#">
            <img src="{{ asset('assets/img/Logo_CP.png') }}" alt="Logo" style="width: 100px; height:40px;">
        </a>

        <!-- TOGGLER -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- MENU -->
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                        href="{{ route('home') }}">Beranda</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('lowonganAll') ? 'active' : '' }}"
                        href="{{ route('lowonganAll') }}">Lowongan Kerja</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('public.articles.*') ? 'active' : '' }}"
                        href="{{ route('public.articles.index') }}">Informasi</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}"
                        href="{{ route('contact') }}">Kontak</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center gap-2 profile-trigger" href="#"
                        role="button" data-bs-toggle="dropdown" aria-expanded="false">

                        @auth
                            @if (Auth::user()->avatar)
                                <img src="{{ Auth::user()->avatar }}" alt="avatar" class="rounded-circle" width="28"
                                    height="28">
                            @else
                                <i class="bi bi-person-circle fs-5"></i>
                            @endif

                            <span class="d-lg-inline">
                                {{ Auth::user()->nama }}
                            </span>
                        @endauth

                        @guest
                            <i class="bi bi-person-circle fs-5"></i>
                            <span class="d-inline ms-1">Masuk</span>
                        @endguest

                    </a>

                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">

                        {{-- SUDAH LOGIN --}}
                        @auth
                            <li>
                                <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('lamaran') }}">
                                    <i class="bi bi-lightning-charge-fill"></i>
                                    Lamaran Saya
                                </a>
                            </li>

                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="px-3">
                                    @csrf
                                    <button type="submit"
                                        class="btn btn-danger btn-sm w-100 d-flex align-items-center gap-2 justify-content-center">
                                        <i class="bi bi-box-arrow-right"></i>
                                        Keluar
                                    </button>
                                </form>
                            </li>
                        @endauth

                        {{-- GUEST --}}
                        @guest
                            <li>
                                <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('login') }}"
                                    target="_blank">
                                    <i class="bi bi-box-arrow-in-right"></i>
                                    Masuk
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('register') }}"
                                    target="_blank">
                                    <i class="bi bi-person-plus"></i>
                                    Daftar Akun
                                </a>
                            </li>
                        @endguest
                    </ul>
                </li>

            </ul>
        </div>

    </div>
</nav>
