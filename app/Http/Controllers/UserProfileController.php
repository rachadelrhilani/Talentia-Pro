<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function show()
    {
        return view('profile.show', [
            'user' => auth()->user()
        ]);
    }

    public function edit()
    {
        return view('profile.edit', [
            'user' => auth()->user()
        ]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $data = $request->validate([
            'name'  => 'required|string',
            'bio'   => 'nullable|string',
            'photo' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('profiles', 'public');
        }

        $user->update($data);

        return redirect()->route('profile.show')->with('success', 'Profil mis à jour');
    }
}
