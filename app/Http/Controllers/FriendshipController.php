<?php

namespace App\Http\Controllers;

use App\Models\Friendship;
use App\Models\User;
use Illuminate\Http\Request;

class FriendshipController extends Controller
{
    public function index()
    {
        $friends = Friendship::where('sender_id', auth()->id())
            ->orWhere('receiver_id', auth()->id())
            ->get();

        return view('candidat.friends.index', compact('friends'));
    }

    public function send(User $user)
    {
        Friendship::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $user->id,
            'status' => 'pending'
        ]);

        return back();
    }

    public function accept(Friendship $friendship)
    {
        $friendship->update(['status' => 'accepted']);
        return back();
    }

    public function reject(Friendship $friendship)
    {
        $friendship->delete();
        return back();
    }
}
