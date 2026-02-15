<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $authid = auth()->id();
        $cacheKey = "user_conversations_{$authid}";

        $conversations = cache()->remember($cacheKey, now()->addMinutes(30), function () use ($authid) {
            return Conversation::where('user_one_id', $authid)
                ->orWhere('user_two_id', $authid)
                ->with(['userOne', 'userTwo'])
                ->get();
        });

        return view('chat.conversations', ['conversations' => $conversations]);
    }

    public function start(Request $request): RedirectResponse
    {
        $authId = $request->user()->id;
        $data = $request->validate([
            'other_user_id' => ['required', 'integer', 'exists:users,id'],
        ]);

        $otherId = $data['other_user_id'];
        if ($otherId === $authId) {
            abort(400, 'Cannot start a conversation with yourself.');
        }

        $userOne = min($authId, $otherId);
        $userTwo = max($authId, $otherId);

        $conversation = Conversation::firstOrCreate([
            'user_one_id' => $userOne,
            'user_two_id' => $userTwo,
        ]);

        return redirect()->route('conversations.show', $conversation->id);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Conversation $conversation)
    {
        $authId = $request->user()->id;
        if (! in_array($authId, [$conversation->user_one_id, $conversation->user_two_id], true)) {
            abort(403, 'Unauthorized conversation access.');
        }

        $data = $request->validate([
            'text' => ['nullable', 'string', 'max:2000'],
            'attachment' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf,doc,docx', 'max:5120'],
        ]);

        if (empty($data['text']) && !$request->hasFile('attachment')) {
            return back()->with('error', 'Message or attachment is required.');
        }

        $attachmentPath = null;
        $attachmentType = null;

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $attachmentPath = $file->store('chat_attachments', 'public');
            $attachmentType = $file->getClientOriginalExtension();
        }

        $message = $conversation->messages()->create([
            'sender_id' => $authId,
            'text' => $data['text'] ?? '',
            'attachment_path' => $attachmentPath,
            'attachment_type' => $attachmentType,
        ]);

        // Notify the recipient
        $recipientId = ($conversation->user_one_id === $authId) ? $conversation->user_two_id : $conversation->user_one_id;
        $recipient = \App\Models\User::find($recipientId);
        if ($recipient) {
            $recipient->notify(new \App\Notifications\NewMessageNotification($message));
        }

        // Invalidate conversation-related caches
        cache()->forget("user_conversations_{$conversation->user_one_id}");
        cache()->forget("user_conversations_{$conversation->user_two_id}");
        cache()->forget("conversation_messages_{$conversation->id}");

        event(new MessageSent($message));

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message->load('sender')
            ]);
        }

        return redirect()->route('conversations.show', $conversation->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Conversation $conversation)
    {
        $authId = request()->user()->id;
        if (! in_array($authId, [$conversation->user_one_id, $conversation->user_two_id], true)) {
            abort(403, 'Unauthorized conversation access.');
        }

        $cacheKey = "conversation_messages_{$conversation->id}";

        $messages = cache()->remember($cacheKey, now()->addMinutes(30), function () use ($conversation) {
            return $conversation->messages()
                ->with('sender')
                ->orderBy('created_at')
                ->get();
        });

        $conversation->load(['userOne', 'userTwo']);

        return view('chat.show', [
            'conversation' => $conversation,
            'messages' => $messages
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
