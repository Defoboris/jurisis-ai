<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Lawyer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index()
    {

        return Inertia::render('Web/Article/Article');
    }

    // 🆕 Lawyer: create article
    public function store(Request $request)
    {
        $lawyer = Auth::user();

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'in:draft,published',
        ]);

        $data['lawyer_id'] = $lawyer->id;
        $data['slug'] = Str::slug($data['title']);
        if ($data['status'] === 'published') {
            $data['published_at'] = now();
        }

        $article = Article::create($data);

        return redirect()->back();
    }

    // ✏️ Lawyer: update article
    public function update(Request $request, Article $article)
    {
        $lawyer = Auth::user();

        if ($article->lawyer_id !== $lawyer->id) {
            abort(403, 'Vous ne pouvez modifier que vos propres articles.');
        }

        $data = $request->validate([
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string',
            'status' => 'in:draft,published',
        ]);

        if (isset($data['title'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        if (isset($data['status']) && $data['status'] === 'published' && !$article->published_at) {
            $data['published_at'] = now();
        }

        $article->update($data);

        return redirect()->back();
    }

    // 🗑️ Lawyer: delete article
    public function destroy(Request $request, Article $article)
    {
        $lawyer = Auth::user();

        if ($article->lawyer_id !== $lawyer->id) {
            abort(403, 'Vous ne pouvez supprimer que vos propres articles.');
        }

        $article->delete();

        return response()->json(['message' => 'Article supprimé avec succès']);
    }

    // 🌍 Public: view published article
    public function show($slug)
    {
        $article = Article::where('slug', $slug)
            ->published()
            ->firstOrFail();

        $lawyer = $article->lawyer;

        $curentLaywer = Lawyer::where('user_id', $lawyer->id)->first();
        
        $article->increment('views');

        return Inertia::render('Web/Article/Article', [
            'article' => $article,
            'lawyer' => $lawyer,
            'curentLaywer' => $curentLaywer
        ]);
    }

    // 📜 Public: list published articles
    public function publicIndex()
    {
        $articles = Article::published()
            ->latest('published_at')
            ->get(['id', 'title', 'slug', 'published_at', 'views', 'likes', 'comments_count']);

        return Inertia::render('Web/Articles/Index', [
            'articles' => $articles,
        ]);
    }
}
