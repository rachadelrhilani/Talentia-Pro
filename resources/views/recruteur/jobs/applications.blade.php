@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-8 px-4">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900">Candidatures reçues</h1>
            <p class="text-gray-500 mt-1">Gérez les postulants pour vos offres d'emploi.</p>
        </div>
        <span class="bg-indigo-100 text-indigo-700 px-4 py-1.5 rounded-full text-sm font-bold">
            {{ $applications->count() }} Total
        </span>
    </div>

    <div class="grid gap-4">
        @forelse($applications as $app)
        <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-sm hover:shadow-md transition-shadow duration-300 flex flex-col md:flex-row md:items-center justify-between gap-4">

            <div class="flex items-center gap-4">
                <div class="w-12 h-12 flex-shrink-0">
                    @if($app->candidate->photo)
                    <img src="{{ asset('storage/' . $app->candidate->photo) }}"
                        alt="{{ $app->candidate->name }}"
                        class="w-12 h-12 rounded-full object-cover border-2 border-indigo-100 shadow-sm">
                    @else
                    <div class="w-12 h-12 bg-indigo-500 text-white rounded-full flex items-center justify-center font-bold text-xl shadow-inner">
                        {{ strtoupper(substr($app->candidate->name, 0, 1)) }}
                    </div>
                    @endif
                </div>

                <div>
                    <h2 class="text-lg font-bold text-gray-800">{{ $app->candidate->name }}</h2>
                    <div class="flex items-center gap-3 mt-1">
                        {{-- Status Badge --}}
                        @if($app->status === 'accepted')
                        <span class="flex items-center gap-1 text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded text-[11px] font-bold uppercase tracking-wider">
                            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span> Acceptée
                        </span>
                        @elseif($app->status === 'rejected')
                        <span class="flex items-center gap-1 text-red-600 bg-red-50 px-2 py-0.5 rounded text-[11px] font-bold uppercase tracking-wider">
                            <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span> Refusée
                        </span>
                        @else
                        <span class="flex items-center gap-1 text-amber-600 bg-amber-50 px-2 py-0.5 rounded text-[11px] font-bold uppercase tracking-wider">
                            <span class="w-1.5 h-1.5 bg-amber-500 rounded-full animate-pulse"></span> En attente
                        </span>
                        @endif
                        <span class="text-gray-400 text-xs italic">Envoyée {{ $app->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex items-center gap-2">
                @if($app->status === 'pending')
                <form action="{{ route('recruteur.applications.update', $app->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="accepted">
                    <button class="flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2 rounded-xl text-sm font-bold transition-all shadow-sm hover:shadow-emerald-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Accepter
                    </button>
                </form>

                <form action="{{ route('recruteur.applications.update', $app->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="rejected">
                    <button class="flex items-center gap-2 bg-white border border-red-200 text-red-600 hover:bg-red-50 px-5 py-2 rounded-xl text-sm font-bold transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Refuser
                    </button>
                </form>
                @else
                <a href="{{route('users.show',$app->candidate->id)}}" class="text-indigo-600 hover:text-indigo-800 text-sm font-bold px-4">
                    Voir le profil
                </a>
                @endif
            </div>

        </div>
        @empty
        <div class="text-center py-20 bg-white rounded-3xl border-2 border-dashed border-gray-200">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-50 rounded-full mb-4">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                </svg>
            </div>
            <p class="text-gray-500 text-lg font-medium">Aucune candidature pour le moment.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection