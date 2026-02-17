<?php

namespace App\Http\Controllers\AdminUsaha;

use App\Http\Controllers\Controller;

use App\Models\MitraUsaha;
use App\Models\Lowongan;
use App\Models\Lamaran;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


use Illuminate\Http\Request;

class AdminUDashboardController extends Controller
{
public function index()
{
    $user = Auth::user();
    $namaUsaha = MitraUsaha::where('user_id', $user->user_id)->first();

    if (!$namaUsaha) {
        abort(404);
    }

    // Statistik
    $totalLowongan = Lowongan::where('perusahaan_id', $namaUsaha->usaha_id)
                    ->where('status', 'Publish')
                    ->count();

    $totalLamaran = Lamaran::where('perusahaan_id', $namaUsaha->usaha_id)->count();

    $lamaranDiterima = Lamaran::where('perusahaan_id', $namaUsaha->usaha_id)
                        ->where('status', 'Diterima')
                        ->count();

    $lamaranDitolak = Lamaran::where('perusahaan_id', $namaUsaha->usaha_id)
                        ->where('status', 'Ditolak')
                        ->count();

    $lamaranDiproses = Lamaran::where('perusahaan_id', $namaUsaha->usaha_id)
                        ->where('status', 'Dikirim')
                        ->count();

    // Progress penerimaan
    $progressRekrutmen = $totalLamaran > 0
        ? round(($lamaranDiterima / $totalLamaran) * 100)
        : 0;

    // Lowongan terbaru
    $lowonganTerbaru = Lowongan::where('perusahaan_id', $namaUsaha->usaha_id)
                        ->latest()
                        ->take(5)
                        ->get();

    // Lamaran terbaru
    $lamaranTerbaru = Lamaran::with(['pelamar','lowongan'])
                        ->where('perusahaan_id', $namaUsaha->usaha_id)
                        ->latest()
                        ->take(5)
                        ->get();

    return view('admin_usaha.dashboard', compact(
        'namaUsaha',
        'totalLowongan',
        'totalLamaran',
        'lamaranDiterima',
        'lamaranDitolak',
        'lamaranDiproses',
        'progressRekrutmen',
        'lowonganTerbaru',
        'lamaranTerbaru'
    ));
}
}