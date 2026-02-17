<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MitraUsaha;
use Illuminate\Support\Facades\Storage;



class MitraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usaha = MitraUsaha::orderBy('created_at', 'desc')->where('is_verify',1)->get();
        return view('superadmin.mitra.index', compact('usaha'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('superadmin.mitra.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         try {
            $request->validate([
                'nama_bisnis_usaha'      => 'required|string|max:255',
                'jenis_usaha'            => 'required',
                'nama_penanggung_jawab'  => 'required|string|max:255',
                'email'                  => 'required|email|unique:mitra_usaha,email',
                'no_wa'                  => 'required',
                'alamat_lengkap'         => 'required',
                'kota'                   => 'required',
                'bidang_usaha'           => 'required',
                'jml_karyawan'           => 'required',
                'nib'                    => 'nullable',
                'bukti_usaha'            => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            ]);

            $buktiPath = $request->file('bukti_usaha')->store('bukti-usaha', 'public');

            MitraUsaha::create([
                'nama_bisnis_usaha'     => $request->nama_bisnis_usaha,
                'deskripsi_perusahaan'  => '-',
                'jenis_usaha'           => $request->jenis_usaha,
                'nama_penanggung_jawab' => $request->nama_penanggung_jawab,
                'email'                 => $request->email,
                'user_id'               => null,
                'no_wa'                 => $request->no_wa,
                'alamat_lengkap'        => $request->alamat_lengkap,
                'kota'                  => $request->kota,
                'bidang_usaha'          => $request->bidang_usaha,
                'jml_karyawan'          => $request->jml_karyawan,
                'nib'                   => $request->nib,
                'banner_logo_usaha'     => 'banner_logo/logo_mitraUsaha.png',
                'bukti_usaha'           => $buktiPath,
                'is_verify'             => 1, 
            ]);

            return redirect()->route('mitra.index')
                ->with('toast_success', 'Pendaftaran berhasil, Silahkan untuk lanjutkan buat akun');
        } catch (\Exception $e) {
             return redirect()->back()
                ->with('toast_error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $usaha = MitraUsaha::findOrFail($id);
        return view('superadmin.mitra.show', compact('usaha'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $usaha = MitraUsaha::findOrFail($id);
        return view('superadmin.mitra.edit', compact('usaha'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $usaha = MitraUsaha::findOrFail($id);

        try {
            $request->validate([
                'nama_bisnis_usaha'      => 'required|string|max:255',
                'jenis_usaha'            => 'required',
                'nama_penanggung_jawab'  => 'required|string|max:255',
                'email'                  => 'required|email|unique:mitra_usaha,email,' . $id, 
                'no_wa'                  => 'required',
                'alamat_lengkap'         => 'required',
                'kota'                   => 'required',
                'bidang_usaha'           => 'required',
                'jml_karyawan'           => 'required',
                'nib'                    => 'nullable',
                'bukti_usaha'            => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048', // ubah jadi nullable
            ]);

            // cek apakah user upload file baru
            if ($request->hasFile('bukti_usaha')) {
                // hapus file lama jika ada
                if ($usaha->bukti_usaha && Storage::disk('public')->exists($usaha->bukti_usaha)) {
                    Storage::disk('public')->delete($usaha->bukti_usaha);
                }

                // simpan file baru
                $buktiPath = $request->file('bukti_usaha')->store('bukti-usaha', 'public');
            } else {
                // pakai file lama
                $buktiPath = $usaha->bukti_usaha;
            }

            $usaha->update([
                'nama_bisnis_usaha'     => $request->nama_bisnis_usaha,
                'deskripsi_perusahaan'  => '-',
                'jenis_usaha'           => $request->jenis_usaha,
                'nama_penanggung_jawab' => $request->nama_penanggung_jawab,
                'email'                 => $request->email,
                'no_wa'                 => $request->no_wa,
                'alamat_lengkap'        => $request->alamat_lengkap,
                'kota'                  => $request->kota,
                'bidang_usaha'          => $request->bidang_usaha,
                'jml_karyawan'          => $request->jml_karyawan,
                'nib'                   => $request->nib,
                'banner_logo_usaha'     => null,
                'bukti_usaha'           => $buktiPath,
                'is_verify'             => 1, 
            ]);

            return redirect()->route('superadmin.mitra.index')
                ->with('toast_success', 'Perubahan berhasil, Mitra Usaha telah update');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('toast_error', 'Perubahan Gagal: ' . $e->getMessage());
        }


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    $usaha = MitraUsaha::findOrFail($id);

        try {
            if ($usaha->bukti_usaha && Storage::disk('public')->exists($usaha->bukti_usaha)) {
                Storage::disk('public')->delete($usaha->bukti_usaha);
            }

            $usaha->delete();

            return redirect()->route('mitra.index')
                ->with('toast_success', 'Mitra Usaha berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('toast_error', 'Gagal menghapus data');
        }
    }
}