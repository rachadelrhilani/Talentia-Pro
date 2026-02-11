@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-10 px-4">
    <div class="mb-8">
        <h2 class="text-2xl font-extrabold text-gray-900">Résultats de recherche</h2>
        <p class="text-sm text-gray-500 mt-1">{{ $users->count() }} profils trouvés</p>
    </div>

    <div class="space-y-4">
        @foreach($users as $user)
        <a href="{{ route('users.show', $user) }}" 
           class="group block bg-white p-5 rounded-xl border border-gray-100 shadow-sm hover:shadow-md hover:border-indigo-200 transition-all duration-200">
            
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <img src="{{ $user->photo ? asset('storage/'.$user->photo) : 'https://ui-avatars.com/api/?name='.urlencode($user->name) }}" 
                             class="w-16 h-16 rounded-full object-cover ring-2 ring-transparent group-hover:ring-indigo-500 transition-all">
                        
                        {{-- Online/Offline Status Indicator --}}
                        <span class="absolute bottom-0 right-0 w-4 h-4 rounded-full border-2 border-white {{ $user->isOnline() ? 'bg-green-500 animate-pulse' : 'bg-gray-400' }}"
                              title="{{ $user->isOnline() ? 'Online' : 'Last seen ' . ($user->last_seen_at ? $user->last_seen_at->diffForHumans() : 'never') }}">
                        </span>
                    </div>

                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="font-bold text-gray-900 group-hover:text-indigo-600 transition-colors text-lg">
                                {{ $user->name }}
                            </h3>
                        </div>

                        <p class="text-xs font-semibold uppercase tracking-wider {{ $user->hasRole('recruteur') ? 'text-purple-600' : 'text-green-600' }}">
                            {{ $user->hasRole('recruteur') ? 'Recruteur' : 'Candidat' }}
                        </p>

                    </div>
                </div>

                <div class="hidden md:block opacity-0 group-hover:opacity-100 transition-opacity transform group-hover:translate-x-1">
                    <svg class="w-6 h-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="9 5l7 7-7 7"></path>
                    </svg>
                </div>
            </div>
        </a>
        @endforeach
    </div>
</div>
@endsection