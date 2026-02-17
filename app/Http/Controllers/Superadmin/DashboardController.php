<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;


class DashboardController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        $sixMonthsAgo = Carbon::now()->subMonths(6);

        // 1. STATISTIK RINGKAS
        $stats = [
            'totalMitra'    => DB::table('mitra_usaha')->where('is_verify',1)->count(),
            'totalLowongan' => DB::table('tb_lowongan')->count(),
            'totalUsers'    => DB::table('users')->where('role','!=', 'superadmin')->count(),
            'totalArtikel'  => DB::table('articles')->count(),
        ];

        // 2. DATA TREN (User vs Lowongan)
        $trendUserRaw = DB::table('users')
            ->select(DB::raw('MONTH(created_at) as bulan'), DB::raw('count(*) as total'))
            ->where('role', '!=','superadmin')
            ->where('created_at', '>=', $sixMonthsAgo)
            ->groupBy('bulan')->get()->pluck('total', 'bulan');

        $trendLokerRaw = DB::table('tb_lowongan')
            ->select(DB::raw('MONTH(created_at) as bulan'), DB::raw('count(*) as total'))
            ->where('created_at', '>=', $sixMonthsAgo)
            ->groupBy('bulan')->get()->pluck('total', 'bulan');

        $labels = [];
        $dataUser = [];
        $dataLoker = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthNum = $date->month;
            $labels[] = $date->translatedFormat('F'); 
            $dataUser[] = $trendUserRaw[$monthNum] ?? 0;
            $dataLoker[] = $trendLokerRaw[$monthNum] ?? 0;
        }

        // 3. DATA STATUS (Donut Chart)
        $statusLowongan = DB::table('tb_lowongan')
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')->get();

        // 4. TABEL TERBARU
        $lowonganTerbaru = DB::table('tb_lowongan as l')
            ->join('mitra_usaha as m', 'l.perusahaan_id', '=', 'm.usaha_id')
            ->select('l.judul', 'm.nama_bisnis_usaha', 'l.created_at', 'l.status','l.id')
            ->orderBy('l.created_at', 'desc')
            ->limit(5)->get();

        return view('superadmin.dashboard', compact('stats', 'labels', 'dataUser', 'dataLoker', 'statusLowongan', 'lowonganTerbaru'));
    }

    public function profile()
    {
        return view('superadmin.profile');
    }
    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'nama' => 'required|string|max:255',
            'password' => 'nullable|confirmed|min:6'
        ]);

        $user->nama = $request->nama;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        Auth::login($user);

        return redirect()->route('superadmin.profile')
            ->with('toast_success', 'Profile berhasil diperbarui.');
    }

}