@extends('layouts.app')

@section('content')
<div class="bg-[#f3f2f1] min-h-screen py-6">
    <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-12 gap-6">

        <div class="md:col-span-3">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden sticky top-20">
                <div class="h-16 bg-gradient-to-r from-[#a0b4b7] to-[#d1dce0]"></div>
                
                <div class="px-4 -mt-8 mb-4 flex flex-col items-center border-b border-gray-100 pb-4">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=random" 
                         class="w-16 h-16 rounded-full border-2 border-white shadow-md" alt="Avatar">
                    
                    <h2 class="mt-3 font-bold text-gray-900 hover:underline cursor-pointer leading-tight text-center">
                        {{ auth()->user()->name }}
                    </h2>
                    <p class="text-[11px] text-gray-500 text-center mt-1 font-medium">Étudiant à YouCode / Développeur Fullstack</p>
                </div>

                <div class="py-2">
                    <a href="{{ route('candidat.friends') }}" class="px-4 py-2 flex justify-between hover:bg-gray-100 transition group">
                        <span class="text-[11px] text-gray-500 font-bold uppercase">Relations</span>
                        <span class="text-xs text-[#0a66c2] font-bold group-hover:underline">{{ $friendsCount ?? 0 }}</span>
                    </a>
                    <a href="{{ route('candidat.applications') }}" class="px-4 py-2 flex justify-between hover:bg-gray-100 transition group border-t border-gray-50">
                        <span class="text-[11px] text-gray-500 font-bold uppercase">Mes candidatures</span>
                        <span class="text-xs text-[#0a66c2] font-bold group-hover:underline">Voir tout</span>
                    </a>
                </div>

                <a href="{{ route('profile.show') }}" class="border-t border-gray-200 px-4 py-3 flex items-center hover:bg-blue-50 transition group">
                    <svg class="w-4 h-4 text-gray-500 mr-2 group-hover:text-[#0a66c2]" fill="currentColor" viewBox="0 0 24 24"><path d="M20 6h-4V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2z"/></svg>
                    <span class="text-xs font-bold text-gray-700 group-hover:text-[#0a66c2]">Accéder à mon profil CV</span>
                </a>
            </div>
        </div>

        <div class="md:col-span-6 space-y-4">
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-4">
                <div class="flex items-center space-x-3">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}" class="w-12 h-12 rounded-full border border-gray-100">
                    <button class="flex-1 text-left border border-gray-300 rounded-full px-4 py-2.5 text-gray-500 font-semibold text-sm hover:bg-gray-100 transition">
                        Commencer un post...
                    </button>
                </div>
            </div>

            <div class="flex items-center space-x-2 px-2">
                <hr class="flex-1 border-gray-300">
                <p class="text-[11px] text-gray-500 font-bold uppercase tracking-wider">Offres recommandées pour vous</p>
                <hr class="flex-1 border-gray-300">
            </div>

            <div class="space-y-3">
                @forelse($suggestedJobs as $job)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 hover:bg-gray-50 transition duration-150 relative">
                    <div class="flex items-start space-x-4">
                        <div class="w-14 h-14 bg-blue-50 rounded-lg flex-shrink-0 flex items-center justify-center text-[#0a66c2] font-black text-xl border border-blue-100 shadow-inner">
                            {{ strtoupper(substr($job->title, 0, 2)) }}
                        </div>

                        <div class="flex-1">
                            <h4 class="text-base font-bold text-gray-900 hover:text-[#0a66c2] hover:underline cursor-pointer transition">
                                <a href="{{ route('candidat.jobs.show', $job) }}">{{ $job->title }}</a>
                            </h4>
                            <p class="text-sm text-gray-700">{{ $job->company->name ?? 'Entreprise Partenaire' }}</p>
                            <p class="text-xs text-gray-500 mt-1 flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"/></svg>
                                Postée {{ $job->created_at->diffForHumans() }}
                            </p>
                        </div>

                        <div class="flex flex-col space-y-2">
                             <a href="{{ route('candidat.jobs.show', $job) }}"
                                class="border-2 border-[#0a66c2] text-[#0a66c2] px-4 py-1 rounded-full text-xs font-bold hover:bg-blue-50 transition text-center">
                                Voir
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                    <div class="bg-white rounded-xl p-10 text-center border-2 border-dashed border-gray-200">
                        <p class="text-gray-500 italic">Aucune nouvelle offre disponible pour le moment.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="md:col-span-3">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sticky top-20">
                <h3 class="font-bold text-gray-900 text-sm mb-4">À découvrir</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between group cursor-pointer">
                        <div class="flex items-center space-x-2">
                            <div class="w-8 h-8 bg-orange-100 text-orange-600 rounded flex items-center justify-center font-bold text-xs">#</div>
                            <span class="text-xs font-bold text-gray-600 group-hover:text-[#0a66c2]">RecrutementTech</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between group cursor-pointer">
                        <div class="flex items-center space-x-2">
                            <div class="w-8 h-8 bg-green-100 text-green-600 rounded flex items-center justify-center font-bold text-xs">#</div>
                            <span class="text-xs font-bold text-gray-600 group-hover:text-[#0a66c2]">LaravelMaroc</span>
                        </div>
                    </div>
                </div>
                <hr class="my-4 border-gray-100">
                <p class="text-[10px] text-gray-400 text-center leading-tight">
                    Talentia © 2026. Tous droits réservés.
                </p>
            </div>
        </div>

    </div>
</div>
@endsection