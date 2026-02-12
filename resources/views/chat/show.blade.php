@extends('layouts.app')

@section('title', 'Conversation')

@section('content')
<div class="bg-[#f3f2f1] min-h-screen py-6">
    <div class="max-w-4xl mx-auto px-4">
        @php
            $authId = auth()->id();
            $otherUser = $conversation->user_one_id === $authId
                ? $conversation->userTwo
                : $conversation->userOne;
        @endphp

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between gap-4">
                <div class="flex items-center gap-3 min-w-0">
                    <img
                        src="{{ $otherUser?->photo ? asset('storage/' . $otherUser->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($otherUser?->name ?? 'User') . '&background=0a66c2&color=fff' }}"
                        alt="{{ $otherUser?->name ?? 'Utilisateur' }}"
                        class="w-12 h-12 rounded-full border border-gray-200 object-cover"
                    >
                    <div class="min-w-0">
                        <h1 class="text-base font-bold text-gray-900 truncate">{{ $otherUser?->name ?? 'Conversation' }}</h1>
                        <p class="text-xs text-gray-500 truncate">{{ $otherUser?->email ?? '' }}</p>
                    </div>
                </div>
                <a href="{{ route('myconv') }}" class="text-xs font-semibold text-[#0a66c2] hover:underline whitespace-nowrap">
                    Toutes les conversations
                </a>
            </div>

            <div class="p-5">
                <div id="messages" data-conversation-id="{{ $conversation->id }}" class="space-y-3 mb-5 max-h-[60vh] overflow-y-auto pr-1">
                    @forelse ($messages as $message)
                        @php($isMine = (int) $message->sender_id === (int) $authId)
                        <div class="flex {{ $isMine ? 'justify-end' : 'justify-start' }}">
                            <div class="{{ $isMine ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-900' }} max-w-[70%] rounded-2xl px-4 py-2">
                                <p class="text-sm">{{ $message->text }}</p>
                                <p class="mt-1 text-[11px] {{ $isMine ? 'text-blue-100' : 'text-slate-500' }}">
                                    {{ $message->sender?->name ?? 'User' }} · {{ $message->created_at?->format('H:i') }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500">No messages yet.</p>
                    @endforelse
                </div>

                <form id="message-form" action="{{ route('conversations.messages.store', $conversation->id) }}" method="post" class="flex gap-2">
                    @csrf
                    <input
                        id="message-input"
                        type="text"
                        name="text"
                        class="flex-1 rounded-full border border-slate-300 px-4 py-2 text-sm outline-none"
                        placeholder="Type a message..."
                        required
                    >
                    <button
                        id="send-message-btn"
                        type="submit"
                        class="rounded-full bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700"
                    >
                        Send
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
