<?php

namespace Database\Factories;

use App\Models\Companie;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Joboffer>
 */
class JobofferFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
       // On récupère spécifiquement le recruteur 5
$recruiter = User::role('recruteur')->find(5);

// On récupère l'entreprise qui appartient à ce recruteur spécifique
$company = Companie::where('user_id', 5)->first();

return [
    // On lie l'offre à l'entreprise du recruteur 5
    // Si l'entreprise n'existe pas encore, on prend une entreprise au hasard par sécurité
    'company_id' => $company->id ?? Companie::inRandomOrder()->value('id'),
    
    // On force l'ID du recruteur à 5
    'user_id' => 5,

    'title' => fake()->randomElement([
        'Développeur Fullstack Laravel React',
        'UI/UX Designer',
        'Développeur Frontend React',
        'Backend Laravel Engineer',
        'DevOps Junior'
    ]),

    'description' => fake()->paragraphs(4, true),

    'contract_type' => fake()->randomElement([
        'CDI', 'CDD', 'Stage', 'Freelance'
    ]),

    'image' => 'jobs/default.png',
    'is_closed' => fake()->boolean(20),
];
    }
}
