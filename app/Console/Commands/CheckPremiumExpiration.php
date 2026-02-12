<?php

namespace App\Console\Commands;

use App\Mail\PremiumExpiringSoon;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CheckPremiumExpiration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'premium:check-expiration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Vérifier l’expiration du statut premium et réinitialiser les utilisateurs';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        User::where('is_premium', true)
            ->where('premium_expires_at', '<', now())
            ->update(['is_premium' => false, 'premium_expires_at' => null]);

        $usersToWarn = User::where('is_premium', true)
            ->whereDate('premium_expires_at', now()->addDays(3))
            ->get();

        foreach ($usersToWarn as $user) {
            Mail::to($user->email)->send(new PremiumExpiringSoon($user));
        }
    }
}
