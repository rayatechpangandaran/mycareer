<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Lowongan;
use App\Models\MitraUsaha;

class LowonganController extends Controller
{
    /* =====================================================
     |  HELPER SLUG UNIK (TAMBAHAN AMAN)
     ===================================================== */
    private function generateUniqueSlug($judul, $ignoreId = null)
    {
        $baseSlug = Str::slug($judul);
        $slug = $baseSlug;
        $counter = 1;

        while (
            DB::table('tb_lowongan')
                ->where('slug', $slug)
                ->when($ignoreId, function ($q) use ($ignoreId) {
                    $q->where('id', '!=', $ignoreId);
                })
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /* =====================================================
     |  MITRA USAHA
     ===================================================== */

public function index(Request $request)
{
    $usaha = MitraUsaha::where('email', Auth::user()->email)->first();

    if (!$usaha) {
        return back()->withErrors(['usaha' => 'Data usaha tidak ditemukan']);
    }

    $filter = $request->get('filter'); 

    $query = Lowongan::withTrashed()
        ->where('perusahaan_id', $usaha->usaha_id);

    if ($filter === 'publish') {
        $query->where('status', 'Publish')->whereNull('deleted_at');
    } elseif ($filter === 'draft') {
        $query->where('status', 'Draft')->whereNull('deleted_at');
    } elseif ($filter === 'rejected') {
        $query->where('status', 'Rejected')->whereNull('deleted_at');
    } elseif ($filter === 'trash') {
        $query->onlyTrashed();
    }

    $lowongans = $query
        ->orderByRaw('deleted_at IS NOT NULL') // trash di bawah
        ->orderBy('created_at', 'desc')
        ->get();

    return view('admin_usaha.lowongan.index', compact('lowongans', 'filter'));
}


    public function create()
    {
        return view('admin_usaha.lowongan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'tipe_pekerjaan' => 'required|in:Fulltime,Parttime,Magang,Freelance,Kontrak',
            'pendidikan_terakhir' => 'required|string|max:255',
            'jurusan' => 'nullable|string|max:255',
            'lokasi' => 'required|string|max:255',
            'deskripsi' => 'required',
            'kualifikasi' => 'required',
            'gaji_min' => 'nullable|numeric',
            'gaji_max' => 'nullable|numeric',
            'jumlah_lowongan' => 'required|integer|min:1',
            'deadline' => 'required|date',
            'brosur' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $usaha = MitraUsaha::where('email', Auth::user()->email)->first();
        if (!$usaha) {
            return back()->withErrors(['usaha' => 'Akun anda belum terdaftar sebagai Mitra Usaha.']);
        }

        $jurusan = $request->jurusan;

        if (!in_array($request->pendidikan_terakhir, ['D3', 'S1', 'S2', 'S3'])) {
            $jurusan = null;
        }

        $brosurPath = $request->hasFile('brosur')
            ? $request->file('brosur')->store('brosur_lowongan', 'public')
            : 'assets/img/brosur/brosur-default.png';

        Lowongan::create([
            'judul' => $request->judul,
            'slug' => $this->generateUniqueSlug($request->judul),
            'perusahaan_id' => $usaha->usaha_id,
            'kategori' => $request->kategori,
            'tipe_pekerjaan' => $request->tipe_pekerjaan,
            'pendidikan_terakhir' => $request->pendidikan_terakhir,
            'jurusan' => $jurusan,
            'lokasi' => $request->lokasi,
            'deskripsi' => $request->deskripsi,
            'kualifikasi' => $request->kualifikasi,
            'gaji_min' => $request->gaji_min,
            'gaji_max' => $request->gaji_max,
            'jumlah_lowongan' => $request->jumlah_lowongan,
            'deadline' => $request->deadline,
            'brosur' => $brosurPath,
            'status' => 'Draft',
            'created_by' => Auth::user()->user_id,
        ]);

        return redirect()->route('admin_usaha.lowongan.index')->with('swal', [
            'toast' => false,
            'type' => 'success',
            'title' => 'Berhasil!',
            'text' => 'Lowongan Berhasil Ditambahkan'
        ]);
    }

public function edit($id)
{
    $lowongan = Lowongan::findOrFail($id);
    $usaha = MitraUsaha::where('email', Auth::user()->email)->first();

    if (!$usaha || $lowongan->perusahaan_id != $usaha->usaha_id) {
        return redirect()
            ->route('admin_usaha.lowongan.index')
            ->with('swal', [
                'type' => 'error',
                'title' => 'Akses Ditolak',
                'text' => 'Anda tidak memiliki akses ke lowongan ini'
            ]);
    }

    if ($lowongan->status !== 'Draft') {
        return redirect()
            ->route('admin_usaha.lowongan.index')
            ->with('swal', [
                'type' => 'warning',
                'title' => 'Tidak Bisa Diedit',
                'text' => 'Lowongan yang sudah dipublish atau diproses tidak dapat diedit'
            ]);
    }

    return view('admin_usaha.lowongan.edit', compact('lowongan'));
}


    public function update(Request $request, $id)
    {
        $lowongan = Lowongan::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'tipe_pekerjaan' => 'required|in:Fulltime,Parttime,Magang,Freelance,Kontrak',
            'pendidikan_terakhir' => 'required|string|max:255',
            'jurusan' => 'nullable|string|max:255',
            'lokasi' => 'required|string|max:255',
            'deskripsi' => 'required',
            'kualifikasi' => 'required',
            'gaji_min' => 'nullable|numeric',
            'gaji_max' => 'nullable|numeric',
            'jumlah_lowongan' => 'required|integer|min:1',
            'deadline' => 'required|date',
            'brosur' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $jurusan = $request->jurusan;

        if (!in_array($request->pendidikan_terakhir, ['D3','S1','S2','S3'])) {
            $jurusan = null;
        }

        $brosurPath = $lowongan->brosur;
        if ($request->hasFile('brosur')) {
            if ($lowongan->brosur != 'assets/img/brosur/brosur-default.png') {
                Storage::disk('public')->delete($lowongan->brosur);
            }
            $brosurPath = $request->file('brosur')->store('brosur_lowongan', 'public');
        }

        $lowongan->update([
            'judul' => $request->judul,
            'slug' => $this->generateUniqueSlug($request->judul, $lowongan->id),
            'kategori' => $request->kategori,
            'tipe_pekerjaan' => $request->tipe_pekerjaan,
            'pendidikan_terakhir' => $request->pendidikan_terakhir,
            'jurusan' => $jurusan,
            'lokasi' => $request->lokasi,
            'deskripsi' => $request->deskripsi,
            'kualifikasi' => $request->kualifikasi,
            'gaji_min' => $request->gaji_min,
            'gaji_max' => $request->gaji_max,
            'jumlah_lowongan' => $request->jumlah_lowongan,
            'deadline' => $request->deadline,
            'brosur' => $brosurPath,
        ]);

        return redirect()->route('admin_usaha.lowongan.index')->with('swal', [
            'toast' => false,
            'type' => 'success',
            'title' => 'Berhasil!',
            'text' => 'Lowongan Berhasil Diperbarui'
        ]);
    }

    public function show($id)
    {
        $lowongan = Lowongan::with('perusahaan')->findOrFail($id);
        return view('admin_usaha.lowongan.show', compact('lowongan'));
    }
   
   
    public function updateStatusSuperadmin(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Publish,Rejected',
        ]);

        $lowongan = Lowongan::findOrFail($id);
        $lowongan->status = $request->status;
        $lowongan->save();

        // Pilih pesan dan tipe toast
        if($request->status === 'Publish'){
            $toastType = 'toast_success';
            $toastMsg  = 'Lowongan berhasil dipublish!';
        } else { // Rejected
            $toastType = 'toast_error'; // bisa diganti toast_warning juga
            $toastMsg  = 'Lowongan Ditolak / Rejected!';
        }

        return redirect()->route('superadmin.lowongan.index')
            ->with($toastType, $toastMsg);
    }
    public function destroy($id)
{
    $lowongan = Lowongan::findOrFail($id);
    $usaha = MitraUsaha::where('email', Auth::user()->email)->first();

    // Cek akses
    if (!$usaha || $lowongan->perusahaan_id != $usaha->usaha_id) {
        return back()->with('swal', [
            'toast' => false,
            'type'  => 'error',
            'title' => 'Akses Ditolak',
            'text'  => 'Anda tidak punya akses ke lowongan ini'
        ]);
    }

    // Soft delete (masuk riwayat)
    $lowongan->delete();

    return redirect()->route('admin_usaha.lowongan.index')
        ->with('swal', [
            'toast' => false,
            'type'  => 'success',
            'title' => 'Berhasil',
            'text'  => 'Lowongan berhasil dipindahkan ke riwayat'
        ]);
}



    /* =====================================================
     |  SUPERADMIN
     ===================================================== */

    public function indexSuperadmin()
    {
        $lowongans = Lowongan::orderBy('created_at', 'desc')->get();
        return view('superadmin.lowongan.index', compact('lowongans'));
    }

    public function createSuperadmin()
    {
        $perusahaan = MitraUsaha::where('is_verify', 1)->get();

        return view('superadmin.lowongan.create', compact('perusahaan'));
    }

    public function storeSuperadmin(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'tipe_pekerjaan' => 'required|in:Fulltime,Parttime,Magang,Freelance,Kontrak',
            'pendidikan_terakhir' => 'required|string|max:255',
            'jurusan' => 'nullable|string|max:255',
            'lokasi' => 'required|string|max:255',
            'deskripsi' => 'required',
            'kualifikasi' => 'required',
            'gaji_min' => 'nullable|numeric',
            'gaji_max' => 'nullable|numeric',
            'jumlah_lowongan' => 'required|integer|min:1',
            'deadline' => 'required|date',
            'brosur' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'perusahaan_id' => 'required|exists:mitra_usaha,usaha_id',
        ]);

        $jurusan = $request->jurusan;

        if (!in_array($request->pendidikan_terakhir, ['D3', 'S1', 'S2', 'S3'])) {
            $jurusan = null;
        }

        $brosurPath = $request->hasFile('brosur')
            ? $request->file('brosur')->store('brosur_lowongan', 'public')
            : 'assets/img/brosur/brosur-default.png';

        Lowongan::create([
            'judul' => $request->judul,
            'slug' => $this->generateUniqueSlug($request->judul),
            'perusahaan_id' => $request->perusahaan_id,
            'kategori' => $request->kategori,
            'tipe_pekerjaan' => $request->tipe_pekerjaan,
            'pendidikan_terakhir' => $request->pendidikan_terakhir,
            'jurusan' => $jurusan,
            'lokasi' => $request->lokasi,
            'deskripsi' => $request->deskripsi,
            'kualifikasi' => $request->kualifikasi,
            'gaji_min' => $request->gaji_min ?? 0,
            'gaji_max' => $request->gaji_max ?? 0,
            'jumlah_lowongan' => $request->jumlah_lowongan,
            'deadline' => $request->deadline,
            'brosur' => $brosurPath,
            'status' => 'Draft',
            'created_by' => Auth::user()->user_id,
        ]);

        return redirect()->route('superadmin.lowongan.index')
            ->with('toast_success', 'Lowongan berhasil ditambahkan!');
    }

        public function editSuperadmin($id)
        {
            $lowongan = Lowongan::findOrFail($id);
            $perusahaan = MitraUsaha::where('is_verify', 1)->get();
            return view('superadmin.lowongan.edit', compact('lowongan', 'perusahaan'));
        }

        public function updateSuperadmin(Request $request, $id)
        {
            $request->validate([
                'judul' => 'required|string|max:255',
                'kategori' => 'required|string|max:255',
                'tipe_pekerjaan' => 'required|in:Fulltime,Parttime,Magang,Freelance,Kontrak',
                'pendidikan_terakhir' => 'required|string|max:255',
                'jurusan' => 'nullable|string|max:255',
                'lokasi' => 'required|string|max:255',
                'deskripsi' => 'required',
                'kualifikasi' => 'required',
                'gaji_min' => 'nullable|numeric',
                'gaji_max' => 'nullable|numeric',
                'jumlah_lowongan' => 'required|integer|min:1',
                'deadline' => 'required|date',
                'brosur' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
                'perusahaan_id' => 'required|exists:mitra_usaha,usaha_id',
            ]);

            $lowongan = Lowongan::findOrFail($id);
           
            $jurusan = $request->jurusan;

            if (!in_array($request->pendidikan_terakhir, ['D3','S1','S2','S3'])) {
                $jurusan = null;
            }

            // Upload brosur
            if ($request->hasFile('brosur')) {
                if ($lowongan->brosur && $lowongan->brosur != 'assets/img/brosur/brosur-default.png') {
                    Storage::disk('public')->delete($lowongan->brosur);
                }
                $brosurPath = $request->file('brosur')->store('brosur_lowongan', 'public');
            } else {
                $brosurPath = $lowongan->brosur;
            }

            $lowongan->update([
                'judul' => $request->judul,
                'slug' => Str::slug($request->judul),
                'perusahaan_id' => $request->perusahaan_id,
                'kategori' => $request->kategori,
                'tipe_pekerjaan' => $request->tipe_pekerjaan,
                'pendidikan_terakhir' => $request->pendidikan_terakhir,
                'jurusan' => $jurusan,
                'lokasi' => $request->lokasi,
                'deskripsi' => $request->deskripsi,
                'kualifikasi' => $request->kualifikasi,
                'gaji_min' => $request->gaji_min,
                'gaji_max' => $request->gaji_max,
                'jumlah_lowongan' => $request->jumlah_lowongan,
                'deadline' => $request->deadline,
                'brosur' => $brosurPath,
            ]);
        return redirect()->route('superadmin.lowongan.index')
            ->with('toast_success', 'Lowongan berhasil diperbaharui!');
        }

        public function showSuperadmin($id)
        {
            $lowongan = Lowongan::with('perusahaan')->findOrFail($id);
            return view('superadmin.lowongan.show', compact('lowongan'));
        }


}