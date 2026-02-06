@extends('layouts.app')

@section('content')
<div class="bg-[#f3f2f1] min-h-screen py-8">
    <div class="max-w-4xl mx-auto px-4">

        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">Offres d'emploi qui pourraient vous intéresser</h1>
            <p class="text-sm text-gray-600">Basé sur votre profil et vos recherches récentes</p>
        </div>
        <div class="mb-8 bg-white p-6 rounded-xl shadow-sm border border-gray-200">
            <form action="{{ URL::current() }}" method="GET" class="flex flex-col md:flex-row gap-4">
                <div class="relative flex-1">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                    <input type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Rechercher par titre de poste (ex: Développeur PHP)..."
                        class="pl-10 w-full border border-gray-300 p-2.5 rounded-lg focus:ring-[#0a66c2] focus:border-[#0a66c2]">
                </div>

                <button type="submit" class="bg-[#0a66c2] text-white px-6 py-2.5 rounded-lg font-bold hover:bg-[#004182] transition duration-200">
                    Rechercher
                </button>

                @if(request('search'))
                <a href="{{ URL::current() }}" class="flex items-center justify-center text-gray-500 hover:text-red-500 text-sm font-medium">
                    Effacer
                </a>
                @endif
            </form>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            @foreach($jobs as $job)
            <div class="group p-4 sm:p-6 border-b border-gray-100 last:border-0 hover:bg-gray-50 transition duration-200">
                <div class="flex items-start space-x-4">

                    <div class="w-14 h-14 bg-gray-100 rounded flex-shrink-0 flex items-center justify-center border border-gray-200">
                        <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 7V3H2v18h20V7H12zM6 19H4v-2h2v2zm0-4H4v-2h2v2zm0-4H4V9h2v2zm0-4H4V5h2v2zm4 12H8v-2h2v2zm0-4H8v-2h2v2zm0-4H8V9h2v2zm0-4H8V5h2v2zm10 12h-8v-2h2v-2h-2v-2h2v-2h-2V9h8v10zm-2-8h-2v2h2v-2zm0 4h-2v2h2v-2z" />
                        </svg>
                    </div>

                    <div class="flex-1">
                        <a href="{{ route('candidat.jobs.show', $job) }}" class="block">
                            <h2 class="text-lg font-bold text-[#0a66c2] group-hover:underline decoration-2">
                                {{ $job->title }}
                            </h2>
                        </a>
                        <p class="text-sm text-gray-800">{{ $job->company->name ?? 'Entreprise Partenaire' }}</p>
                        <p class="text-sm text-gray-500 mt-0.5">{{ $job->location ?? 'Maroc (Télétravail)' }}</p>

                        <div class="mt-2 flex items-center space-x-2">
                            <span class="bg-green-100 text-green-800 text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-wide">
                                {{ $job->contract_type }}
                            </span>
                            <span class="text-gray-400 text-xs">•</span>
                            <span class="text-gray-500 text-xs italic">
                                Postée {{ $job->created_at->diffForHumans() }}
                            </span>
                        </div>
                    </div>

                    <div class="flex flex-col items-end justify-between h-full">
                        <button class="text-gray-400 hover:text-[#0a66c2] transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                            </svg>
                        </button>
                        <a href="{{ route('candidat.jobs.show', $job) }}"
                            class="mt-8 border border-[#0a66c2] text-[#0a66c2] font-bold px-4 py-1.5 rounded-full text-sm hover:bg-blue-50 transition">
                            Candidature simplifiée
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @if($jobs->isEmpty())
        <div class="text-center bg-white p-12 rounded-xl shadow-sm border border-gray-200">
            <p class="text-gray-500 italic">Aucune offre disponible pour le moment. Revenez plus tard !</p>
        </div>
        @endif

    </div>
</div>
@endsection