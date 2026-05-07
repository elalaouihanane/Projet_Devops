<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::query()
            ->with('category')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('articles.index', compact('articles'));
    }

    public function create()
    {
        $categories = Category::query()->orderBy('name')->get();

        return view('articles.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:outfit,clothing'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'description' => ['nullable', 'string', 'max:2000'],
            'occasion' => ['nullable', 'string', 'max:100'],
            'color' => ['nullable', 'string', 'max:50'],
            'image' => ['required', 'image', 'max:4096'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['string', 'max:50'],
            'is_published' => ['boolean'],
        ]);

        $imagePath = Storage::disk('public')->put('articles', $request->file('image'));

        $article = Article::create([
            ...$validated,
            'user_id' => auth()->id(),
            'image' => $imagePath,
            'is_published' => (bool)($validated['is_published'] ?? false),
        ]);

        return redirect(url('/articles'))->with('success', "Article publié avec succès.");
    }

    public function show($id)
    {
        $article = Article::query()
            ->with(['user', 'category'])
            ->findOrFail($id);

        if (!$article->is_published && auth()->id() !== $article->user_id) {
            abort(403);
        }

        return view('articles.show', compact('article'));
    }

    public function edit($id)
    {
        $article = Article::query()->findOrFail($id);

        if (auth()->id() !== $article->user_id) {
            abort(403);
        }

        $categories = Category::query()->orderBy('name')->get();

        return view('articles.edit', compact('article', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $article = Article::query()->findOrFail($id);

        if (auth()->id() !== $article->user_id) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:outfit,clothing'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'description' => ['nullable', 'string', 'max:2000'],
            'occasion' => ['nullable', 'string', 'max:100'],
            'color' => ['nullable', 'string', 'max:50'],
            'image' => ['nullable', 'image', 'max:4096'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['string', 'max:50'],
            'is_published' => ['boolean'],
        ]);

        if ($request->hasFile('image')) {
            if ($article->image) {
                Storage::disk('public')->delete($article->image);
            }

            $validated['image'] = Storage::disk('public')->put('articles', $request->file('image'));
        }

        $validated['is_published'] = (bool)($validated['is_published'] ?? false);

        $article->update($validated);

        return redirect(url("/articles/{$article->id}"))->with('success', "Article mis à jour.");
    }

    public function destroy($id)
    {
        $article = Article::query()->findOrFail($id);

        if (auth()->id() !== $article->user_id) {
            abort(403);
        }

        if ($article->image) {
            Storage::disk('public')->delete($article->image);
        }

        $article->delete();

        return redirect(url('/articles'))->with('success', "Article supprimé.");
    }
}

