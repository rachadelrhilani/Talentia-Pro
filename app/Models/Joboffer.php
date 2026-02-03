<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Joboffer extends Model
{
    protected $table = 'job_offers'; 
    protected $fillable = [
        'company_id','user_id','title','description',
        'contract_type','image','is_closed'
    ];

    public function company()
    {
        return $this->belongsTo(Companie::class);
    }

    public function recruiter()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
