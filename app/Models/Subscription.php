<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id','plan_code','provider','provider_subscription_id','status','trial_ends_at','ends_at','renews_at','quantity','meta'
    ];

    protected $casts = [
        'trial_ends_at' => 'datetime',
        'ends_at' => 'datetime',
        'renews_at' => 'datetime',
        'meta' => 'array'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
