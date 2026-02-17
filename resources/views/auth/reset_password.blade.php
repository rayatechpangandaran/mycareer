<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Ganti Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="shortcut icon" href="{{ asset('assets/img/logoCareer.jpeg') }}" type="image/jpeg">

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
            margin-bottom: 20px;
            color: #ff5722;
        }

        .input-group {
            position: relative;
            width: 100%;
            margin-bottom: 15px;
        }

        input {
            width: 100%;
            padding: 12px 40px 12px 12px;
            /* space untuk icon */
            border-radius: 8px;
            border: 1px solid #ddd;
            font-size: 14px;
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #999;
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

        .alert {
            padding: 10px;
            font-size: 14px;
            border-radius: 6px;
            margin-bottom: 15px;
            background: #fdecea;
            color: #c62828;
        }
    </style>
</head>

<body>

    <div class="card">
        <h2>Ganti Password</h2>

        @if ($errors->any())
            <div class="alert">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <!-- Password Baru -->
            <div class="input-group">
                <input type="password" name="password" id="password" placeholder="Password Baru" required>
                <i class="fa-solid fa-eye toggle-password" toggle="#password"></i>
            </div>

            <!-- Konfirmasi Password -->
            <div class="input-group">
                <input type="password" name="password_confirmation" id="passwordConfirm"
                    placeholder="Konfirmasi Password" required>
                <i class="fa-solid fa-eye toggle-password" toggle="#passwordConfirm"></i>
            </div>

            <button type="submit">Simpan Password</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Toggle password
        const toggleIcons = document.querySelectorAll('.toggle-password');
        toggleIcons.forEach(icon => {
            icon.addEventListener('click', function() {
                const input = document.querySelector(this.getAttribute('toggle'));
                if (input.type === "password") {
                    input.type = "text";
                    this.classList.replace('fa-eye', 'fa-eye-slash');
                } else {
                    input.type = "password";
                    this.classList.replace('fa-eye-slash', 'fa-eye');
                }
            });
        });
    </script>

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

</body>

</html>
