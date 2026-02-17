<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;


class ContactController extends Controller
{

    /* =========================================================
     | PUBLIC (USER)
     |=========================================================*/

    /**
     * Halaman contact public
     */
    public function index()
    {
        return view('public.contact.index');
    }

    /**
     * Simpan pesan dari public
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email|max:100',
            'subject' => 'nullable|string|max:150',
            'message' => 'required|string',
        ]);

        Contact::create($validated);

        return back()->with('success', 'Pesan berhasil dikirim.');
    }

    /* =========================================================
     | ADMIN
     |=========================================================*/

    /**
     * List semua pesan
     */
    public function adminIndex()
    {
        $contacts = Contact::latest()->paginate(10);
        return view('superadmin.contact.index', compact('contacts'));
    }

    /**
     * Detail pesan
     */
    public function show(Contact $contact)
    {
        if (!$contact->is_read) {
            $contact->update(['is_read' => true]);
        }

        return view('superadmin.contact.show', compact('contact'));
    }

    /**
     * Hapus pesan
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();
        return back()->with('success', 'Pesan berhasil dihapus.');
    }

    /* =========================================================
     | BONUS
     |=========================================================*/

    public function markAsRead(Contact $contact)
    {
        $contact->update(['is_read' => true]);
        return back()->with('success', 'Pesan ditandai sudah dibaca.');
    }

    public function unreadCount()
    {
        return Contact::where('is_read', false)->count();
    }
}
