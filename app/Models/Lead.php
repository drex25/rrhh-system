<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'company',
        'message',
        'status',
        'contacted_at',
        'notes'
    ];

    protected $casts = [
        'contacted_at' => 'datetime',
    ];

    const STATUS_PENDING = 'pending';
    const STATUS_CONTACTED = 'contacted';
    const STATUS_CONVERTED = 'converted';
    const STATUS_LOST = 'lost';

    public static function getStatuses()
    {
        return [
            self::STATUS_PENDING => 'Pendiente',
            self::STATUS_CONTACTED => 'Contactado',
            self::STATUS_CONVERTED => 'Convertido',
            self::STATUS_LOST => 'Perdido',
        ];
    }

    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            self::STATUS_PENDING => ['class' => 'bg-yellow-100 text-yellow-800', 'text' => 'Pendiente'],
            self::STATUS_CONTACTED => ['class' => 'bg-blue-100 text-blue-800', 'text' => 'Contactado'],
            self::STATUS_CONVERTED => ['class' => 'bg-green-100 text-green-800', 'text' => 'Convertido'],
            self::STATUS_LOST => ['class' => 'bg-red-100 text-red-800', 'text' => 'Perdido'],
            default => ['class' => 'bg-gray-100 text-gray-800', 'text' => 'Desconocido'],
        };
    }
}
