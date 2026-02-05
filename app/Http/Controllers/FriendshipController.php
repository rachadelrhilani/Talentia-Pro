<?php

namespace App\Http\Controllers;

use App\Models\Friendship;
use App\Models\User;
use Illuminate\Http\Request;

class FriendshipController extends Controller
{
   public function index()
{
    $userId = auth()->id();

    // seulement invitations reçues + connexions acceptées
    $friendships = Friendship::with(['sender','receiver'])
        ->where(function ($query) use ($userId) {

            // invitations reçues
            $query->where('receiver_id', $userId);

        })
        ->orWhere(function ($query) use ($userId) {

            // connexions acceptées
            $query->where('status', 'accepted')
                  ->where(function ($q) use ($userId) {
                        $q->where('sender_id', $userId)
                          ->orWhere('receiver_id', $userId);
                  });

        })
        ->get();

    $friends = $friendships->map(function ($friendship) use ($userId) {

        $friend = $friendship->sender_id == $userId
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
    if (auth()->id() === $user->id) {
        return back()->with('error', 'Vous ne pouvez pas vous ajouter vous-même.');
    }


    $exists = Friendship::where('sender_id', auth()->id())
                        ->where('receiver_id', $user->id)
                        ->exists();

    if (!$exists) {
        Friendship::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $user->id,
            'status' => 'pending'
        ]);
    }

    return back()->with('success', 'Invitation envoyée !');
}

public function accept(Friendship $friendship)
{
  
    if ($friendship->receiver_id !== auth()->id()) {
        abort(403);
    }

    $friendship->update(['status' => 'accepted']);

    return back()->with('success', 'Vous êtes maintenant amis.');
}

public function reject(Friendship $friendship)
{

    if ($friendship->receiver_id !== auth()->id() && $friendship->sender_id !== auth()->id()) {
        abort(403);
    }

    $friendship->delete();

    return back()->with('info', 'Invitation supprimée.');
}
}
