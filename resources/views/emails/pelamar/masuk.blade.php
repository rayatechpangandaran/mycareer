<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Lamaran Baru Masuk</title>
</head>

<body style="background:#f4f6f8;padding:20px;font-family:Arial,sans-serif;">
    <table width="100%" cellspacing="0" cellpadding="0">
        <tr>
            <td align="center">
                <table width="600" style="background:#ffffff;border-radius:8px;padding:24px;">
                    <tr>
                        <td>
                            <h2 style="margin-top:0;color:#333;">
                                📩 Lamaran Baru Masuk
                            </h2>

                            <p>
                                Anda menerima lamaran baru untuk posisi:
                            </p>

                            <table width="100%" cellpadding="6">
                                <tr>
                                    <td width="35%"><strong>Posisi</strong></td>
                                    <td>: {{ $lowongan->judul }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Nama Pelamar</strong></td>
                                    <td>: {{ $pelamar->name ?? $pelamar->nama }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Email Pelamar</strong></td>
                                    <td>: {{ $pelamar->email }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Tanggal</strong></td>
                                    <td>: {{ now()->translatedFormat('d F Y H:i') }}</td>
                                </tr>
                            </table>

                            <p style="margin-top:20px;">
                                Silakan login ke sistem untuk melihat detail lengkap dan CV pelamar.
                            </p>

                            <p style="font-size:12px;color:#777;margin-top:30px;">
                                Email ini dikirim otomatis oleh sistem {{ config('app.name') }}.<br>
                                Anda dapat langsung membalas email ini untuk menghubungi pelamar.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
