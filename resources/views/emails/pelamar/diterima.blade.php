<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Lamaran Diterima</title>
</head>

<body style="margin:0; padding:0; background:#f4f6f8; font-family:Arial, Helvetica, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="padding:40px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0"
                    style="background:#ffffff; border-radius:8px; overflow:hidden;
                   box-shadow:0 4px 12px rgba(0,0,0,0.08);">

                    <!-- HEADER -->
                    <tr>
                        <td style="background:#16a34a; padding:24px; color:#ffffff;">
                            <h2 style="margin:0;">🎉 Selamat!</h2>
                            <p style="margin:6px 0 0; font-size:14px;">
                                Lamaran Anda Diterima
                            </p>
                        </td>
                    </tr>

                    <!-- BODY -->
                    <tr>
                        <td style="padding:24px;">
                            <p style="font-size:15px; color:#111827;">
                                Halo <strong>{{ $lamaran->pelamar->nama }}</strong>,
                            </p>

                            <p style="font-size:14px; color:#374151; line-height:1.6;">
                                Kami dengan senang hati menginformasikan bahwa lamaran Anda untuk posisi:
                            </p>

                            <p style="font-size:16px; font-weight:bold; color:#111827; margin:12px 0;">
                                {{ $lamaran->lowongan->judul }}
                            </p>

                            <p style="font-size:14px; color:#374151;">
                                di perusahaan
                                <strong>{{ $lamaran->lowongan->perusahaan->nama_bisnis_usaha ?? 'Perusahaan' }}</strong>
                                telah <strong style="color:#16a34a;">DITERIMA</strong>.
                            </p>

                            @if ($lamaran->catatan)
                                <!-- CATATAN -->
                                <div
                                    style="background:#ecfeff; border-left:4px solid #06b6d4;
                                    padding:14px; margin:20px 0;">
                                    <p style="margin:0 0 6px; font-size:13px; color:#0e7490;">
                                        <strong>Catatan dari Perusahaan:</strong>
                                    </p>
                                    <p style="margin:0; font-size:14px; color:#0f172a;">
                                        {{ $lamaran->catatan }}
                                    </p>
                                </div>
                            @endif

                            @if ($lamaran->surat_diterima)
                                <div style="text-align:center; margin:20px 0;">
                                    <a href="{{ asset('storage/' . $lamaran->surat_diterima) }}"
                                        style="background:#16a34a;
                                        color:#ffffff;
                                        text-decoration:none;
                                        padding:10px 22px;
                                        border-radius:6px;
                                        font-size:14px;">
                                        Download Surat Penerimaan
                                    </a>
                                </div>
                            @endif

                            <!-- CTA -->
                            <div style="text-align:center; margin:30px 0;">
                                <a href="{{ route('lamaran') }}"
                                    style="background:#2563eb; color:#ffffff; text-decoration:none;
                               padding:12px 26px; border-radius:6px; font-size:14px;">
                                    Lihat Detail Lamaran
                                </a>
                            </div>

                            <p style="font-size:13px; color:#6b7280; line-height:1.6;">
                                Silakan cek email secara berkala dan ikuti instruksi selanjutnya dari pihak perusahaan
                                agar proses rekrutmen berjalan lancar.
                            </p>
                        </td>
                    </tr>

                    <!-- FOOTER -->
                    <tr>
                        <td
                            style="background:#f9fafb; padding:16px; text-align:center;
                               font-size:12px; color:#9ca3af;">
                            © {{ date('Y') }} {{ config('app.name') }}<br>
                            Platform Lowongan Kerja Terpercaya
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>

</html>
