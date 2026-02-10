<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Profile extends Model
{
    protected $fillable = ['user_id','title'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function educations()
    {
        return $this->hasMany(Education::class);
    }

    public function experiences()
    {
        return $this->hasMany(Experience::class);
    }

    public function skills()
    {
        return $this->belongsToMany(skill::class)->withTimestamps();
    }
}
