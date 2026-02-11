<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class ConversationController extends Controller
{
    public function index(){
        $conversations=Conversation::where('user1_id',Auth::id())
        ->orWhere('user2_id',Auth::id())
        ->with((['user1','user2']))
        ->get();

        return view('conversation.index',['conversations'=>$conversations]);
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

        return redirect()->route('conversation.show', $conversation->id);
    }


     public function show(Conversation $conversation)
    {

        
        $messages = $conversation->messages()
            ->with('sender')
            ->orderBy('created_at')
            ->get();

        // Charger les utilisateurs associés à la conversation
        $conversation->load(['user1', 'user2']);

        return view('conversations.show', [
            'conversation' => $conversation,
            'messages' => $messages,
        ]);
    }



    public function store(Request $request, Conversation $conversation): RedirectResponse
    {
        $authId=$request->user()->id;

        $data = $request->validate([
            'content' => ['required', 'string', 'max:2000'],
        ]);

        $message = $conversation->messages()->create([
            'sender_id' => $authId,
            'text' => $data['text']
        ]);

      

        return redirect()->route('conversations.show', $conversation->id);
    }

    

   

}
