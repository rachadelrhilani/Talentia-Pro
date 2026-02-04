<?php

namespace App\Http\Controllers;

use App\Models\skill;
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
        $user = auth()->user();

        if ($user->hasRole('candidat')) {
            $profile = $user->profile()->with([
                'educations',
                'experiences',
                'skills'
            ])->first();

            $skills = skill::all();

            return view('profile.edit', compact('profile', 'skills'));
        }

        if ($user->hasRole('recruteur')) {
            $company = $user->company;
            return view('profile.edit', compact('company'));
        }
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
