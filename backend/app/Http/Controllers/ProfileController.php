<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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
            'member_since' => $user->created_at?->format('F Y'),
        ];

        return view('profile.show', compact('user', 'articles', 'stats'));
    }

    public function edit(User $user): View
    {
        abort_unless(Auth::id() === $user->id, 403);
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        abort_unless(Auth::id() === $user->id, 403);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:500'],
            'style_prefere' => ['nullable', 'in:Streetwear,Chic,Casual,Vintage,Sportswear,Bohème'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }

            $validated['photo'] = $request->file('photo')->store('profiles', 'public');
        }

        $user->update($validated);

        return redirect()->route('profile.show', $user)->with('success', 'Profil mis a jour avec succes.');
    }
}
