<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Joboffer extends Model
{
    use HasFactory;
    protected $table = 'job_offers';
    protected $fillable = [
        'company_id',
        'user_id',
        'title',
        'description',
        'location',
        'salary',
        'image',
        'contract_type',
        'is_closed',
        'slug'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($job) {
            $job->slug = Str::slug($job->title) . '-' . uniqid();
        });

        static::updating(function ($job) {
            if ($job->isDirty('title')) {
                $job->slug = Str::slug($job->title) . '-' . uniqid();
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

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
        return $this->hasMany(Application::class, "job_offer_id");
    }
}
