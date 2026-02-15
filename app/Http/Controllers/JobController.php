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
        $searchTerm = $request->input('search', '');
        $page = $request->input('page', 1);
        $cacheKey = "jobs_index_search_{$searchTerm}_page_{$page}";

        $jobs = cache()->remember($cacheKey, now()->addMinutes(10), function () use ($searchTerm) {
            $query = Joboffer::where('is_closed', false)->with('company');

            if ($searchTerm != '') {
                $query->where('title', 'LIKE', '%' . $searchTerm . '%');
            }

            return $query->latest()->get();
        });

        return view('candidat.jobs.index', compact('jobs', 'searchTerm'));
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
