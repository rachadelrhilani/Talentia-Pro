<?php

namespace App\Http\Controllers;

use App\Http\Requests\Application\UpdateApplicationStatusRequest;
use App\Models\Application;
use App\Models\Joboffer;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function getapp()
    {
        $applications = auth()->user()
            ->applications()
            ->with('jobOffer.company')
            ->latest()
            ->get();

        return view('candidat.applications.index', compact('applications'));
    }

    public function store(Joboffer $job)
    {
        $user = auth()->user();

        $profile = $user->profile;

        if (
            !$profile ||
            $profile->educations()->count() === 0 ||
            $profile->experiences()->count() === 0 ||
            $profile->skills()->count() === 0
        ) {

            return back()->with('error', 'Votre profil est incomplet. Veuillez remplir vos formations, expériences et compétences.');
        }
        $alreadyApplied = Application::where('job_offer_id', $job->id)
            ->where('user_id', $user->id)
            ->exists();

        if ($alreadyApplied) {
            return back()->with('error', 'Vous avez déjà postulé à cette offre.');
        }

        Application::firstOrCreate([
            'job_offer_id' => $job->id,
            'user_id' => $user->id
        ]);

        return back()->with('success', 'Candidature envoyée avec succès !');
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
    public function updateStatus(UpdateApplicationStatusRequest $request, Application $application)
    {
        $request->validated();

        $application->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Statut mis à jour');
    }
}
