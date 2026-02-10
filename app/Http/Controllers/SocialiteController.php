<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class SocialiteController extends Controller
{
    public function redirectToGithub()
    {
        return Socialite::driver('github')->redirect();
    }

    public function handleGithubCallback()
    {
       

        try {
         $githubUser = Socialite::driver('github')()->user();

        // Chercher un utilisateur existant par email
        $user = User::firstOrCreate(
            ['email' => $githubUser->getEmail()],
            [
                'name' => $githubUser->getName(),
                'github_id' => $githubUser->getId(),
                'image' => $githubUser->getAvatar(),
                'type' => $githubUser->getType(),
                'password' => bcrypt(uniqid())
            ]
        );
    } catch (\Exception $e) {
        return redirect()->route('login')->with('error', 'Impossible de se connecter avec GitHub');
    }
}
}
