@extends('layouts.app')

@section('content')
<div class="bg-[#f3f2f1] min-h-screen py-8">
    @if(session('success'))
   <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-6 flex justify-between items-center" role="alert">
      <span class="block sm:inline font-bold">{{ session('success') }}</span>
      <button onclick="this.parentElement.remove()" class="text-green-700 font-bold">
         &times;
      </button>
   </div>
   @endif
    <div class="max-w-4xl mx-auto px-4">

        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Gérer mon réseau</h1>
                <p class="text-sm text-gray-600">Restez en contact avec vos relations professionnelles</p>
            </div>
            <span class="text-sm font-bold text-gray-500 bg-white px-3 py-1 rounded-full border border-gray-200">
                {{ $friends->count() }} Connexions
            </span>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            @forelse($friends as $friend)
            <div class="p-4 sm:p-6 border-b border-gray-100 last:border-0 hover:bg-gray-50 transition duration-200 flex items-center justify-between">

                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <img src="{{ auth()->user()->photo ? asset('storage/' . $friend->photo) : 'https://ui-avatars.com/api/?name=' . urlencode(friend->name) . '&background=0a66c2&color=fff' }}"
                            class="w-16 h-16 rounded-full border border-gray-200 shadow-sm" alt="Avatar">
                        <div class="absolute bottom-1 right-1 w-4 h-4 bg-green-500 border-2 border-white rounded-full"></div>
                    </div>

                    <div>
                        <h3 class="text-lg font-bold text-gray-900 hover:text-[#0a66c2] cursor-pointer">
                            {{ $friend->name ?? 'Utilisateur Talentia' }}
                        </h3>
                        <p class="text-sm text-gray-600">{{$friend->bio}}</p>

                        <div class="mt-1 flex items-center space-x-2">
                            @if($friend->status == 'pending')
                            <span class="text-[10px] font-bold text-orange-600 bg-orange-50 px-2 py-0.5 rounded uppercase tracking-wide border border-orange-100">
                                En attente
                            </span>
                            @else
                            <span class="text-[10px] font-bold text-[#0a66c2] bg-blue-50 px-2 py-0.5 rounded uppercase tracking-wide border border-blue-100">
                                Connecté
                            </span>
                            @endif
                            <span class="text-gray-400 text-xs">•</span>
                            <span class="text-gray-400 text-xs italic">Depuis {{ $friend->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>

                <div class="flex items-center space-x-2">
                    @if($friend->status == 'pending')
                    <div class="flex items-center gap-2">

                        <form action="{{ route('candidat.reject', $friend->friendship_id) }}" method="POST">
                            @csrf
                            <button type="submit" class="text-gray-500 font-bold hover:bg-gray-100 px-4 py-1.5 rounded-full text-sm transition border border-gray-300">
                                Ignorer
                            </button>
                        </form>

                        <form action="{{ route('candidat.accept', $friend->friendship_id) }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-[#0a66c2] text-white font-bold px-4 py-1.5 rounded-full text-sm hover:bg-[#004182] transition shadow-sm">
                                Accepter
                            </button>
                        </form>

                    </div>
                    @else
                    <button class="border border-gray-400 text-gray-600 font-bold px-4 py-1.5 rounded-full text-sm hover:bg-gray-100 transition">
                        Message
                    </button>
                    @endif
                </div>

            </div>
            @empty
            <div class="p-16 text-center">
                <div class="mb-4 flex justify-center text-gray-300">
                    <svg class="w-20 h-20" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M16 11c1.66 0 3-1.34 3-3s-1.34-3-3-3-3 1.34-3 3 1.34 3 3 3zm-8 0c1.66 0 3-1.34 3-3S9.66 5 8 5 5 6.34 5 8s1.34 3 3 3zm4 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                    </svg>
                </div>
                <p class="text-gray-500 text-lg font-medium">Vous n'avez pas encore de connexions.</p>
                <p class="text-gray-400 text-sm">Commencez par explorer les profils suggérés !</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection