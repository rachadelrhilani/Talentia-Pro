@extends('layouts.app')

@section('content')
<div class="bg-[#f3f2f1] min-h-screen py-8">
    <div class="max-w-4xl mx-auto px-4">
        
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">Mes candidatures</h1>
            <p class="text-sm text-gray-600">Suivez l'état de vos demandes d'emploi en temps réel</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            @forelse($applications as $app)
                <div class="p-4 sm:p-6 border-b border-gray-100 last:border-0 hover:bg-gray-50 transition duration-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-blue-50 rounded flex items-center justify-center text-[#0a66c2] flex-shrink-0">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20 6h-4V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2zM10 4h4v2h-4z"/>
                                </svg>
                            </div>

                            <div>
                                <h3 class="text-lg font-bold text-gray-900 hover:text-[#0a66c2] cursor-pointer">
                                    {{ $app->jobOffer->title }}
                                </h3>
                                <p class="text-sm text-gray-600">{{ $app->jobOffer->company->name ?? 'Entreprise' }}</p>
                                <p class="text-xs text-gray-400 mt-1">Candidature envoyée {{ $app->created_at->diffForHumans() }}</p>
                            </div>
                        </div>

                        <div>
                            @if($app->status == 'accepted')
                                <span class="bg-green-100 text-green-700 text-xs font-bold px-3 py-1 rounded-full border border-green-200 uppercase tracking-tighter">
                                    Accepté
                                </span>
                            @elseif($app->status == 'rejected')
                                <span class="bg-red-100 text-red-700 text-xs font-bold px-3 py-1 rounded-full border border-red-200 uppercase tracking-tighter">
                                    Refusé
                                </span>
                            @else
                                <span class="bg-blue-100 text-[#0a66c2] text-xs font-bold px-3 py-1 rounded-full border border-blue-200 uppercase tracking-tighter">
                                    En attente
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-12 text-center">
                    <div class="mb-4 flex justify-center">
                        <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <p class="text-gray-500 font-semibold">Vous n'avez pas encore postulé à des offres.</p>
                    <a href="{{ route('candidat.jobs.index') }}" class="mt-4 inline-block text-[#0a66c2] font-bold hover:underline">
                        Parcourir les offres disponibles
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection