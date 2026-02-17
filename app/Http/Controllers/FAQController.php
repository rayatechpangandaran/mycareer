<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class FAQController extends Controller
{
    public function index()
    {
        $faqs = Faq::orderBy('order')->get();
        return view('superadmin.faqs.list', compact('faqs'));
    }

    public function create()
    {
        return view('superadmin.faqs.create');
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'question' => 'required',
            'answer'   => 'required',
            'order'    => ['required','integer', Rule::unique('faqs', 'order')],
        ], [
            'question.required' => 'Pertanyaan wajib diisi.',
            'answer.required'   => 'Jawaban wajib diisi.',
            'order.required'    => 'Urutan wajib diisi.',
            'order.integer'     => 'Urutan harus berupa angka.',
            'order.unique'      => 'Urutan sudah dipakai, silakan pilih yang lain.',
        ]);

        
        Faq::create([
            'question'  => $request->question,
            'answer'    => $request->answer,
            'slug'      => Str::slug($request->question),
            'order'     => $request->order,
            'is_active' => $request->is_active ?? 1,
        ]);

        return redirect()->route('faqs.index')
            ->with('toast_success', 'FAQ berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $faq = Faq::findOrFail($id);
        return view('superadmin.faqs.edit', compact('faq'));
    }


    public function update(Request $request, Faq $faq)
    {
        
        $request->validate([
            'question' => 'required',
            'answer'   => 'required',
            'order'    => [
                'required',
                'integer',
                Rule::unique('faqs', 'order')->ignore($faq->id), 
            ],
        ], [
            
            'question.required' => 'Pertanyaan wajib diisi.',
            'answer.required'   => 'Jawaban wajib diisi.',
            'order.required'    => 'Urutan wajib diisi.',
            'order.integer'     => 'Urutan harus berupa angka.',
            'order.unique'      => 'Urutan sudah dipakai, silakan pilih yang lain.',
        ]);

        
        $faq->update([
            'question'  => $request->question,
            'answer'    => $request->answer,
            'slug'      => Str::slug($request->question),
            'order'     => $request->order,
            'is_active' => $request->is_active ?? 0,
        ]);

        
        return redirect()
            ->route('faqs.index')
            ->with('toast_success', 'FAQ berhasil diupdate!');
    }


    public function destroy(string $id)
    {
        $faq = Faq::findOrFail($id);
        $faq->delete();

        return redirect()
            ->route('faqs.index')
            ->with('toast_success', 'FAQ berhasil dihapus');
    }
}