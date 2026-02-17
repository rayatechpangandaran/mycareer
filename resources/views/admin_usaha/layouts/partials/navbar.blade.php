      <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
          <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
              <a class="navbar-brand brand-logo me-5" href="{{ route('admin_usaha.dashboard') }}">
                  <img src="{{ asset('assets/img/careerIndustri.png') }}" alt="logo" class="logo-full" />
              </a>

              <a class="navbar-brand brand-logo-mini" href="{{ route('admin_usaha.dashboard') }}">
                  <img src="{{ asset('assets/img/careerIndustri.png') }}" alt="logo" class="logo-mini" />
              </a>
          </div>

          <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
              <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                  <span class="icon-menu"></span>
              </button>
              <ul class="navbar-nav navbar-nav-right">
                  @php
                      $user = Auth::user();
                      $unreadCount = $user->unreadNotifications->count();
                      // Hanya ambil 5 notif terbaru, tapi urut berdasarkan created_at desc
                      $latestNotifs = $user->notifications()->latest()->take(5)->get();
                  @endphp

                  <li class="nav-item dropdown">
                      <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#"
                          data-bs-toggle="dropdown">
                          <i class="icon-bell mx-0"></i>
                          @if ($unreadCount > 0)
                              <span class="count">{{ $unreadCount }}</span>
                          @endif
                      </a>

                      <div class="dropdown-menu dropdown-menu-end navbar-dropdown preview-list">
                          <p class="mb-0 dropdown-header">Notifikasi</p>
                          @if ($unreadCount > 0)
                              @foreach ($latestNotifs as $notif)
                                  <a href="{{ $notif->data['url'] }}?notification={{ $notif->id }}"
                                      class="dropdown-item preview-item {{ is_null($notif->read_at) ? 'bg-light' : '' }}">

                                      <div class="preview-thumbnail">
                                          <div class="preview-icon bg-info">
                                              <i class="ti-info-alt mx-0"></i>
                                          </div>
                                      </div>

                                      <div class="preview-item-content">
                                          <h6 class="preview-subject font-weight-normal">
                                              {{ $notif->data['title'] }}
                                          </h6>
                                          <p class="small-text mb-0 text-muted">
                                              {{ $notif->data['message'] }}
                                          </p>
                                          <small class="text-muted">
                                              {{ $notif->created_at->diffForHumans() }}
                                          </small>
                                      </div>
                                  </a>
                              @endforeach
                          @else
                              <p class="text-center text-muted small mb-2">Tidak ada notifikasi</p>
                          @endif
                      </div>
                  </li>

                  @php
                      $user = Auth::user();
                  @endphp

                  <li class="nav-item nav-profile dropdown">
                      <a class="nav-link dropdown-toggle d-flex align-items-center" href="#"
                          data-bs-toggle="dropdown" id="profileDropdown">

                          <img src="{{ Auth::user()->avatar }}" alt="profile" class="rounded-circle me-2"
                              style="width:32px;height:32px;object-fit:cover;">

                          <span class="d-none d-md-inline fw-semibold">
                              {{ $user->name ?? $user->nama }}
                          </span>
                      </a>

                      <div class="dropdown-menu dropdown-menu-end navbar-dropdown" aria-labelledby="profileDropdown">

                          <div class="dropdown-header text-center">
                              <img src="{{ Auth::user()->avatar }}" class="rounded-circle mb-2"
                                  style="width:60px;height:60px;object-fit:cover;">
                              <p class="mb-0 fw-bold">{{ $user->name ?? $user->nama }}</p>
                              <small class="text-muted">{{ $user->email }}</small>
                          </div>

                          <div class="dropdown-divider"></div>

                          <a href="{{ route('admin_usaha.profile') }}" class="dropdown-item">
                              <i class="ti-user text-primary"></i> Profil Saya
                          </a>

                          <div class="dropdown-divider"></div>

                          <form id="logout-form" action="{{ route('logout') }}" method="POST">
                              @csrf
                              <button type="button" class="dropdown-item btn-logout">
                                  <i class="ti-power-off text-danger"></i> Logout
                              </button>
                          </form>

                      </div>
                  </li>

              </ul>
              <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                  data-toggle="offcanvas">
                  <span class="icon-menu"></span>
              </button>
          </div>
      </nav>
