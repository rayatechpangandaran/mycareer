<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MitraUsaha;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Mail\MitraUsahaBaruMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class MitraUsahaController extends Controller
{

        public function store(Request $request)
        {
            $request->validate([
                'nama_bisnis_usaha' => 'required|string|max:255',
                'jenis_usaha' => 'required',
                'nama_penanggung_jawab' => 'required|string|max:255',
                'email' => 'required|email|unique:mitra_usaha,email',
                'no_wa' => 'required',
                'alamat_lengkap' => 'required',
                'bidang_usaha' => 'required',
                'banner_logo_usaha' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
                'jml_karyawan' => 'required',
                'nib' => 'nullable',
                'bukti_usaha' => 'required|file|mimes:jpg,jpeg,png,pdf|max:4096',
            ]);

        $buktiPath = $request->file('bukti_usaha')
            ->store('bukti-usaha', 'public');

        $logoPath = null;

        if ($request->hasFile('banner_logo_usaha')) {
            $logoPath = $request->file('banner_logo_usaha')
                ->store('banner_logo', 'public');
        }

            $mitra = MitraUsaha::create([
                'nama_bisnis_usaha'     => $request->nama_bisnis_usaha,
                        'deskripsi_perusahaan'  => '-',
                        'jenis_usaha'           => $request->jenis_usaha,
                        'nama_penanggung_jawab' => $request->nama_penanggung_jawab,
                        'email'                 => $request->email,
                        'no_wa'                 => $request->no_wa,
                        'alamat_lengkap'        => $request->alamat_lengkap,
                        'bidang_usaha'          => $request->bidang_usaha,
                        'jml_karyawan'          => $request->jml_karyawan,
                        'nib'                   => $request->nib,
                        'banner_logo_usaha'     => $logoPath,
                        'bukti_usaha'           => $buktiPath,
                        'is_verify'             => 0, 
            ]);

            Mail::to('aryawgn091202@gmail.com')
                ->send(new MitraUsahaBaruMail($mitra));

            return redirect()->route('login')
                ->with('success', 'Pendaftaran berhasil! Silakan login setelah akun diverifikasi.');
        }

        public function profile()
        {
            $user = Auth::user();
            if (!$user) {
                return redirect()->route('login');
            }

            // Ambil data Mitra Usaha berdasar email user login
            $usaha = MitraUsaha::firstOrNew(['email' => $user->email]);

            return view('admin_usaha.profile.edit', compact('usaha'));
        }

        public function updateProfile(Request $request)
        {
            $usaha = MitraUsaha::firstOrNew(['email' => Auth::user()->email]);

            $request->validate([
                'nama_bisnis_usaha'     => 'required|string|max:255',
                'deskripsi_perusahaan'  => 'nullable|string',
                'jenis_usaha'           => 'required|string|max:255',
                'nama_penanggung_jawab' => 'required|string|max:255',
                'no_wa'                 => 'required|string|max:20',
                'alamat_lengkap'        => 'required|string',
                'bidang_usaha'          => 'required|string|max:255',
                'jml_karyawan'          => 'required|string|max:50',
                'nib'                   => 'nullable|string|max:255',
                'banner_logo_usaha'     => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
                'bukti_usaha'           => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:4096',
            ]);

            // Upload banner/logo jika ada
            if ($request->hasFile('banner_logo_usaha')) {
                if ($usaha->banner_logo_usaha) {
                    Storage::disk('public')->delete($usaha->banner_logo_usaha);
                }
                $usaha->banner_logo_usaha = $request->file('banner_logo_usaha')
                    ->store('banner_logo', 'public');
            }

            // Upload bukti usaha jika ada
            if ($request->hasFile('bukti_usaha')) {
                if ($usaha->bukti_usaha) {
                    Storage::disk('public')->delete($usaha->bukti_usaha);
                }
                $usaha->bukti_usaha = $request->file('bukti_usaha')
                    ->store('bukti-usaha', 'public');
            }

            $usaha->fill([
                'nama_bisnis_usaha'     => $request->nama_bisnis_usaha,
                'deskripsi_perusahaan'  => $request->deskripsi_perusahaan ?? '-',
                'jenis_usaha'           => $request->jenis_usaha,
                'nama_penanggung_jawab' => $request->nama_penanggung_jawab,
                'no_wa'                 => $request->no_wa,
                'alamat_lengkap'        => $request->alamat_lengkap,
                'bidang_usaha'          => $request->bidang_usaha,
                'jml_karyawan'          => $request->jml_karyawan,
                'nib'                   => $request->nib,
            ])->save();

            return redirect()->route('admin_usaha.profile')->with('success', 'Profil berhasil diperbarui.');
        }
}