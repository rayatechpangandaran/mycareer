<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login | CareerPangandaran.id</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/img/logoCareer.jpeg') }}" type="image/jpeg">


</head>

<body>

    <div class="login-card row g-0">

        <!-- LEFT INFO -->
        <div class="col-md-6 login-left d-flex flex-column justify-content-center">
            <h2>CareerPangandaran.id</h2>
            <p class="mt-3">
                Masuk untuk mencari lowongan terbaik atau pasang lowongan
                untuk UMKM, CV, PT, dan Hotel dengan mudah.
            </p>
            <ul class="mt-4">
                <li>✔ Gratis daftar</li>
                <li>✔ Cepat & aman</li>
                <li>✔ Cocok UMKM & Pencari Kerja</li>
            </ul>
        </div>

        <!-- RIGHT FORM -->
        <div class="col-md-6 login-right">
            <h4 class="fw-bold mb-2">Login Akun</h4>
            <p class="text-muted mb-4">Silakan masuk untuk melanjutkan</p>

            <form action="{{ route('login') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="form-control @error('email') is-invalid @enderror" placeholder="email@example.com">
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label>Password</label>
                    <div class="password-wrapper">
                        <input type="password" name="password" id="passwordLogin"
                            class="form-control @error('password') is-invalid @enderror" placeholder="">
                        <span class="toggle-password" data-target="passwordLogin" data-bs-placement="top"
                            title="Lihat Password">
                            <i class="fa-solid fa-eye"></i>
                        </span>
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-between mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label" for="remember">Ingat saya</label>
                    </div>

                    <a href="{{ route('password.request') }}" class="text-decoration-none text-warning fw-semibold">
                        Lupa password?
                    </a>
                </div>

                <button class="btn btn-login w-100 mb-3" type="submit">
                    Masuk
                </button>
            </form>
            <div class="divider">
                <span>atau</span>
            </div>

            <a href="{{ route('google.login') }}" class="btn btn-google w-100">
                <img src="https://developers.google.com/identity/images/g-logo.png" width="18" class="me-2">
                Login dengan Google
            </a>

            <p class="text-center mt-4">
                Belum punya akun?
                <a href="register.html" class="fw-semibold text-warning text-decoration-none" data-bs-toggle="modal"
                    data-bs-target="#chooseRegisterModal">
                    Daftar sekarang
                </a>
            </p>

        </div>

    </div>

    <div class="modal fade" id="chooseRegisterModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow-lg">

                <div class="modal-body p-4 text-center">
                    <h5 class="fw-bold mb-2">Daftar Sebagai</h5>
                    <p class="text-muted mb-4">
                        Pilih jenis akun yang ingin Anda buat
                    </p>

                    <div class="d-grid gap-3">
                        <button class="btn btn-warning fw-semibold py-3" data-bs-toggle="modal"
                            data-bs-target="#registerPelamarModal" data-bs-dismiss="modal">
                            <i class="bi bi-briefcase-fill me-2"></i>
                            Pelamar Kerja
                        </button>
                        <a class="btn btn-warning fw-semibold py-3" target="_blank" href="{{ route('register') }}">
                            <i class="bi bi-briefcase-fill me-2"></i>
                            Bisnis
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="registerPelamarModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content rounded-4 border-0 shadow-lg">

                <div class="modal-body p-4 p-md-5">

                    <div class="text-center mb-4">
                        <span class="badge bg-warning text-dark mb-2">
                            Daftar Pelamar
                        </span>
                        <h4 class="fw-bold">Buat Akun Pelamar</h4>
                        <p class="text-muted">
                            Daftar gratis untuk melamar lowongan kerja
                        </p>
                    </div>

                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" name="nama"
                                placeholder="Nama lengkap Anda">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email"
                                placeholder="email@example.com">
                        </div>

                        <div class="mb-3">
                            <label>Password</label>
                            <div class="password-wrapper">
                                <input type="password" name="password" id="passwordReg" class="form-control"
                                    placeholder="">

                                <!-- Tombol Generate Password -->
                                <button type="button" class="btn btn-sm btn-outline-secondary generate-password"
                                    id="generatePasswordBtn" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="Buat password acak">
                                    <i class="bi bi-key"></i>
                                </button>

                                <!-- Toggle Show/Hide -->
                                <span class="toggle-password" data-target="passwordReg" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Lihat Password">
                                    <i class="fa-solid fa-eye"></i>
                                </span>
                            </div>
                            <div class="text-danger small mt-1" id="passwordRegError"></div>
                        </div>

                        <div class="mb-3">
                            <label>Ulangi Password</label>
                            <div class="password-wrapper">
                                <input type="password" name="password_confirmation" id="passwordRepeatReg"
                                    class="form-control" placeholder="">
                                <span class="toggle-password" data-target="passwordRepeatReg"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Password">
                                    <i class="fa-solid fa-eye"></i>
                                </span>
                            </div>
                            <div class="text-danger small mt-1" id="repeatPasswordRegError"></div>
                        </div>

                        <button class="btn btn-login w-100 fw-semibold py-2 mt-2" type="submit">
                            Daftar Sekarang
                        </button>

                        <div class="text-center my-3 text-muted">
                            atau
                        </div>

                        <a href="{{ route('google.login') }}" class="btn btn-google w-100 py-2">
                            <img src="https://developers.google.com/identity/images/g-logo.png" width="18"
                                class="me-2">
                            Daftar dengan Google
                        </a>

                        <p class="text-center mt-4 mb-0">
                            Sudah punya akun?
                            <a href="{{ route('login') }}" class="text-warning fw-semibold text-decoration-none">
                                Login
                            </a>
                        </p>

                    </form>

                </div>

            </div>
        </div>
    </div>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if (session('toast_error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: '{{ session('toast_error') }}',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        });
    </script>
@endif
@if (session('toast_success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: '{{ session('toast_success') }}',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        });
    </script>
@endif
@if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            confirmButtonColor: '#28a745'
        });
    </script>
@endif
<script src="{{ asset('assets/js/login.js') }}"></script>

</html>
