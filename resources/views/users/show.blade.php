@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto my-10 px-4">
    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-6 flex justify-between items-center" role="alert">
        <span class="block sm:inline font-bold">{{ session('success') }}</span>
        <button onclick="this.parentElement.remove()" class="text-green-700 font-bold">
            &times;
        </button>
    </div>
    @endif
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        <div class="h-32 bg-gradient-to-r from-blue-500 to-indigo-600"></div>

        <div class="relative px-6 pb-8">
            <div class="relative -mt-16 mb-4">
                <img src="{{ $user->photo ? asset('storage/'.$user->photo) : 'https://ui-avatars.com/api/?name='.urlencode($user->name) }}"
                    class="w-32 h-32 rounded-2xl object-cover border-4 border-white shadow-md bg-white">
            </div>

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 flex">
                        {{ $user->name }}
                        @if($user->is_premium)
                        <svg class="w-[40px] text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                        @endif
                    </h1>
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
                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Compétences
            </h2>

            <div class="flex flex-wrap gap-2">
                @if($user->profile && $user->profile->skills->count() > 0)
                @foreach($user->profile->skills as $skill)
                <span class="px-3 py-1.5 bg-gray-50 text-gray-700 border border-gray-200 rounded-lg text-sm font-medium hover:border-indigo-300 transition-colors">
                    {{ $skill->name }}
                </span>
                @endforeach
                @else
                <p class="text-sm text-gray-400 italic">Aucune compétence renseignée.</p>
                @endif
            </div>
            {{-- Section Expériences et Éducation --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">

                {{-- Expériences Professionnelles --}}
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Expériences
                    </h2>

                    <div class="space-y-6 relative before:absolute before:inset-y-0 before:left-3 before:w-0.5 before:bg-gray-100">
                        @if($user->profile && $user->profile->experiences->count() > 0)
                        @foreach($user->profile->experiences as $exp)
                        <div class="relative pl-8">
                            <span class="absolute left-0 top-1.5 w-6 h-6 bg-white border-2 border-indigo-500 rounded-full flex items-center justify-center">
                                <span class="w-2 h-2 bg-indigo-500 rounded-full"></span>
                            </span>
                            <h3 class="font-bold text-gray-900 leading-tight">{{ $exp->position }}</h3>
                            <p class="text-indigo-600 font-medium text-sm">{{ $exp->company }}</p>
                            <p class="text-xs text-gray-400 mt-1">
                                {{ \Carbon\Carbon::parse($exp->start_date)->format('M Y') }} -
                                {{ $exp->end_date ? \Carbon\Carbon::parse($exp->end_date)->format('M Y') : 'Présent' }}
                            </p>
                        </div>
                        @endforeach
                        @else
                        <p class="text-sm text-gray-400 italic pl-8">Aucune expérience renseignée.</p>
                        @endif
                    </div>
                </div>

                {{-- Éducation / Diplômes --}}
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                        </svg>
                        Éducation
                    </h2>

                    <div class="space-y-6 relative before:absolute before:inset-y-0 before:left-3 before:w-0.5 before:bg-gray-100">
                        @if($user->profile && $user->profile->educations->count() > 0)
                        @foreach($user->profile->educations as $edu)
                        <div class="relative pl-8">
                            <span class="absolute left-0 top-1.5 w-6 h-6 bg-white border-2 border-purple-500 rounded-full flex items-center justify-center">
                                <span class="w-2 h-2 bg-purple-500 rounded-full"></span>
                            </span>
                            <h3 class="font-bold text-gray-900 leading-tight">{{ $edu->degree }}</h3>
                            <p class="text-purple-600 font-medium text-sm">{{ $edu->school }}</p>
                            <p class="text-xs text-gray-400 mt-1">
                                {{ $edu->year_start }} - {{ $edu->year_end ?? 'En cours' }}
                            </p>
                        </div>
                        @endforeach
                        @else
                        <p class="text-sm text-gray-400 italic pl-8">Aucun diplôme renseigné.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if($user->company)
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1"></path>
                </svg>
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
    <form action="{{ route('candidat.send', $user) }}" method="POST">
        @csrf
        <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg font-medium transition shadow-sm flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
            </svg>
            Ajouter en ami
        </button>
    </form>
    @endif

</div>
@endsection