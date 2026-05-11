<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FeedController extends Controller
{
    public function home()
    {
        if (auth()->check()) {
            return redirect('/feed');
        }

        $articles = Article::query()
            ->with(['user', 'category'])
            ->published()
            ->latest()
            ->take(6)
            ->get();

        return view('welcome', compact('articles'));
    }

    public function index(Request $request): View
    {
        $articles = $this->articlesQuery($request)->paginate(15);
        $categories = Category::all();

        return view('feed.index', compact('articles', 'categories'));
    }

    public function search(Request $request): View
    {
        $articles = $this->articlesQuery($request)->paginate(15);
        $categories = Category::all();

        return view('feed.search', compact('articles', 'categories'));
    }

    protected function articlesQuery(Request $request)
    {
        return Article::query()
            ->with(['user', 'category'])
            ->published()
            ->when($request->search, function ($q, $v) {
                $q->where(function ($qq) use ($v) {
                    $qq->where('title', 'like', "%{$v}%")
                        ->orWhere('description', 'like', "%{$v}%");
                });
            })
            ->when($request->category, fn ($q, $v) => $q->where('category_id', $v))
            ->when($request->type, fn ($q, $v) => $q->where('type', $v))
            ->when(
                $request->sort === 'popular',
                fn ($q) => $q->orderBy('likes_count', 'desc'),
                fn ($q) => $q->latest()
            );
    }
}
