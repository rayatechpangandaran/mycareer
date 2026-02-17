<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Carousel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarouselController extends Controller
{
    public function index()
    {
        $carousels = Carousel::latest()->get();
        return view('superadmin.carousel.index', compact('carousels'));
    }

    public function create()
    {
        return view('superadmin.carousel.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active' => 'nullable'
        ]);

        $imagePath = $request->file('image')->store('carousels', 'public');

        Carousel::create([
            'image' => $imagePath,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('superadmin.carousel.index')
            ->with('toast_success', 'Carousel berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $carousel = Carousel::findOrFail($id);
        return view('superadmin.carousel.edit', compact('carousel'));
    }

    public function update(Request $request, $id)
    {
        $carousel = Carousel::findOrFail($id);

        $request->validate([
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'is_active' => 'nullable'
        ]);

        if ($request->hasFile('image')) {
            if ($carousel->image && Storage::disk('public')->exists($carousel->image)) {
                Storage::disk('public')->delete($carousel->image);
            }
            $carousel->image = $request->file('image')->store('carousels', 'public');
        }

        $carousel->is_active = $request->has('is_active');
        $carousel->save();

        return redirect()->route('superadmin.carousel.index')
            ->with('success', 'Carousel berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $carousel = Carousel::findOrFail($id);

        if ($carousel->image && Storage::disk('public')->exists($carousel->image)) {
            Storage::disk('public')->delete($carousel->image);
        }

        $carousel->delete();

        return redirect()->route('superadmin.carousel.index')
            ->with('toast_success', 'Carousel berhasil dihapus!');
    }
}