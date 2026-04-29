<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('auth.login');
        }

        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        $remember = (bool) $request->boolean('remember');

        if (!Auth::attempt($credentials, $remember)) {
            return back()
                ->withInput($request->only('email', 'remember'))
                ->withErrors(['email' => 'Identifiants incorrects.']);
        }

        $request->session()->regenerate();

        return redirect('/feed')->with('success', 'Heureux de te revoir sur Trendora !');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Vous etes deconnecte(e).');
    }

    public function register(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('auth.register');
        }

        $computedName = trim(implode(' ', array_filter([
            trim((string) $request->input('first_name', '')),
            trim((string) $request->input('last_name', '')),
        ])));

        $data = $request->all();
        if ($computedName !== '') {
            $data['name'] = $computedName;
        }

        $validated = validator($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'photo' => ['nullable', 'image', 'max:2048'],
            'bio' => ['nullable', 'string', 'max:280'],
            'style_prefere' => ['nullable', 'string', 'max:255'],
        ])->validate();

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('profiles', 'public');
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'photo' => $photoPath,
            'bio' => $validated['bio'] ?? null,
            'style_prefere' => $validated['style_prefere'] ?? null,
            'is_active' => true,
        ]);

        Auth::login($user);

        return redirect('/feed')->with('success', 'Bienvenue sur Trendora, ' . $user->name . ' !');
    }
}
