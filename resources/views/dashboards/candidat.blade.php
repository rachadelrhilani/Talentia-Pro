@extends('layouts.app')

@section('content')

<div class="bg-[#f3f2f1] min-h-screen py-6">
    <div class="max-w-7xl mx-auto px-4 mt-4">
    {{-- Message dial Success (Paiement daz) --}}
    @if(session('success'))
        <div id="alert-success" class="flex items-center p-4 mb-4 text-emerald-800 rounded-2xl bg-emerald-50 border border-emerald-100 shadow-sm transition-all duration-500" role="alert">
            <div class="flex-shrink-0 w-10 h-10 bg-emerald-500 rounded-xl flex items-center justify-center shadow-sm">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <div class="ml-4 text-sm font-bold">
                {{ session('success') }}
            </div>
            <button type="button" onclick="document.getElementById('alert-success').remove()" class="ml-auto bg-emerald-50 text-emerald-500 rounded-lg focus:ring-2 focus:ring-emerald-400 p-1.5 hover:bg-emerald-100 inline-flex items-center justify-center h-8 w-8 transition">
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14" stroke="currentColor" stroke-width="2">
                    <path d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>
    @endif

    {{-- Message dial Info / Cancel (Paiement t-annula) --}}
    @if(session('info'))
        <div id="alert-info" class="flex items-center p-4 mb-4 text-blue-800 rounded-2xl bg-blue-50 border border-blue-100 shadow-sm transition-all duration-500" role="alert">
            <div class="flex-shrink-0 w-10 h-10 bg-blue-500 rounded-xl flex items-center justify-center shadow-sm">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="ml-4 text-sm font-bold">
                {{ session('info') }}
            </div>
            <button type="button" onclick="document.getElementById('alert-info').remove()" class="ml-auto bg-blue-50 text-blue-500 rounded-lg focus:ring-2 focus:ring-blue-400 p-1.5 hover:bg-blue-100 inline-flex items-center justify-center h-8 w-8 transition">
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14" stroke="currentColor" stroke-width="2">
                    <path d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>
    @endif
</div>
    <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-12 gap-6">
        <div class="md:col-span-3">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden top-20">
                <div class="h-16 bg-gradient-to-r from-[#a0b4b7] to-[#d1dce0]"></div>

                <div class="px-4 -mt-8 mb-4 flex flex-col items-center border-b border-gray-100 pb-4">
                    <img src="{{ auth()->user()->photo ? asset('storage/' . auth()->user()->photo) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=0a66c2&color=fff' }}"
                        class="w-16 h-16 rounded-full border-2 border-white shadow-md" alt="Avatar">

                    <h2 class="mt-3 font-bold text-gray-900 hover:underline cursor-pointer leading-tight text-center flex items-center gap-1">
                        {{ auth()->user()->name }}
                        @if(auth()->user()->is_premium)
                        <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                        @endif
                    </h2>
                    <p class="text-[11px] text-gray-500 text-center mt-1 font-medium">{{auth()->user()->bio}}</p>
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
                    <svg class="w-4 h-4 text-gray-500 mr-2 group-hover:text-[#0a66c2]" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20 6h-4V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2z" />
                    </svg>
                    <span class="text-xs font-bold text-gray-700 group-hover:text-[#0a66c2]">Accéder à mon profil CV</span>
                </a>
            </div>

           {{-- Bloc Premium Stripe --}}
@if(!auth()->user()->is_premium)
<div class="relative overflow-hidden bg-white rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 p-6 mt-4 group">
    <div class="absolute -right-6 -top-6 w-24 h-24 bg-indigo-50 rounded-full transition-transform group-hover:scale-150 duration-700"></div>
    
    <div class="relative">
        <div class="flex items-center space-x-2 mb-4">
            <span class="flex h-2 w-2 rounded-full bg-indigo-600"></span>
            <span class="text-[10px] font-black uppercase tracking-widest text-indigo-600">Offre Exclusive</span>
        </div>

        <h3 class="text-gray-900 font-extrabold text-lg leading-tight mb-2">
            Passez à la vitesse <span class="text-indigo-600">supérieure</span>
        </h3>
        
        <p class="text-gray-500 text-xs leading-relaxed mb-6">
            Débloquez des opportunités exclusives et donnez à votre profil la visibilité qu'il mérite.
        </p>

        <a href="{{ route('stripe.checkout') }}" 
           class="flex items-center justify-center w-full bg-gray-900 hover:bg-indigo-600 text-white text-xs font-bold py-3 px-4 rounded-xl transition-all duration-300 transform hover:-translate-y-1 shadow-md">
            <span>Activer Premium</span>
            <span class="mx-2 opacity-20">|</span>
            <span>500 DH</span>
        </a>
    </div>
</div>
@else
<div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-2xl border border-amber-100 p-4 mt-4 relative overflow-hidden">
    <div class="absolute top-2 right-2 opacity-20 text-amber-600">
        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l2.4 7.2h7.6l-6.1 4.5 2.3 7.3-6.2-4.6-6.2 4.6 2.3-7.3-6.1-4.5h7.6z"/></svg>
    </div>
    
    <div class="flex items-center space-x-4">
        <div class="flex-shrink-0 w-10 h-10 bg-amber-400 rounded-xl flex items-center justify-center shadow-sm">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        <div>
            <p class="text-[13px] font-black text-amber-900 leading-none">Membre Premium</p>
            <p class="text-[10px] text-amber-700 mt-1 font-medium">Accès illimité activé</p>
        </div>
    </div>
</div>
@endif
        </div>

        <div class="md:col-span-6 space-y-4">

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-4">
                <div class="flex items-center space-x-3">
                    <img src="{{ auth()->user()->photo ? asset('storage/' . auth()->user()->photo) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=0a66c2&color=fff' }}" class="w-12 h-12 rounded-full border border-gray-100">
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
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" />
                                </svg>
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