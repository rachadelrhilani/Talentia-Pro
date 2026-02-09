<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Joboffer extends Model
{
    use HasFactory;
    protected $table = 'job_offers'; 
    protected $fillable = [
        'company_id','user_id','title','description','location',
    'salary','image',
        'contract_type','is_closed'
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
        return $this->hasMany(Application::class,"job_offer_id");
    }
}
