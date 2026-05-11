<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Cloudinary\Cloudinary;
use Cloudinary\Configuration\Configuration;

class ArticleController extends Controller
{
    private function uploadToCloudinary($file): string
    {
        $cloudinary = new Cloudinary(
            Configuration::instance([
                'cloud' => [
                    'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                    'api_key'    => env('CLOUDINARY_API_KEY'),
                    'api_secret' => env('CLOUDINARY_API_SECRET'),
                ],
                'url' => ['secure' => true]
            ])
        );

        $result = $cloudinary->uploadApi()->upload($file->getRealPath());
        return $result['secure_url'];
    }

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
            'title'        => ['required', 'string', 'max:255'],
            'type'         => ['required', 'in:outfit,clothing'],
            'category_id'  => ['nullable', 'exists:categories,id'],
            'description'  => ['nullable', 'string', 'max:2000'],
            'occasion'     => ['nullable', 'string', 'max:100'],
            'color'        => ['nullable', 'string', 'max:50'],
            'image'        => ['required', 'image', 'max:4096'],
            'tags'         => ['nullable', 'array'],
            'tags.*'       => ['string', 'max:50'],
            'is_published' => ['boolean'],
        ]);

        $imagePath = $this->uploadToCloudinary($request->file('image'));

        $article = Article::create([
            ...$validated,
            'user_id'      => auth()->id(),
            'image'        => $imagePath,
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
            'title'        => ['required', 'string', 'max:255'],
            'type'         => ['required', 'in:outfit,clothing'],
            'category_id'  => ['nullable', 'exists:categories,id'],
            'description'  => ['nullable', 'string', 'max:2000'],
            'occasion'     => ['nullable', 'string', 'max:100'],
            'color'        => ['nullable', 'string', 'max:50'],
            'image'        => ['nullable', 'image', 'max:4096'],
            'tags'         => ['nullable', 'array'],
            'tags.*'       => ['string', 'max:50'],
            'is_published' => ['boolean'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $this->uploadToCloudinary($request->file('image'));
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

        $article->delete();

        return redirect(url('/articles'))->with('success', "Article supprimé.");
    }
}