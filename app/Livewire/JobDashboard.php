<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Lazy; // <--- Hada darouri
use App\Models\Joboffer;

#[Lazy] // <--- Zid had l-ster darouri hna!
class JobDashboard extends Component
{
    public function render()
    {
        $jobs = auth()->user()->jobOffers;
        return view('livewire.job-dashboard', compact('jobs'));
    }

    public function placeholder()
    {
        return <<<'HTML'
        <div class="space-y-4">
            @for($i = 0; $i < 3; $i++)
                <div class="h-32 bg-gray-200 rounded-2xl animate-pulse w-full"></div>
            @endfor
        </div>
        HTML;
    }
}