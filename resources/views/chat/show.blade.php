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
                        class="w-12 h-12 rounded-full border border-gray-200 object-cover">
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
                <div id="messages" data-conversation-id="{{ $conversation->id }}" data-auth-id="{{ $authId }}" class="space-y-3 mb-5 max-h-[60vh] overflow-y-auto pr-1">
                    @forelse ($messages as $message)
                    @php($isMine = (int) $message->sender_id === (int) $authId)
                    <div class="flex {{ $isMine ? 'justify-end' : 'justify-start' }}">
                        <div class="{{ $isMine ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-900' }} max-w-[70%] rounded-2xl px-4 py-2">
                            @if($message->text)
                            <p class="text-sm">{{ $message->text }}</p>
                            @endif

                            @if($message->attachment_path)
                            <div class="mt-2">
                                @if(in_array(strtolower($message->attachment_type), ['jpg', 'jpeg', 'png', 'gif']))
                                <a href="{{ asset('storage/' . $message->attachment_path) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $message->attachment_path) }}" class="rounded-lg max-w-full h-auto max-h-48 shadow-sm">
                                </a>
                                @else
                                <a href="{{ asset('storage/' . $message->attachment_path) }}" target="_blank" class="flex items-center gap-2 p-2 rounded bg-opacity-10 {{ $isMine ? 'bg-white' : 'bg-blue-600' }} hover:bg-opacity-20 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <span class="text-xs font-medium truncate">Document ({{ strtoupper($message->attachment_type) }})</span>
                                </a>
                                @endif
                            </div>
                            @endif

                            <p class="mt-1 text-[11px] {{ $isMine ? 'text-blue-100' : 'text-slate-500' }}">
                                {{ $message->sender?->name ?? 'User' }} · {{ $message->created_at?->format('H:i') }}
                            </p>
                        </div>
                    </div>
                    @empty
                    <p class="text-gray-500">No messages yet.</p>
                    @endforelse
                </div>

                @if(session('error'))
                <div class="mb-4 p-3 bg-red-100 border border-red-200 text-red-700 rounded-lg text-sm">
                    {{ session('error') }}
                </div>
                @endif

                @if ($errors->any())
                <div class="mb-4 p-3 bg-red-100 border border-red-200 text-red-700 rounded-lg text-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form id="message-form" action="{{ route('conversations.messages.store', $conversation->id) }}" method="post" enctype="multipart/form-data" class="flex flex-col gap-2">
                    @csrf
                    <div id="attachment-preview" class="hidden flex items-center gap-2 p-2 bg-blue-50 rounded-lg border border-blue-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                        </svg>
                        <span id="file-name" class="text-xs text-blue-800 font-medium truncate"></span>
                        <button type="button" id="remove-attachment" class="ml-auto text-blue-600 hover:text-blue-800">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="flex gap-2 items-center">
                        <label for="attachment-input" class="cursor-pointer text-gray-500 hover:text-blue-600 transition p-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                            </svg>
                            <input id="attachment-input" type="file" name="attachment" class="hidden">
                        </label>
                        <input
                            id="message-input"
                            type="text"
                            name="text"
                            class="flex-1 rounded-full border border-slate-300 px-4 py-2 text-sm outline-none"
                            placeholder="Type a message...">
                        <button
                            id="send-message-btn"
                            type="submit"
                            class="rounded-full bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700 transition">
                            Send
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('attachment-input')?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            document.getElementById('file-name').textContent = file.name;
            document.getElementById('attachment-preview').classList.remove('hidden');
        }
    });

    document.getElementById('remove-attachment')?.addEventListener('click', function() {
        document.getElementById('attachment-input').value = '';
        document.getElementById('attachment-preview').classList.add('hidden');
    });
</script>
@endsection