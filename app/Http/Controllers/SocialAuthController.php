<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SocialAuthController extends Controller
{
    public function redirectToGithub()
    {
        return Socialite::driver('github')->redirect();
    }

    public function handleGithubCallback()
    {
        $githubUser = Socialite::driver('github')->user();
        // dd($githubUser);

        // Chercher un utilisateur existant par email
        $user = User::create([
                'name' => $githubUser->nickname,
                'email' => $githubUser->email,
                'photo' => $githubUser->avatar,
                'type' => 'recruteur',
                'password' => bcrypt(uniqid()),
                'bio' => ""
            ]
        );

        // Connecter l'utilisateur
        Auth::login($user, true);

        // Rediriger vers le dashboard
        return redirect('/dashboard');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->user();
       
        $user = User::where('email', $googleUser->getEmail())->first();
            if(! $user) {
        // Chercher un utilisateur existant par email
        $user = User::create([
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'photo' => $googleUser->avatar,
                'type' => 'recruteur',
                'password' => bcrypt(uniqid()),
                'bio' => ""
            ]
        );}

        // Connecter l'utilisateur
        Auth::login($user, true);

        // Rediriger vers le dashboard
        return redirect('/dashboard');
    }
}
