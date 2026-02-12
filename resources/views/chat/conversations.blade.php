@extends('layouts.app')

@section('title', 'Conversations')

@section('content')
<div class="bg-[#f3f2f1] min-h-screen py-6">
    <div class="max-w-4xl mx-auto px-4">
        <div class="flex items-center justify-between mb-5">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Mes conversations</h1>
                <p class="text-sm text-gray-600">Discutez avec votre reseau professionnel</p>
            </div>
            <span class="text-xs font-bold text-gray-500 bg-white px-3 py-1 rounded-full border border-gray-200">
                {{ $conversations->count() }} conversations
            </span>
        </div>

        @php
            $authId = auth()->id();
        @endphp

        <div id="conversation-list" class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            @forelse ($conversations as $conversation)
                @php
                    $otherUser = $conversation->user_one_id === $authId
                        ? $conversation->userTwo
                        : $conversation->userOne;
                @endphp

                <a
                    id="conversation-{{ $conversation->id }}"
                    href="{{ route('conversations.show', $conversation->id) }}"
                    class="flex items-center gap-4 px-5 py-4 border-b border-gray-100 last:border-0 hover:bg-gray-50 transition"
                >
                    <img
                        src="{{ $otherUser?->photo ? asset('storage/' . $otherUser->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($otherUser?->name ?? 'User') . '&background=0a66c2&color=fff' }}"
                        alt="{{ $otherUser?->name ?? 'Utilisateur' }}"
                        class="w-12 h-12 rounded-full border border-gray-200 object-cover"
                    >

                    <div class="min-w-0">
                        <p class="font-semibold text-gray-900 truncate">{{ $otherUser?->name ?? 'Utilisateur inconnu' }}</p>
                        <p class="text-sm text-gray-600 truncate">{{ $otherUser?->email ?? 'Email indisponible' }}</p>
                    </div>
                </a>
            @empty
                <div class="px-6 py-10 text-center">
                    <p class="text-sm font-semibold text-gray-600">Aucune conversation pour le moment.</p>
                    <p class="text-xs text-gray-500 mt-1">Commencez une discussion depuis la page des amis.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
