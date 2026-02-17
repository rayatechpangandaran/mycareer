<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Verifikasi Email | JobLoker</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('assets/img/logoCareer.jpeg') }}" type="image/jpeg">

    <style>
        body {
            background: linear-gradient(135deg, #ffb703, #fb8500);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .verify-card {
            max-width: 420px;
            width: 100%;
            border-radius: 16px;
        }

        .code-input {
            letter-spacing: 6px;
            text-align: center;
            font-size: 1.5rem;
            font-weight: 600;
        }
    </style>
</head>

<body>

    <div class="card verify-card shadow-lg">
        <div class="card-body p-4">

            <div class="text-center mb-4">
                <i class="fa-solid fa-envelope-circle-check fa-3x text-warning mb-3"></i>
                <h4 class="fw-bold">Verifikasi Email</h4>
                <p class="text-muted mb-0">
                    Masukkan kode verifikasi yang kami kirim ke email Anda
                </p>
            </div>

            <form method="POST" action="{{ route('verify.code') }}">
                @csrf

                <div class="mb-3">
                    <input type="text" name="code" class="form-control code-input" placeholder="------"
                        maxlength="6" required autofocus>
                </div>

                <button type="submit" class="btn btn-warning w-100 fw-semibold">
                    Verifikasi Sekarang
                </button>
            </form>

            <div class="text-center mt-3">
                <small class="text-muted">
                    Tidak menerima kode?
                    <a href="" class="text-warning fw-semibold text-decoration-none">
                        Kirim ulang
                    </a>
                </small>
            </div>

        </div>
    </div>

    <!-- TOAST -->
    <div class="toast-container position-fixed top-0 end-0 p-3">
        @if (session('success'))
            <div class="toast align-items-center text-bg-success border-0 show">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fa-solid fa-circle-check me-2"></i>
                        {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto"
                        data-bs-dismiss="toast"></button>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="toast align-items-center text-bg-danger border-0 show">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fa-solid fa-circle-xmark me-2"></i>
                        {{ session('error') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto"
                        data-bs-dismiss="toast"></button>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="toast align-items-center text-bg-danger border-0 show">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fa-solid fa-triangle-exclamation me-2"></i>
                        {{ $errors->first() }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto"
                        data-bs-dismiss="toast"></button>
                </div>
            </div>
        @endif
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
