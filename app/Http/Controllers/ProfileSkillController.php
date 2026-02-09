<?php

namespace App\Http\Controllers;

use App\Models\skill;
use Illuminate\Http\Request;

class ProfileSkillController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(['skill_id' => 'required|exists:skills,id']);

        auth()->user()->profile->skills()->syncWithoutDetaching($request->skill_id);

        return back();
    }

    public function destroy(skill $skill)
    {
        auth()->user()->profile->skills()->detach($skill->id);
        return back();
    }
}
