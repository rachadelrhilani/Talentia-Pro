<!-- resources/views/conversations/index.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conversations</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100">
    <div class="max-w-4xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6">Conversations</h1>
        
        @php
            $authId = auth()->id();
        @endphp

        @if ($conversations->isEmpty())
            <p class="text-gray-500">No conversations yet.</p>
        @else
            <div class="space-y-4">
                @foreach ($conversations as $conversation)
                    @php
                        $otherUser = $conversation->user_one_id === $authId
                            ? $conversation->userTwo
                            : $conversation->userOne;
                    @endphp

                    <a
                        href="{{ route('conversations.show', $conversation->id) }}"
                        class="flex items-center gap-4 border rounded-xl p-4 shadow-sm hover:bg-slate-50"
                    >
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
                            <p class="font-semibold">
                                {{ $otherUser?->name ?? 'Unknown user' }}
                            </p>
                            <p class="text-sm text-gray-600">
                                {{ $otherUser?->email ?? 'No email' }}
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</body>
</html>
