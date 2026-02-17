<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Lupa Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            margin: 0;
            height: 100vh;
            background: linear-gradient(135deg, #ff9800, #ff5722);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            width: 100%;
            max-width: 420px;
            background: #fff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, .2);
            animation: fadeSlide .6s ease;
        }

        @keyframes fadeSlide {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        h2 {
            text-align: center;
            margin-bottom: 10px;
            color: #ff5722;
        }

        p {
            text-align: center;
            font-size: 14px;
            color: #666;
            margin-bottom: 25px;
        }

        input {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-size: 14px;
            margin-bottom: 15px;
        }

        button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #ff9800, #ff5722);
            border: none;
            color: #fff;
            font-size: 15px;
            border-radius: 8px;
            cursor: pointer;
        }

        button:hover {
            opacity: .9;
        }

        .alert {
            padding: 10px;
            font-size: 14px;
            border-radius: 6px;
            margin-bottom: 15px;
        }

        .success {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .error {
            background: #fdecea;
            color: #c62828;
        }

        .back {
            margin-top: 15px;
            text-align: center;
        }

        .back a {
            color: #ff5722;
            text-decoration: none;
            font-size: 14px;
        }
    </style>
</head>

<body>

    <div class="card">
        <h2>Lupa Password</h2>
        <p>Masukkan email terdaftar untuk menerima link reset password</p>

        @if (session('success'))
            <div class="alert success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert error">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <input type="email" name="email" placeholder="Email Anda" required>
            <button type="submit">Kirim Link Reset</button>
        </form>

        <div class="back">
            <a href="{{ route('login') }}">← Kembali ke Login</a>
        </div>
    </div>

</body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

</html>
