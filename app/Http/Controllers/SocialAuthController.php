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

        // Connecter l'utilisateur
        Auth::login($user, true);

        // Rediriger vers le dashboard
        return redirect('/dashboard');
    }
}
