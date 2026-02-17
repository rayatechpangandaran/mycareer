<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Akun Usaha Disetujui</title>
</head>

<body style="margin:0; padding:0; background-color:#f4f6f8; font-family: Arial, Helvetica, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="padding:40px 0; background-color:#f4f6f8;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0"
                    style="background:#ffffff; border-radius:8px; overflow:hidden; box-shadow:0 4px 12px rgba(0,0,0,0.08);">

                    <!-- HEADER -->
                    <tr>
                        <td style="background:#16a34a; padding:24px; color:#ffffff;">
                            <h2 style="margin:0; font-size:20px;">🎉 Selamat Bergabung!</h2>
                            <p style="margin:6px 0 0; font-size:14px; opacity:0.95;">
                                Akun Usaha Anda Telah Disetujui
                            </p>
                        </td>
                    </tr>

                    <!-- BODY -->
                    <tr>
                        <td style="padding:24px;">
                            <p style="font-size:15px; color:#111827;">
                                Halo <strong>{{ $user->nama }}</strong>,
                            </p>

                            <p style="font-size:14px; color:#374151; line-height:1.6;">
                                Kami dengan senang hati menginformasikan bahwa akun usaha Anda telah
                                <strong>berhasil diverifikasi</strong> dan kini sudah aktif.
                            </p>

                            <!-- ACCOUNT INFO -->
                            <div
                                style="background:#f0fdf4; border-left:4px solid #22c55e; padding:16px; margin:20px 0;">
                                <p style="margin:0 0 10px; font-size:13px; color:#065f46;">
                                    <strong>Informasi Akun Login</strong>
                                </p>

                                <table width="100%" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td style="padding:6px 0; font-size:14px; color:#065f46; width:30%;">Email</td>
                                        <td style="padding:6px 0; font-size:14px; color:#064e3b;">
                                            <strong>{{ $user->email }}</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding:6px 0; font-size:14px; color:#065f46;">Password</td>
                                        <td style="padding:6px 0; font-size:14px; color:#064e3b;">
                                            <strong>{{ $password }}</strong>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <!-- SECURITY NOTICE -->
                            <div
                                style="background:#fffbeb; border-left:4px solid #f59e0b; padding:14px; margin:20px 0;">
                                <p style="margin:0; font-size:13px; color:#92400e; line-height:1.6;">
                                    Demi keamanan akun:
                                <ul style="margin:8px 0 0 18px; padding:0; font-size:13px; color:#92400e;">
                                    <li>Password dibuat otomatis oleh sistem dan tersimpan dalam kondisi terenkripsi.
                                    </li>
                                    <li><strong>Jangan login menggunakan Google</strong>. Gunakan login manual melalui
                                        form.</li>
                                    <li>Segera ganti password setelah berhasil login.</li>
                                </ul>
                                </p>
                            </div>

                            <!-- LOGIN BUTTON -->
                            <div style="text-align:center; margin:30px 0;">
                                <a href="{{ url('/login') }}"
                                    style="background:#2563eb; color:#ffffff; text-decoration:none;
                               padding:12px 26px; border-radius:6px; font-size:14px; display:inline-block;">
                                    Login ke Dashboard
                                </a>
                            </div>

                            <p style="font-size:13px; color:#6b7280; line-height:1.6;">
                                Jika Anda mengalami kendala saat login, silakan hubungi tim kami.
                            </p>
                        </td>
                    </tr>

                    <!-- FOOTER -->
                    <tr>
                        <td style="background:#f9fafb; padding:16px; text-align:center; font-size:12px; color:#9ca3af;">
                            © {{ date('Y') }} CareerPangandaran<br>
                            CV Karunia Abadi Interconnection
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>

</html>
