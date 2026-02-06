@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto my-10 px-4">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        
        <div class="h-32 bg-gradient-to-r from-blue-500 to-indigo-600"></div>

        <div class="relative px-6 pb-8">
            <div class="relative -mt-16 mb-4">
                <img src="{{ $user->photo ? asset('storage/'.$user->photo) : 'https://ui-avatars.com/api/?name='.urlencode($user->name) }}" 
                     class="w-32 h-32 rounded-2xl object-cover border-4 border-white shadow-md bg-white">
            </div>

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $user->name }}</h1>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $user->hasRole('recruteur') ? 'bg-purple-100 text-purple-700' : 'bg-green-100 text-green-700' }}">
                            {{ $user->hasRole('recruteur') ? 'Recruteur' : 'Candidat' }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="mt-6 border-t border-gray-50 pt-6">
                <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider">À propos</h3>
                <p class="mt-2 text-gray-600 leading-relaxed">
                    {{ $user->bio ?? 'Aucune bio disponible.' }}
                </p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
        
      @if($user->hasRole('candidat'))
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            Compétences
        </h2>
        
        <div class="flex flex-wrap gap-2">
            {{-- Check if profile exists AND has skills --}}
            @if($user->profile && $user->profile->skills->count() > 0)
                @foreach($user->profile->skills as $skill)
                    <span class="px-3 py-1.5 bg-gray-50 text-gray-700 border border-gray-200 rounded-lg text-sm font-medium hover:border-indigo-300 transition-colors">
                        {{ $skill->name }}
                    </span>
                @endforeach
            @else
                {{-- Message ila makanoch les skills --}}
                <p class="text-sm text-gray-400 italic">Aucune compétence renseignée.</p>
            @endif
        </div>
    </div>
@endif

        @if($user->company)
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1"></path></svg>
                Entreprise
            </h2>
            <h4 class="font-bold text-indigo-600 text-lg">{{ $user->company->name }}</h4>
            <p class="mt-2 text-gray-600 text-sm leading-relaxed">
                {{ $user->company->description }}
            </p>
        </div>
        @endif

    </div>
@if(auth()->id() !== $user->id && $user->hasRole('candidat') && auth()->user()->hasRole('candidat'))
    <form action="{{ route('candidat.send', $user->id) }}" method="POST">
        @csrf
        <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg font-medium transition shadow-sm flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
            Ajouter en ami
        </button>
    </form>
@endif

</div>
@endsection