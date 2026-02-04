<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Joboffer;
use Illuminate\Http\Request;

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
            'title' => 'required',
            'description' => 'required',
            'contract_type' => 'required'
        ]);

        auth()->user()->jobOffers()->create([
            ...$data,
            'company_id' => auth()->user()->company->id
        ]);

        return redirect()->route('recruteur.jobs.index');
    }

    public function edit(Joboffer $job)
    {
        return view('recruteur.jobs.edit', compact('job'));
    }

    public function update(Request $request, Joboffer $job)
    {
        $job->update($request->validate([
            'title' => 'required',
            'description' => 'required',
            'contract_type' => 'required'
        ]));

        return redirect()->route('recruteur.jobs.index');
    }
   


    public function close(Joboffer $job)
    {
        $job->update(['is_closed' => true]);
        return back();
    }
}
