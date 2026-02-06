<?php

namespace App\Http\Controllers;

use App\Models\Joboffer;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function edit(Joboffer $job)
    {
        return view('recruteur.jobs.edit', compact('job'));
    }

    public function index(Request $request)
    {
        $query = Joboffer::where('is_closed', false)->with('company');

        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where('title', 'LIKE', '%' . $searchTerm . '%');
        }

        $jobs = $query->latest()->get();

        return view('candidat.jobs.index', compact('jobs'));
    }
    public function update(Request $request, Joboffer $job)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'salary' => 'nullable|string|max:255',
        ]);

        $job->update($data);

        return redirect()
            ->route('recruteur.dashboard')
            ->with('success', 'Offre modifiée avec succès');
    }


    public function show(Joboffer $job)
    {
        return view('candidat.jobs.show', compact('job'));
    }
}
