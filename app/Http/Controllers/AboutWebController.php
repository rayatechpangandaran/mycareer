<?php
namespace App\Http\Controllers;

use App\Models\AboutWeb;
use Illuminate\Http\Request;

class AboutWebController extends Controller
{
    // PUBLIC: halaman About
    public function show()
    {
        $about = AboutWeb::first();
        return view('public.about.index', compact('about'));
    }

    // SUPERADMIN: index dashboard
    public function index()
    {
        $about = AboutWeb::first();
        return view('superadmin.about.index', compact('about'));
    }

    // SUPERADMIN: form edit
   public function edit()
{
    $about = AboutWeb::first();

    if (!$about) {
        $about = AboutWeb::create([
            'title' => '',
            'description' => '',
            'vision' => '',
            'mission' => '',
        ]);
    }

    return view('superadmin.about.edit', compact('about'));
}


    // SUPERADMIN: update data
    public function update(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'vision' => 'nullable|string',
            'mission' => 'nullable|string',
        ]);

        $about = AboutWeb::first();

        if ($about) {
            $about->update($validated);
            $message = 'Data Tentang Web berhasil diperbarui!';
        } else {
            AboutWeb::create($validated);
            $message = 'Data Tentang Web berhasil ditambahkan!';
        }

        return redirect()->route('superadmin.about.index')->with('success', $message);
    }
}
