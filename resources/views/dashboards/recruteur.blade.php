@extends('layouts.app')

@section('content')
<div class="bg-[#f3f2f1] min-h-screen py-6">
    <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-12 gap-6">

        <div class="md:col-span-3">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden sticky top-20">
                <div class="h-16 bg-[#004182]"></div>
                <div class="px-4 -mt-8 mb-4 flex flex-col items-center border-b border-gray-100 pb-4">
                    <div class="w-16 h-16 bg-white rounded-lg border-2 border-white shadow-md flex items-center justify-center overflow-hidden">
                        <img src="{{ auth()->user()->photo ? asset('storage/' . auth()->user()->photo) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=0a66c2&color=fff' }}"
                            class="w-full h-full object-cover"
                            alt="{{ auth()->user()->name }}">
                    </div>
                    <h2 class="mt-3 font-bold text-gray-900 hover:underline cursor-pointer text-center leading-tight">
                        {{ auth()->user()->name }}
                    </h2>
                    <p class="text-[11px] text-gray-500 text-center mt-1 uppercase font-bold tracking-wider">Recruteur Pro</p>
                </div>

                <div class="py-2">
                    <div class="px-4 py-2 hover:bg-gray-100 transition cursor-pointer">
                        <p class="text-[11px] text-gray-500 font-bold uppercase">Offres actives</p>
                        <p class="text-sm text-[#0a66c2] font-bold">{{ $activeJobs }}</p>
                    </div>
                    <div class="px-4 py-2 hover:bg-gray-100 transition cursor-pointer border-t border-gray-50">
                        <p class="text-[11px] text-gray-500 font-bold uppercase">Candidatures reçues</p>
                        <p class="text-sm text-[#0a66c2] font-bold">{{ $totalApplications}}</p>
                    </div>
                </div>

                <a href="{{ route('profile.show') }}" class="border-t border-gray-200 px-4 py-3 flex items-center justify-center hover:bg-blue-50 transition group">
                    <span class="text-xs font-bold text-[#0a66c2]">Accéder Profile</span>
                </a>
            </div>
        </div>

        <div class="md:col-span-6 space-y-4">

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 flex items-center justify-between">
                <div>
                    <h3 class="font-bold text-gray-900 text-lg">Tableau de bord de recrutement</h3>
                    <p class="text-xs text-gray-500">Gérez vos annonces et suivez vos performances.</p>
                </div>
                <a href="{{ route('recruteur.jobs.create') }}" class="bg-[#0a66c2] text-white px-5 py-2 rounded-full text-sm font-bold hover:bg-[#004182] transition shadow-md flex items-center">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
                    </svg>
                    Publier
                </a>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <h3 class="font-bold text-gray-900 text-sm italic">Vos annonces récentes</h3>
                    <span class="text-[10px] bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full font-bold">LIVE</span>
                </div>

                <div class="divide-y divide-gray-100">
                    @forelse($jobs as $job)
                    <div class="p-5 hover:bg-gray-50 transition duration-150">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <h4 class="text-base font-bold text-gray-900 mb-1 hover:text-[#0a66c2] cursor-pointer transition">
                                    {{ $job->title }}
                                </h4>
                                <div class="flex items-center text-[11px] text-gray-500 space-x-2">
                                    <span class="flex items-center uppercase font-bold tracking-tighter">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" />
                                        </svg>
                                        {{ $job->created_at->diffForHumans() }}
                                    </span>
                                    <span>•</span>
                                    <span class="text-green-600 font-bold bg-green-50 px-2 py-0.5 rounded">
                                        {{ $job->applications_count }} candidats intéressés
                                    </span>
                                </div>
                            </div>

                            <div class="flex items-center space-x-2 ml-4">
                                <a href="{{ route('recruteur.jobs.edit', $job) }}" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </a>
                                <a href="{{ route('recruteur.jobs.applications', $job) }}" class="bg-white border border-[#0a66c2] text-[#0a66c2] px-4 py-1.5 rounded-full text-xs font-bold hover:bg-blue-50 transition">
                                    Voir candidats
                                </a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="p-10 text-center">
                        <p class="text-gray-500 text-sm">Vous n'avez aucune offre active pour le moment.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="md:col-span-3 space-y-4">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                <div class="flex items-center space-x-2 mb-4">
                    <div class="p-1.5 bg-yellow-50 rounded">
                        <svg class="w-5 h-5 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M11 3a1 1 0 10-2 0v1a1 1 0 102 0V3zM15.657 5.757a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM5.05 6.464A1 1 0 106.464 5.05l-.707-.707a1 1 0 00-1.414 1.414l.707.707zM5 10a1 1 0 01-1 1H3a1 1 0 110-2h1a1 1 0 011 1zM8 16v-1a1 1 0 112 0v1a1 1 0 11-2 0zM13 16v-1a1 1 0 112 0v1a1 1 0 11-2 0zM14.586 15.414a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414l.707.707zM6.707 14.707a1 1 0 00-1.414 1.414l.707.707a1 1 0 001.414-1.414l-.707-.707z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-900 text-sm">Conseil Talentia</h3>
                </div>
                <p class="text-xs text-gray-600 leading-relaxed mb-3">
                    Les entreprises qui répondent aux candidats en moins de 48h ont un taux d'acceptation 40% plus élevé.
                </p>
                <div class="h-1 w-full bg-gray-100 rounded-full">
                    <div class="h-1 bg-green-500 rounded-full" style="width: 75%"></div>
                </div>
                <p class="text-[10px] text-gray-400 mt-2 italic">Votre réactivité : Excellente</p>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                <h3 class="font-bold text-gray-900 text-[11px] uppercase tracking-wider mb-3">Actualités Recrutement</h3>
                <ul class="space-y-3">
                    <li class="text-xs font-semibold text-gray-700 hover:text-blue-700 cursor-pointer">Comment recruter en 2026 ?</li>
                    <li class="text-xs font-semibold text-gray-700 hover:text-blue-700 cursor-pointer">L'IA dans le tri des CV.</li>
                </ul>
            </div>
        </div>

    </div>
</div>
@endsection