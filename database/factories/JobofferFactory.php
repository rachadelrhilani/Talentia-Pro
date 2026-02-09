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
$recruiter = User::role('recruteur')->find(2);

// On récupère l'entreprise qui appartient à ce recruteur spécifique
$company = Companie::where('user_id', 2)->first();

return [
    'company_id' => $company->id ?? Companie::inRandomOrder()->value('id'),
    
    // On force l'ID du recruteur à 5
    'user_id' => 2,

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
