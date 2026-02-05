<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
{
    $query = User::with('profile');

    if($request->search){

        $query->where('name','like','%'.$request->search.'%')
              ->orWhereHas('profile',function($q) use($request){
                    $q->where('title','like','%'.$request->search.'%');
              });
    }

    $users = $query->latest()->paginate(10);

    return view('users.index',compact('users'));
}
public function show(User $user)
{
    $user->load([
        'profile.skills',
        'profile.educations',
        'profile.experiences',
        'company'
    ]);

    return view('users.show',compact('user'));
}


}
