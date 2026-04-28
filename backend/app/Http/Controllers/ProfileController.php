<?php

namespace App\Http\Controllers;

use App\Models\User;
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
            $validated['photo'] = $request->file('photo')->store('profiles', 'public');
        }

        $user->update($validated);

        return redirect()
            ->route('profile.show', $user)
            ->with('success', 'Profil mis a jour avec succes.');
    }
}
