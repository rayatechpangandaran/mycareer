<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Pengajuan Usaha Ditolak</title>
</head>

<body style="margin:0; padding:0; background-color:#f4f6f8; font-family: Arial, Helvetica, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="padding:40px 0; background-color:#f4f6f8;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0"
                    style="background:#ffffff; border-radius:8px; overflow:hidden; box-shadow:0 4px 12px rgba(0,0,0,0.08);">

                    <!-- HEADER -->
                    <tr>
                        <td style="background:#b91c1c; padding:24px; color:#ffffff;">
                            <h2 style="margin:0; font-size:20px;">RayaTech Pangandaran</h2>
                            <p style="margin:4px 0 0; font-size:14px; opacity:0.9;">
                                Pemberitahuan Status Pengajuan Usaha
                            </p>
                        </td>
                    </tr>

                    <!-- BODY -->
                    <tr>
                        <td style="padding:24px;">
                            <p style="font-size:15px; color:#111827;">
                                Halo <strong>{{ $usaha->nama_bisnis_usaha }}</strong>,
                            </p>

                            <p style="font-size:14px; color:#374151; line-height:1.6;">
                                Terima kasih telah mengajukan pendaftaran mitra usaha melalui sistem kami.
                                Setelah dilakukan peninjauan, kami informasikan bahwa pengajuan usaha Anda
                                <strong>belum dapat kami setujui</strong> saat ini.
                            </p>

                            <!-- ALASAN -->
                            <div
                                style="background:#fef2f2; border-left:4px solid #dc2626; padding:16px; margin:20px 0;">
                                <p style="margin:0 0 6px; font-size:13px; color:#7f1d1d;">
                                    <strong>Alasan Penolakan:</strong>
                                </p>
                                <p style="margin:0; font-size:14px; color:#991b1b; line-height:1.6;">
                                    {{ $alasan }}
                                </p>
                            </div>

                            <p style="font-size:14px; color:#374151; line-height:1.6;">
                                Silakan melakukan perbaikan data sesuai dengan catatan di atas,
                                kemudian ajukan kembali pendaftaran mitra usaha Anda melalui sistem.
                            </p>

                            <p style="font-size:13px; color:#6b7280; line-height:1.6;">
                                Jika Anda memerlukan bantuan lebih lanjut, silakan hubungi tim kami.
                            </p>
                        </td>
                    </tr>

                    <!-- FOOTER -->
                    <tr>
                        <td style="background:#f9fafb; padding:16px; text-align:center; font-size:12px; color:#9ca3af;">
                            © {{ date('Y') }} CareerPangandaran<br>
                            Email ini dikirim secara otomatis, mohon tidak membalas email ini.
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>

</html>
