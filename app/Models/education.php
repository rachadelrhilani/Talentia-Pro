<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class education extends Model
{
    protected $fillable = ['profile_id','degree','school','year_start','year_end'];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}
