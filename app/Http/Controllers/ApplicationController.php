<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Joboffer;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function store(Joboffer $job)
    {
        Application::firstOrCreate([
            'job_offer_id' => $job->id,
            'user_id' => auth()->id()
        ]);

        return back()->with('success', 'Candidature envoyée');
    }

    public function index(Joboffer $job)
    {
        $applications = $job->applications()->with('candidate')->get();
        return view('recruteur.jobs.applications', compact('applications'));
    }

    public function myApplications()
    {
        $applications = auth()->user()->applications;
        return view('candidat.applications.index', compact('applications'));
    }
    public function updateStatus(Request $request, Application $application)
    {
        $request->validate([
            'status' => 'required|in:accepted,rejected'
        ]);

        $application->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Statut mis à jour');
    }
}
