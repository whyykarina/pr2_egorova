<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $profile = $user->profile ?? new Profile(); // Получить профиль или создать новый, если его нет

        return view('profile.index', compact('profile', 'user'));
    }

    public function edit()
    {
        $user = Auth::user();
        $profile = $user->profile ?? new Profile();

        return view('profile.edit', compact('profile', 'user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'bio' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        // Профиль
        if (!$user->profile) {
            $profile = new Profile(['user_id' => $user->id]);
        } else {
            $profile = $user->profile;
        }

        $profile->bio = $request->input('bio');

        // Аватар
        if ($request->hasFile('avatar')) {
            // Удаляем старый аватар, если есть
            if ($profile->avatar) {
                Storage::delete('public/' . $profile->avatar);
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $profile->avatar = $path;
        }

        $profile->save();

        // Пароль (если изменен)
        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
            $user->save();
        }

        return redirect()->route('profile.index')->with('success', 'Профиль успешно обновлен!');
    }
}