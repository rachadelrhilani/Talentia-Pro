<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Joboffer;
use Illuminate\Container\Attributes\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage as FacadesStorage;

class JobOfferController extends Controller
{
    public function index()
    {
        $jobs = auth()->user()->jobOffers;
        return view('recruteur.jobs.index', compact('jobs'));
    }

    public function create()
    {
        return view('recruteur.jobs.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'         => 'required|string|max:255',
            'description'   => 'required|string',
            'location'      => 'required|string|max:255',
            'contract_type' => 'required|in:CDI,CDD,Stage,Freelance,Full-time',
            'salary'        => 'nullable|string|max:255',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validation dial l-image
        ]);

        if (!auth()->user()->company) {
            return back()->with('error', "Vous devez d'abord configurer les informations de votre entreprise.");
        }


        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('job_offers', 'public');
        }

        auth()->user()->jobOffers()->create([
            'title'         => $data['title'],
            'description'   => $data['description'],
            'location'      => $data['location'],
            'contract_type' => $data['contract_type'],
            'salary'        => $data['salary'],
            'image'         => $imagePath,
            'company_id'    => auth()->user()->company->id,
            'is_closed'     => false,
        ]);

        return redirect()
            ->route('recruteur.jobs.index')
            ->with('success', 'L\'offre a été publiée avec succès !');
    }

    public function edit(Joboffer $job)
    {
        return view('recruteur.jobs.edit', compact('job'));
    }

    public function update(Request $request, Joboffer $job)
    {
        $data = $request->validate([
            'title'         => 'required|string|max:255',
            'description'   => 'required|string',
            'location'      => 'required|string|max:255',
            'contract_type' => 'required|in:CDI,CDD,Stage,Freelance,Full-time',
            'salary'        => 'nullable|string|max:255',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($job->image) {
                Storage::disk('public')->delete($job->image);
            }
            $data['image'] = $request->file('image')->store('job_offers', 'public');
        }

        $job->update($data);

        return redirect()
            ->route('recruteur.jobs.index')
            ->with('success', 'L\'offre a été mise à jour !');
    }



    public function close(Joboffer $job)
    {
        $job->update(['is_closed' => true]);
        return back();
    }
}
