<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Pendaftaran Mitra Usaha Baru</title>
</head>

<body style="margin:0; padding:0; background-color:#f4f6f8; font-family: Arial, Helvetica, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f6f8; padding:40px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0"
                    style="background:#ffffff; border-radius:8px; overflow:hidden; box-shadow:0 4px 12px rgba(0,0,0,0.08);">

                    <!-- HEADER -->
                    <tr>
                        <td style="background:#1f2937; padding:24px; color:#ffffff;">
                            <h2 style="margin:0; font-size:20px;">RayaTech Pangandaran</h2>
                            <p style="margin:4px 0 0; font-size:14px; opacity:0.8;">
                                Notifikasi Pendaftaran Mitra Usaha
                            </p>
                        </td>
                    </tr>

                    <!-- BODY -->
                    <tr>
                        <td style="padding:24px;">
                            <p style="font-size:15px; color:#111827; margin-bottom:20px;">
                                Halo <strong>Superadmin</strong>,
                            </p>

                            <p style="font-size:14px; color:#374151; line-height:1.6;">
                                Terdapat <strong>pendaftaran mitra usaha baru</strong> yang memerlukan proses
                                verifikasi.
                                Berikut detail singkat mitra:
                            </p>

                            <!-- INFO TABLE -->
                            <table width="100%" cellpadding="0" cellspacing="0"
                                style="margin:20px 0; border-collapse:collapse;">
                                <tr>
                                    <td style="padding:8px 0; color:#6b7280; width:40%;">Nama Usaha</td>
                                    <td style="padding:8px 0; color:#111827;">
                                        <strong>{{ $mitra->nama_bisnis_usaha }}</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0; color:#6b7280;">Penanggung Jawab</td>
                                    <td style="padding:8px 0; color:#111827;">{{ $mitra->nama_penanggung_jawab }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0; color:#6b7280;">Email</td>
                                    <td style="padding:8px 0; color:#111827;">{{ $mitra->email }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0; color:#6b7280;">No. WhatsApp</td>
                                    <td style="padding:8px 0; color:#111827;">{{ $mitra->no_wa }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0; color:#6b7280;">Kota</td>
                                    <td style="padding:8px 0; color:#111827;">{{ $mitra->kota }}</td>
                                </tr>
                            </table>

                            <!-- BUTTON -->
                            <div style="text-align:center; margin:30px 0;">
                                <a href="{{ url('/superadmin/usaha') }}"
                                    style="background:#2563eb; color:#ffffff; text-decoration:none; padding:12px 24px; border-radius:6px; font-size:14px; display:inline-block;">
                                    Verifikasi Mitra Sekarang
                                </a>
                            </div>

                            <p style="font-size:13px; color:#6b7280; line-height:1.6;">
                                Silakan login ke dashboard superadmin untuk melakukan verifikasi dan tindak lanjut.
                            </p>
                        </td>
                    </tr>

                    <!-- FOOTER -->
                    <tr>
                        <td style="background:#f9fafb; padding:16px; text-align:center; font-size:12px; color:#9ca3af;">
                            © {{ date('Y') }} CareerPangandaran.id
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>

</html>
