<?php

namespace App\Http\Controllers;

use App\Models\Friendship;
use App\Models\User;
use Illuminate\Http\Request;

class FriendshipController extends Controller
{
    public function index()
    {
        $friendships = Friendship::with(['sender','receiver'])
            ->where('sender_id', auth()->id())
            ->orWhere('receiver_id', auth()->id())
            ->get();

        $friends = $friendships->map(function ($friendship) {

            $friend = $friendship->sender_id == auth()->id()
                ? $friendship->receiver
                : $friendship->sender;

            $friend->status = $friendship->status;
            $friend->updated_at = $friendship->updated_at;
            $friend->friendship_id = $friendship->id;

            return $friend;
        });

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
