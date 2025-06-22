<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkin extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'name',
        'identity_number',
        'jam_checkin',
        'status',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
