<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
   public function index()
   {
        if (auth()->user()->hasRole('recruteur')) {
            return view('dashboards.recruteur');
        }

        return view('dashboards.candidat');
    }
}
