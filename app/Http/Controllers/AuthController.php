<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;
use App\Mail\ResetPasswordMail;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $remember = $request->has('remember');
        if (!Auth::attempt($request->only('email', 'password'),$remember)) {
            return back()
                ->with('toast_error', 'Email atau password salah')
                ->withInput();
        }


        $request->session()->regenerate();

        $user = Auth::user();

        if (!$user) {
            Auth::logout();
            return redirect()->route('login')
                ->withErrors(['email' => 'Session error, silakan login ulang']);
        }

        return match ($user->role) {
            'superadmin'  => redirect()->route('superadmin.dashboard')
            ->with('toast_success', 'Login berhasil, selamat datang!'),
            'admin_usaha' => redirect()->route('admin_usaha.dashboard')
            ->with('toast_success', 'Login berhasil, selamat datang!'),
            default       => redirect('/lamaran'),
        };

    }

    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        $code = rand(100000, 999999);

        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'pelamar',
            'verification_code' => $code,
        ]);

        Mail::send('emails.verify-code', [
            'user' => $user,
            'code' => $code,
        ], function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Kode Verifikasi Akun JobLoker');
        });

        session(['verify_user_id' => $user->user_id, 'verify_email' => $user->email]);
        return redirect()->route('verify.form')
            ->with('success', 'Kode verifikasi telah dikirim ke email');
    }

    public function showVerify()
    {
        return view('auth.verify');
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'code' => 'required|string'
        ]);

        $userId = session('verify_user_id');

        if (!$userId) {
            return redirect()->route('register')
                ->with('toast_error', 'Session verifikasi habis');
        }

        $user = User::find($userId);

        if (!$user) {
            return redirect()->route('register')
                ->with('toast_error', 'User tidak ditemukan');
        }

        if ((string)$user->verification_code !== trim($request->code)) {
            return back()->with('toast_error', 'Kode verifikasi salah');
        }

        $user->update([
            'email_verified_at' => now(),
            'verification_code' => null,
        ]);

        session()->forget(['verify_user_id', 'verify_email']);

        Auth::login($user);

        return redirect()->route('home')
            ->with('toast_success', 'Akun berhasil diverifikasi 🎉');
    }


     public function forgotForm()
    {
        return view('auth.forgot_password');
    }

    public function sendReset(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $token = Str::random(64);

        $user = User::where('email', $request->email)->first();

        $user->update([
            'reset_token' => $token,
            'reset_token_expired_at' => now()->addMinutes(60)
        ]);

        Mail::to($user->email)->send(
            new ResetPasswordMail($token)
        );

        return back()->with('toast_success', 'Link reset password dikirim ke email');
    }

    
    
    
    public function resetForm($token)
    {
        $user = User::where('reset_token', $token)
            ->where('reset_token_expired_at', '>', now())
            ->first();

        abort_if(!$user, 404);

        return view('auth.reset_password', compact('token', 'user'));
    }

    
    
    
    public function resetUpdate(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'password' => 'required|min:6|confirmed'
        ]);

        $user = User::where('reset_token', $request->token)
            ->where('reset_token_expired_at', '>', now())
            ->first();

        if (!$user) {
            return redirect()->route('password.request')
                ->withErrors(['toast_error' => 'Token tidak valid atau kadaluarsa']);
        }

        $user->update([
            'password' => Hash::make($request->password),
            'reset_token' => null,
            'reset_token_expired_at' => null
        ]);

        return redirect()
            ->route('login')
            ->with('toast_success', 'Password berhasil diganti, silakan login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Berhasil logout');
    }
}