<?php

namespace App\Http\Controllers;

use App\Mail\UserCreatedMail;
use App\Models\MitraUsaha;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {               
        $perPage = 8; 
        $page = $request->get('page', 1);

        $total = DB::table('users')->count();

        $user = DB::table('users')
            ->where('role', '!=', 'superadmin')
            ->orderBy('created_at','DESC')
            ->offset(($page - 1) * $perPage)
            ->limit($perPage)
            ->get();

        $totalPages = ceil($total / $perPage);

        return view('superadmin.user.index',compact('user', 'page', 'totalPages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mitra = MitraUsaha::whereNull('user_id')
            ->get();

        return view('superadmin.user.create', compact('mitra'));
    }

    public function getMitra($id)
    {
        return DB::table('mitra_usaha')
            ->where('usaha_id', $id)
            ->first();
    }

    /**
     * Store a newly created resource in storage.
     */
     public function store(Request $request)
    {
        $request->validate([
            'mitra_id' => 'required'
        ]);

        $mitra = DB::table('mitra_usaha')->where('usaha_id', $request->mitra_id)->first();

        $passwordPlain = Str::random(8);

        $userId = DB::table('users')->insertGetId([
            'nama' => $mitra->nama_bisnis_usaha,
            'email' => $mitra->email,
            'password' => Hash::make($passwordPlain),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('mitra_usaha')
            ->where('usaha_id', $mitra->usaha_id)
            ->update(['user_id' => $userId]);

        Mail::to($mitra->email)->send(new UserCreatedMail(
            $mitra->nama_bisnis_usaha,
            $mitra->email,
            $passwordPlain
        ));

        return redirect()->route('users.index')->with('toast_success', 'User berhasil dibuat & email terkirim');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}