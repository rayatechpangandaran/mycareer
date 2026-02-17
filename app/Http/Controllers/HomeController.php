<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\MitraUsaha;
use App\Models\Lowongan;
use App\Models\PelamarDetail;
use App\Models\Lamaran;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Carousel;


class HomeController extends Controller
{
    public function index()
    {
        $carouselArtikel = Article::where('status', 'published')
            ->latest('created_at')
            ->limit(3)
            ->get();
       $carousels = Carousel::where('is_active', 1)->latest()->get();

    
        
        $artikelTerbaru = Article::where('status', 'published')
            ->withCount(['likes', 'bookmarks'])
            ->latest('created_at')
            ->limit(5)
            ->get();

        $mitras = MitraUsaha::latest('created_at')->where('is_verify', 1)->get();

        $lowongans = Lowongan::where('status', 'Publish')
            ->with('perusahaan') 
            ->latest('created_at')
            ->get();

        return view('public.home', compact(
            'carouselArtikel',
            'artikelTerbaru',
            'mitras',
            'lowongans',
           'carousels'
        ));
    }

    public function about()
    {
        return view('public.about');
    }

    public function lamaranSaya()
    {
        // pastikan user login
        $userId = Auth::id();

        if (!$userId) {
            return redirect()->route('login');
        }

        // ambil profile pelamar
        $profile = PelamarDetail::firstOrNew([
            'user_id' => $userId
        ]);

        // ambil lamaran
        $lamaran = Lamaran::with([
                'lowongan.perusahaan',
                'pelamar.detail'
            ])
            ->where('pelamar_id', $userId)
            ->latest()
            ->get();

        // rekomendasi lowongan
        $lowonganAll = Lowongan::with('perusahaan')
            ->where('status', 'Publish')
            ->when($profile->pendidikan_terakhir, function ($q) use ($profile) {
                $q->where('pendidikan_terakhir', $profile->pendidikan_terakhir);
            })
            ->get();

        return view('public.lamaranSaya', compact(
            'lamaran',
            'profile',
            'lowonganAll'
        ));
    }


    public function updateProfilPelamar(Request $request)
    {
        $userId = Auth::user()->user_id;

        $request->validate([
            'pendidikan_terakhir' => 'nullable|string|max:255',
            'jurusan' => 'nullable|string|max:255',
            'keahlian' => 'nullable|array',
            'cv' => 'nullable|file|mimes:pdf|max:4096',
            'no_wa' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
        ]);

        $existingProfile = PelamarDetail::where('user_id', $userId)->first();

        // DATA DASAR
        $data = [
            'pendidikan_terakhir' => $request->pendidikan_terakhir,
            'jurusan' => $request->jurusan,
            'keahlian' => $request->keahlian ? implode(',', $request->keahlian) : null,
            'no_wa' => $request->no_wa,
        ];

        if (!empty($request->alamat)) {
            $data['alamat'] = $request->alamat;
        } elseif ($existingProfile) {
            $data['alamat'] = $existingProfile->alamat;
        }

        // HANDLE UPLOAD CV
        if ($request->hasFile('cv')) {
            if ($existingProfile && $existingProfile->cv && Storage::disk('public')->exists($existingProfile->cv)) {
                Storage::disk('public')->delete($existingProfile->cv);
            }

            $data['cv'] = $request->file('cv')->store('cv_pelamar', 'public');
        }

        // UPDATE OR CREATE
        PelamarDetail::updateOrCreate(
            ['user_id' => $userId],
            $data
        );

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');

    }


    public function lamaranDetail($id)
    {
        $userId = Auth::id(); 
        $lowongan = Lowongan::with('perusahaan')->findOrFail($id);

        $lowonganAll = Lowongan::latest('created_at')
            ->limit(5)
            ->with('perusahaan')
            ->where('status','Publish')
            ->get();

        $profile = PelamarDetail::firstOrNew(['user_id' => $userId]);

        $sudahMelamar = Lamaran::where('lowongan_id', $lowongan->id)
            ->where('pelamar_id', $userId)
            ->exists();

        return view('public.lamaranDetail', compact('lowongan', 'lowonganAll', 'profile', 'sudahMelamar'));
    }
    
    public function lamaranDetailJson($id)
    {
        try {

        $lamaran = Lamaran::with('lowongan.perusahaan')
            ->findOrFail($id);

        $lowongan = $lamaran->lowongan;

        return response()->json([
            'success' => true,
            'data' => [
                'judul'       => $lowongan->judul ?? '-',
                'perusahaan'  => optional($lowongan->perusahaan)->nama_bisnis_usaha ?? '-',
                'lokasi'      => $lowongan->lokasi ?? '-',
                'tipe'        => $lowongan->tipe_pekerjaan ?? '-',
                'status'      => $lamaran->status ?? '-',
                'tanggal'     =>  \Carbon\Carbon::parse($lamaran->created_at)
                ->translatedFormat('d F Y'),
                'cv_url' => $lamaran->cv 
                            ? asset('storage/' . $lamaran->cv) 
                            : null,
                'surat_diterima' => $lamaran->surat_diterima 
                            ? asset('storage/' . $lamaran->surat_diterima) 
                            : null,
                'catatan'     => $lamaran->catatan ?? 'Tidak Ada Catatan'           
            ]
        ]);

        } catch (\Throwable $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }



    public function applyLamaran($id)
    {
        $userId = Auth::user()->user_id;
        $profile = PelamarDetail::firstOrNew(['user_id' => $userId]);
        $lowonganAll= Lowongan::latest('created_at')->limit(5)->with('perusahaan')->where('status','Publish')->get();
        $lowongan = Lowongan::with('perusahaan')->findOrFail($id);
        return view('public.formLamar',compact('lowongan','lowonganAll','profile'));
    }

    public function loginComplete()
    {
        return view('public.isLogin');
    }
    public function mitraList()
    {
        $usaha = MitraUsaha::orderBy('created_at', 'desc')->where('is_verify',1)->get();
        return view('public.mitraList', compact('usaha'));
    }
public function lowonganAll()
{
    $userId = Auth::id(); 
    $lowongans = Lowongan::where('status', 'Publish')
        ->with('perusahaan')
        ->get();

    if ($userId) {
        $lamaranUser = Lamaran::where('pelamar_id', $userId)->pluck('lowongan_id')->toArray();
    } else {
        $lamaranUser = [];
    }

    return view('public.lowonganAll', compact('lowongans', 'lamaranUser'));
}

}