<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial
        }

        .code {
            font-size: 32px;
            font-weight: bold;
            letter-spacing: 6px;
            color: #f59e0b;
        }
    </style>
</head>

<body>
    <h2>Verifikasi Akun CareerPangandaran</h2>

    <p>Halo {{ $user->name }},</p>

    <p>Gunakan kode berikut untuk verifikasi akun kamu:</p>

    <div class="code">{{ $code }}</div>

    <p>Kode berlaku selama <b>10 menit</b>.</p>
</body>

</html>
