<?php

namespace Database\Seeders;

use App\Models\Joboffer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobofferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
    {
        Joboffer::factory()
            ->count(40)
            ->create();
    }
}
