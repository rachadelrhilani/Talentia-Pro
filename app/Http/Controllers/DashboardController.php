<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return match (true) {
            $user->hasRole('recruteur') => view('dashboards.recruteur'),
            $user->hasRole('candidat')  => view('dashboards.candidat'),
            default => abort(403),
        };
    }
}
