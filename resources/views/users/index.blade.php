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

                        <span class="absolute bottom-0 right-0 w-4 h-4 rounded-full border-2 border-white {{ $user->hasRole('recruteur') ? 'bg-purple-500' : 'bg-green-500' }}"></span>
                    </div>

                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="font-bold text-gray-900 group-hover:text-indigo-600 transition-colors text-lg">
                                {{ $user->name }}
                                @if($user->is_premium)
                                <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                @endif
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