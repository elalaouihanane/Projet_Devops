<?php

namespace App\Http\Controllers;

use App\Models\User;
<<<<<<< Updated upstream
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show(User $user): View
    {
        $articles = $user->articles()
            ->with('category')
            ->where('is_published', true)
            ->latest()
            ->paginate(10);

        $stats = [
            'publications' => $user->articles()->where('is_published', true)->count(),
            'likes_received' => (int) $user->articles()->sum('likes_count'),
            'member_since' => $user->created_at?->locale('fr')->translatedFormat('F Y'),
        ];

        return view('profile.show', [
            'user' => $user,
            'articles' => $articles,
            'stats' => $stats,
        ]);
    }

    public function edit(User $user): View|RedirectResponse
    {
        if (!Auth::check() || Auth::id() !== $user->id) {
            return redirect()
                ->route('profile.show', $user)
                ->with('error', 'Vous ne pouvez modifier que votre propre profil.');
        }

        return view('profile.edit', ['user' => $user]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        if (!Auth::check() || Auth::id() !== $user->id) {
            return redirect()
                ->route('profile.show', $user)
                ->with('error', 'Action non autorisee.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:800'],
            'photo' => ['nullable', 'image', 'max:2048'],
            'style_prefere' => ['nullable', 'string', 'max:120'],
        ]);

        if ($request->hasFile('photo')) {
=======
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show(User $user)
{
    // Charger les articles publiés avec leur catégorie
    $articles = $user->articles()
        ->where('is_published', true)
        ->with('category')
        ->latest()
        ->get();

    return view('profile.show', compact('user', 'articles'));
}

    public function edit(User $user)
    {
        abort_unless(Auth::id() === $user->id, 403);
        
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        abort_unless(Auth::id() === $user->id, 403);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string|max:500',
            'style_prefere' => 'nullable|in:Streetwear,Chic,Casual,Vintage,Sportswear,Bohème',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
>>>>>>> Stashed changes
            $validated['photo'] = $request->file('photo')->store('profiles', 'public');
        }

        $user->update($validated);

<<<<<<< Updated upstream
        return redirect()
            ->route('profile.show', $user)
            ->with('success', 'Profil mis a jour avec succes.');
    }
}
=======
        return redirect()->route('profile.show', $user)->with('success', 'Profil mis à jour avec succès.');
    }
}
>>>>>>> Stashed changes
