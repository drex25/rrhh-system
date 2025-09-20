<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'code','name','description','interval','price_cents','yearly_price_cents','currency','is_active','features'
    ];

    protected $casts = [
        'features' => 'array',
        'is_active' => 'boolean'
    ];

    public function monthlyPrice(): float { return $this->price_cents/100; }
    public function annualPrice(): float { return ($this->yearly_price_cents ?? ($this->price_cents*12*0.8))/100; }

}
