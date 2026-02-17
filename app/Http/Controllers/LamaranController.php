<?php

namespace App\Http\Controllers;

use App\Models\Lamaran;
use App\Models\Lowongan;
use App\Models\MitraUsaha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\PelamarDiterimaMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Mail\LamaranMasukMail;
use App\Notifications\LamaranMasukNotif;



class LamaranController extends Controller
{
    /**
     * Store lamaran dari user ke lowongan
     */
    public function store(Request $request, Lowongan $lowongan)
    {
        $user = Auth::user();

        // Cek apakah sudah melamar
        $cek = Lamaran::where('lowongan_id', $lowongan->id)
            ->where('pelamar_id', $user->user_id)
            ->first();

        if ($cek) {
            return back()->with('error', 'Kamu sudah mengirim lamaran untuk lowongan ini.');
        }

        $request->validate([
            'cv_option' => 'required|in:profile,upload',
            'cv_file'   => 'required_if:cv_option,upload|mimes:pdf|max:4096',
        ]);

        // Pilih CV
        if ($request->cv_option === 'profile') {
            if (!$user->detail?->cv) {
                return back()->with('error', 'CV profil belum tersedia.');
            }
            $cvPath = $user->detail->cv;
        } else {
            $cvPath = $request->file('cv_file')
                ->store('cv/lamaran', 'public');
        }

        $lamaran = Lamaran::create([
            'lowongan_id'   => $lowongan->id,
            'perusahaan_id' => $lowongan->perusahaan_id,
            'pelamar_id'    => $user->user_id,
            'status'        => 'Dikirim',
            'cv'            => $cvPath,
            'catatan'       => null,
        ]);

        $emailPerusahaan = $lowongan->perusahaan?->email;

        if ($emailPerusahaan) {
            Mail::to($emailPerusahaan)
                ->send(new LamaranMasukMail($user, $lowongan));
        }

       $adminUsaha = $lamaran->perusahaan->user;

        if ($adminUsaha && $adminUsaha->user_id !== Auth::user()->user_id) {
            $adminUsaha->notify(new LamaranMasukNotif($lamaran));
        }

        return redirect()->route('lamaran')
            ->with('success', 'Lamaran berhasil dikirim.');
    }

    /**
     * Index lamaran untuk admin_usaha
     * Menampilkan semua lamaran untuk lowongan yang dia buat
     */
    public function index()
    {
        $userEmail = Auth::user()->email;

        // Ambil usaha admin
        $usaha = MitraUsaha::where('email', $userEmail)->first();
        if (!$usaha) {
            return back()->withErrors(['usaha' => 'Data usaha tidak ditemukan']);
        }

        // Ambil semua lowongan milik usaha ini, beserta jumlah lamaran
        $lowongan = Lowongan::withCount('lamaran') // ini akan menghitung jumlah lamaran untuk setiap lowongan
            ->where('perusahaan_id', $usaha->usaha_id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin_usaha.lamaran.index', compact('lowongan'));
    }

        /**
         * Tampilkan detail lamaran
         */
    public function show($lowonganId, Request $request)
    {
        $user = Auth::user();

        if ($request->has('notification')) {
            $notificationId = $request->query('notification');
            Auth::user()->unreadNotifications()
                ->where('id', $notificationId)
                ->update(['read_at' => now()]);
        }



        // Cek usaha admin
        $usaha = MitraUsaha::where('email', $user->email)->first();
        if (!$usaha) {
            return back()->withErrors(['usaha' => 'Data usaha tidak ditemukan']);
        }
        $namaUsaha = MitraUsaha::where('user_id',$user->user_id)->first();
        // Ambil lowongan beserta lamaran
        $lowongan = Lowongan::with(['lamaran.pelamar'])
            ->where('id', $lowonganId)
            ->where('perusahaan_id', $usaha->usaha_id)
            ->firstOrFail();

        return view('admin_usaha.lamaran.show', compact('lowongan','namaUsaha'));
    }


    /**
     * Update status lamaran (Terima / Tolak) oleh admin_usaha
     */
    public function updateStatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:Diterima,Ditolak',
            'catatan' => 'required_if:status,Diterima',
            'surat_diterima' => 'nullable|file|mimes:pdf,doc,docx|max:4096',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $lamaran = Lamaran::findOrFail($id);

        // Cek akses admin usaha
        $usaha = MitraUsaha::where('email', Auth::user()->email)->first();

        if (!$usaha || $lamaran->perusahaan_id !== $usaha->usaha_id) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses ke lamaran ini.'
            ], 403);
        }

        try {

            $data = [
                'status' => $request->status,
                'catatan' => $request->catatan,
            ];

            // Jika upload surat diterima
            if ($request->hasFile('surat_diterima')) {

                $filePath = $request->file('surat_diterima')
                                    ->store('surat_diterima', 'public');

                $data['surat_diterima'] = $filePath;
            }

            $lamaran->update($data);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Update gagal: ' . $e->getMessage()
            ], 500);

        }

        return response()->json([
            'success' => true,
            'message' => $request->status === 'Diterima'
                ? 'Pelamar berhasil diterima.'
                : 'Pelamar berhasil ditolak.'
        ]);
    }

    /**
     * Hapus lamaran (opsional)
     */
    public function destroy($id)
    {
        $lamaran = Lamaran::findOrFail($id);

        $usaha = MitraUsaha::where('email', Auth::user()->email)->first();
        if ($lamaran->perusahaan_id !== $usaha->usaha_id) {
            return back()->with('error', 'Anda tidak memiliki akses ke lamaran ini.');
        }

        // Hapus file CV jika ada
        if ($lamaran->cv && Storage::disk('public')->exists($lamaran->cv)) {
            Storage::disk('public')->delete($lamaran->cv);
        }

        $lamaran->delete();

        return redirect()->back()->with('success', 'Lamaran berhasil dihapus.');
    }

public function sendNotif(Request $request, $id)
{
    $lamaran = Lamaran::with('pelamar.detail', 'lowongan')->findOrFail($id);

    // Pastikan status Diterima
    if ($lamaran->status !== 'Diterima') {
        return response()->json([
            'success' => false,
            'message' => 'Pelamar belum diterima.'
        ]);
    }

    $admin = Auth::user(); // Admin login

    // ===== PILIH EMAIL & APP PASSWORD =====
    $smtpUsername = $admin->email_smtp ?? env('MAIL_USERNAME');
    $smtpPassword = $admin->app_password ?? env('MAIL_PASSWORD');
    $fromAddress  = $admin->email_smtp ?? env('MAIL_FROM_ADDRESS');
    $fromName     = $admin->nama ?? env('MAIL_FROM_NAME');

    $type = $request->input('type');

    if ($type === 'email') {
        try {
            // Konfigurasi mail runtime sesuai fallback
            config([
                'mail.mailers.smtp.transport' => 'smtp',
                'mail.mailers.smtp.host' => 'smtp.gmail.com',
                'mail.mailers.smtp.port' => 587,
                'mail.mailers.smtp.encryption' => 'tls',
                'mail.mailers.smtp.username' => $smtpUsername,
                'mail.mailers.smtp.password' => $smtpPassword,
                'mail.from.address' => $fromAddress,
                'mail.from.name' => $fromName,
            ]);

            Mail::to($lamaran->pelamar->email)
                ->send(new PelamarDiterimaMail($lamaran));

            return response()->json([
                'success' => true,
                'message' => 'Email berhasil dikirim dari ' . $smtpUsername
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim email: ' . $e->getMessage()
            ]);
        }
    } elseif ($type === 'whatsapp') {
        $no_wa = $lamaran->pelamar->detail->no_wa ?? null;

        if (!$no_wa) {
            return response()->json([
                'success' => false,
                'message' => 'Nomor WhatsApp pelamar tidak tersedia.'
            ]);
        }

        $pesan = "Selamat {$lamaran->pelamar->nama}, lamaran Anda untuk posisi {$lamaran->lowongan->judul} diterima!";
        $waLink = "https://wa.me/{$no_wa}?text=" . urlencode($pesan);

        return response()->json([
            'success' => true,
            'message' => 'Link WhatsApp siap dikirim.',
            'link' => $waLink
        ]);
    }

    return response()->json([
        'success' => false,
        'message' => 'Tipe notifikasi tidak valid.'
    ]);
}

public function detailJson($id)
{
    $user = Auth::user();

    $lamaran = Lamaran::with([
        'lowongan.perusahaan',
        'pelamar.detail'
    ])
    ->where('id', $id)
    ->where('pelamar_id', $user->user_id)
    ->firstOrFail();

    return response()->json([
        'success' => true,
        'data' => $lamaran
    ]);
}


}