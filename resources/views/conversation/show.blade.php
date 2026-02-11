<x-structure title="Conversation">
    <div class="max-w-3xl mx-auto p-6">
        @php
            $authId = auth()->id();
            $otherUser = $conversation->user_one_id === $authId
                ? $conversation->user2
                : $conversation->user1;
        @endphp

        <div class="flex items-center gap-4 mb-6">
            @if ($otherUser && $otherUser->pic_path)
                <img
                    src="{{ asset('storage/' . $otherUser->pic_path) }}"
                    alt="{{ $otherUser->name }}"
                    class="w-12 h-12 rounded-full object-cover"
                >
            @else
                <div class="w-12 h-12 rounded-full bg-slate-200"></div>
            @endif
            <div>
                <h1 class="text-xl font-semibold">{{ $otherUser->name ?? 'Conversation' }}</h1>
                <p class="text-sm text-gray-500">{{ $otherUser->email ?? '' }}</p>
            </div>
        </div>

        <div id="messages" data-conversation-id="{{ $conversation->id }}" class="space-y-3 mb-6">
            @forelse ($messages as $message)
                @php($isMine = $message->sender_id === $authId)
                <div class="flex {{ $isMine ? 'justify-end' : 'justify-start' }}">
                    <div class="{{ $isMine ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-900' }} max-w-[70%] rounded-2xl px-4 py-2">
                        <p class="text-sm">{{ $message->text }}</p>
                        <p class="mt-1 text-[11px] {{ $isMine ? 'text-blue-100' : 'text-slate-500' }}">
                            {{ $message->sender->name ?? 'User' }} · {{ $message->created_at->format('H:i') }}
                        </p>
                    </div>
                </div>
            @empty
                <p class="text-gray-500">No messages yet.</p>
            @endforelse
        </div>

        <form action="{{ route('conversations.store', $conversation->id) }}" method="post" class="flex gap-2">
            @csrf
            <input
                type="text"
                name="text"
                class="flex-1 rounded-full border border-slate-300 px-4 py-2 text-sm outline-none"
                placeholder="Type a message..."
                required
            >
            <button
                type="submit"
                class="rounded-full bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700"
            >
                Send
            </button>
        </form>
    </div>
    @vite('resources/js/conversation.js')
</x-structure>
