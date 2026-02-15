<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Friendship;
use App\Models\Joboffer;
use App\Models\User;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $cacheKey = "user_dashboard_{$user->id}";

        $data = cache()->remember($cacheKey, now()->addMinutes(5), function () use ($user) {
            if ($user->hasRole('recruteur')) {
                $jobs = Joboffer::withCount('applications')
                    ->where('user_id', $user->id)
                    ->latest()
                    ->take(5)
                    ->get();

                $activeJobs = Joboffer::where('user_id', $user->id)
                    ->where('is_closed', false)
                    ->count();

                $totalApplications = Application::whereHas('jobOffer', function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                })->count();

                return [
                    'type' => 'recruteur',
                    'jobs' => $jobs,
                    'activeJobs' => $activeJobs,
                    'totalApplications' => $totalApplications
                ];
            }

            $suggestedJobs = Joboffer::where('is_closed', false)
                ->latest()
                ->take(5)
                ->get();

            $friendsCount = Friendship::where(function ($q) use ($user) {
                $q->where('sender_id', $user->id)
                    ->orWhere('receiver_id', $user->id);
            })->where('status', 'accepted')->count();

            $suggestedUsers = User::where('id', '!=', $user->id)
                ->inRandomOrder()
                ->take(5)
                ->get();

            return [
                'type' => 'candidat',
                'suggestedJobs' => $suggestedJobs,
                'friendsCount' => $friendsCount,
                'suggestedUsers' => $suggestedUsers
            ];
        });

        if ($data['type'] === 'recruteur') {
            return view('dashboards.recruteur', [
                'jobs' => $data['jobs'],
                'activeJobs' => $data['activeJobs'],
                'totalApplications' => $data['totalApplications']
            ]);
        }

        return view('dashboards.candidat', [
            'suggestedJobs' => $data['suggestedJobs'],
            'friendsCount' => $data['friendsCount'],
            'suggestedUsers' => $data['suggestedUsers']
        ]);
    }
}
