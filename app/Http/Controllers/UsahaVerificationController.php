<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MitraUsaha;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\AdminUsahaApprovedMail;
use App\Mail\AdminUsahaRejectedMail;
use Illuminate\Support\Facades\Storage;



class UsahaVerificationController extends Controller
{
    public function index()
    {
        $usaha = MitraUsaha::orderBy('created_at', 'desc')->get();
        return view('superadmin.usaha.index', compact('usaha'));
    }

    public function show($id)
    {
        $usaha = MitraUsaha::findOrFail($id);
        return view('superadmin.usaha.show', compact('usaha'));
    }

    public function approve($id)
    {
        DB::transaction(function () use ($id) {

            $usaha = MitraUsaha::findOrFail($id);

            // Generate password
            $passwordPlain = Str::random(8);

            // Buat user admin usaha
            $user = User::create([
                'nama'              => $usaha->nama_bisnis_usaha,
                'email'             => $usaha->email,
                'password'          => Hash::make($passwordPlain),
                'role'              => 'admin_usaha',
                'is_active'         => 1,
                'email_verified_at' => now(),
            ]);

            // Update status usaha
            $usaha->update([
                'is_verify' => 1,
                'user_id' => 1,
                'verify_at' => now(),
            ]);

            // Kirim email ke ADMIN USAHA (User)
            Mail::to($user->email)
                ->send(new AdminUsahaApprovedMail($user, $passwordPlain));
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Usaha berhasil diverifikasi dan akun dikirim via email'
        ]);
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'alasan' => 'required|min:5'
        ]);

        $usaha = MitraUsaha::findOrFail($id);

            $usaha = MitraUsaha::findOrFail($id);

        Mail::to($usaha->email)
            ->send(new AdminUsahaRejectedMail($usaha, $request->alasan));

        if ($usaha->bukti_usaha && Storage::disk('public')->exists($usaha->bukti_usaha)) {
            Storage::disk('public')->delete($usaha->bukti_usaha);
        }
        $usaha->delete();

        return redirect()
            ->route('superadmin.usaha.index')
            ->with('toast_success', 'Usaha ditolak, data dihapus & email penolakan dikirim');

    }

}