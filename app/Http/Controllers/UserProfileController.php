<?php

namespace App\Http\Controllers;

use App\Models\skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserProfileController extends Controller
{
    public function show()
    {
        $user = auth()->user();

        // users who registered when roles were missing
        if ($user->roles->isEmpty() && $user->type) {
            $user->assignRole($user->type);
            $user->refresh();
        }

        if ($user->hasRole('candidat')) {
            $profile = $user->profile()->with(['educations', 'experiences', 'skills'])
                ->firstOrCreate(
                    ['user_id' => $user->id],
                    ['title' => 'Candidat']
                );

            $skills = skill::all();
            return view('profile.show', compact('user', 'profile', 'skills'));
        }

        if ($user->hasRole('recruteur')) {
            $company = $user->company()->firstOrCreate(
                ['user_id' => $user->id],
                ['name' => 'Nom de l\'entreprise']
            );
            return view('profile.show', compact('user', 'company'));
        }

        // Fallback if no role is assigned
        abort(403, "You Don't have any Roles. Please Contact Your Admin. (-");
    }

    public function update(Request $request)
    {
        $user = auth()->user();


        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'bio'   => 'nullable|string',
            'photo' => 'nullable|image|max:2048',

            // Candidat Profile & Skills
            'title'  => 'nullable|string|max:255',
            'skills' => 'nullable|array',

            // Experience
            'exp_position'   => 'nullable|string|max:255',
            'exp_company'    => 'nullable|string|max:255',
            'exp_start_date' => 'nullable|date',
            'exp_end_date'   => 'nullable|date|after_or_equal:exp_start_date',

            // Education
            'edu_degree'     => 'nullable|string|max:255',
            'edu_school'     => 'nullable|string|max:255',
            'edu_year_start' => 'nullable|integer|min:1900|max:' . date('Y'),
            'edu_year_end'   => 'nullable|integer|min:1900|max:2099',

            // Recruteur
            'company_name'        => 'nullable|string|max:255',
            'company_description' => 'nullable|string',
        ]);


        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $photoPath = $request->file('photo')->store('profiles', 'public');
            $user->photo = $photoPath;
        }


        $user->name = $data['name'];
        $user->bio = $data['bio'];
        $user->save();

        if ($user->hasRole('candidat')) {
            $profile = $user->profile()->firstOrCreate(['user_id' => $user->id]);

            $profile->update([
                'title' => $data['title']
            ]);

            if ($request->has('skills')) {
                $profile->skills()->sync($data['skills']);
            }


            if ($request->filled('exp_position')) {
                $profile->experiences()->create([
                    'position'   => $data['exp_position'],
                    'company'    => $data['exp_company'],
                    'start_date' => $data['exp_start_date'],
                    'end_date'   => $data['exp_end_date'],
                ]);
            }


            if ($request->filled('edu_degree')) {
                $profile->educations()->create([
                    'degree'     => $data['edu_degree'],
                    'school'     => $data['edu_school'],
                    'year_start' => $data['edu_year_start'],
                    'year_end'   => $data['edu_year_end'],
                ]);
            }
        }


        if ($user->hasRole('recruteur')) {
            $company = $user->company()->firstOrCreate(['user_id' => $user->id]);
            $company->update([
                'name' => $data['company_name'],
                'description' => $data['company_description']
            ]);
        }

        return back()->with('success', 'Profil mis à jour avec succès !');
    }
}
