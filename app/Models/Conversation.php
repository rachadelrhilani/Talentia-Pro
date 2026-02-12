<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conversation extends Model
{
    //
    protected $fillable = [
        'user_one_id',
        'user_two_id',
        'text',
        'sender_id',
    ];


    public function messages(): HasMany
    {
        return $this->hasMany(Message::class,'conversation_id');
    }

    public function userOne()
    {
        return $this->belongsTo(User::class,'user_one_id');
    }

    public function userTwo()
    {
        return $this->belongsTo(User::class,'user_two_id');
    }
}
