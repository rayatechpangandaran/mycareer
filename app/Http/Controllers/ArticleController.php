<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{

    public function index()
    {
        $articles = Article::with('author')->latest()->paginate(10);
        return view('superadmin.articles.list', compact('articles'));
    }

    public function create()
    {
        return view('superadmin.articles.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required',
            'status'  => 'required|in:draft,published',
            'thumbnail' => 'nullable|image|max:5120',
        ]);

        $thumbnailPath = $request->file('thumbnail')?->store('thumbnails', 'public');

        $article = Article::create([
            'title'     => $request->title,
            'slug'      => Str::slug($request->title),
            'content'   => $request->content,
            'status'    => $request->status,
            'thumbnail' => $thumbnailPath,
            'author_id' => Auth::user()->user_id,
        ]);

        return redirect()->route('articles.index')
            ->with('toast_success', 'Artikel berhasil dibuat!');
    }


    public function show(string $id)
    {
        $article = Article::with('author', 'likes', 'bookmarks')->findOrFail($id);

        
        $article->increment('views');

        return view('superadmin.articles.detail', compact('article'));
    }


    public function edit(string $id)
    {
        $article = Article::findOrFail($id);
        return view('superadmin.articles.edit', compact('article'));
    }

    public function update(Request $request, string $id)
    {
        $article = Article::findOrFail($id);
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required',
            'status'  => 'required|in:draft,published',
            'thumbnail' => 'nullable|image|max:2048',
        ]);

        $thumbnailPath = $request->file('thumbnail')?->store('thumbnails', 'public') ?? $article->thumbnail;

        $article->update([
            'title'     => $request->title,
            'slug'      => Str::slug($request->title),
            'content'   => $request->content,
            'status'    => $request->status,
            'thumbnail' => $thumbnailPath,
        ]);

        return redirect()->route('articles.index')
            ->with('toast_success', 'Artikel berhasil diupdate!');
    }

    public function destroy(string $id)
    {
        $article = Article::findOrFail($id);
        $article->delete();

        return redirect()->route('articles.index')
            ->with('toast_success', 'Artikel berhasil dihapus!');
    }

    public function toggleLike(string $id)
    {
        $article = Article::findOrFail($id);
        $userId = Auth::user()->user_id;

        $liked = $article->likes()
            ->where('article_likes.user_id', $userId)
            ->exists();

        if ($liked) {
            $article->likes()->detach($userId);
        } else {
            $article->likes()->attach($userId);
        }

        return response()->json([
            'liked' => !$liked,
            'count' => $article->likes()->count(),
        ]);
    }

    public function toggleBookmark(string $id)
    {
        $article = Article::findOrFail($id);
        $userId = Auth::user()->user_id;

        $bookmarked = $article->bookmarks()
            ->where('article_bookmarks.user_id', $userId)
            ->exists();

        if ($bookmarked) {
            $article->bookmarks()->detach($userId);
        } else {
            $article->bookmarks()->attach($userId);
        }

        return response()->json([
            'bookmarked' => !$bookmarked,
            'count' => $article->bookmarks()->count(),
        ]);
    }

public function publicIndex(Request $request)
{
    $filter = $request->get('filter', 'all'); // default: semua artikel
    $query = Article::with('author')->where('status', 'published');

    // SEARCH
    if ($request->filled('q')) {
        $query->where(function ($q) use ($request) {
            $q->where('title', 'like', '%' . $request->q . '%')
              ->orWhere('content', 'like', '%' . $request->q . '%');
        });
    }

    // FILTER BERDASARKAN USER LOGIN
    if (Auth::check()) {
        $user = Auth::user();

        if ($filter === 'liked') {
            $query->whereHas('likes', function ($q) use ($user) {
                $q->where('article_likes.user_id', $user->user_id); // <--- fix ambiguity
            });
        } elseif ($filter === 'bookmarked') {
            $query->whereHas('bookmarks', function ($q) use ($user) {
                $q->where('article_bookmarks.user_id', $user->user_id); // <--- fix ambiguity
            });
        }
    } else {
        // jika belum login, liked/bookmarked tidak bisa
        if (in_array($filter, ['liked', 'bookmarked'])) {
            $query->whereRaw('0=1'); // hasil kosong
        }
    }

    // LIST ARTIKEL UTAMA
    $articles = $query
        ->latest('created_at')
        ->withCount(['likes', 'bookmarks'])
        ->paginate(6)
        ->withQueryString();

    // ARTIKEL POPULER (sidebar)
    $artikelPopuler = Article::with('author')
        ->withCount(['likes', 'bookmarks'])
        ->where('status', 'published')
        ->orderByRaw('(likes_count * 2 + bookmarks_count + views) DESC')
        ->limit(5)
        ->get();

    // ARTIKEL USER (sidebar) — khusus login
    $userLikedArticles = [];
    $userBookmarkedArticles = [];

    if (Auth::check()) {
        $userLikedArticles = $user->likedArticles()
            ->with('author')
            ->withCount(['likes', 'bookmarks'])
            ->latest('created_at')
            ->limit(5)
            ->get();

        $userBookmarkedArticles = $user->bookmarkedArticles()
            ->with('author')
            ->withCount(['likes', 'bookmarks'])
            ->latest('created_at')
            ->limit(5)
            ->get();
    }

    return view('public.articles.index', compact(
        'articles',
        'artikelPopuler',
        'userLikedArticles',
        'userBookmarkedArticles',
        'filter'
    ));
}


public function publicShow($slug)
{
    $article = Article::with('author')
        ->withCount(['likes', 'bookmarks'])
        ->where('slug', $slug)
        ->where('status', 'published')
        ->firstOrFail();

    $article->increment('views');

    $isLiked = $isBookmarked = false;

    if (auth()->check()) {
        $user = auth()->user();
        $isLiked = $article->likes()->wherePivot('user_id', $user->user_id)->exists();
        $isBookmarked = $article->bookmarks()->wherePivot('user_id', $user->user_id)->exists();
    }

    $beritaLainnya = Article::where('status', 'published')
        ->where('id', '!=', $article->id)
        ->latest('created_at')
        ->limit(4)
        ->get();

    return view('public.articles.show', compact('article', 'beritaLainnya', 'isLiked', 'isBookmarked'));
}

public function myLikes()
{
    $user = auth()->user();

    // Ambil artikel yang di-like oleh user
    $articles = $user->likedArticles()->with('author')
        ->withCount(['likes', 'bookmarks'])
        ->latest('created_at')
        ->paginate(6)
        ->withQueryString();

    return view('public.articles.my_articles', [
        'articles' => $articles,
        'title' => 'Artikel yang Saya Sukai',
    ]);
}

public function myBookmarks()
{
    $user = auth()->user();

    // Ambil artikel yang di-bookmark oleh user
    $articles = $user->bookmarkedArticles()->with('author')
        ->withCount(['likes', 'bookmarks'])
        ->latest('created_at')
        ->paginate(6)
        ->withQueryString();

    return view('public.articles.my_articles', [
        'articles' => $articles,
        'title' => 'Artikel yang Saya Simpan',
    ]);
}



}