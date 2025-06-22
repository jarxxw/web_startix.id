<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;


class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'event_date',
        'venue',
        'city',
        'type',
        'price',
        'capacity',
        'available_tickets',
        'status'
    ];

    protected $casts = [
        'event_date' => 'datetime',
        'price' => 'decimal:2'
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function getFormattedDateAttribute()
    {
        return $this->event_date->format('d M Y H:i');
    }

    public function getMonthAttribute()
    {
        return $this->event_date->format('m');
    }

    public function getYearAttribute()
    {
        return $this->event_date->format('Y');
    }
    public function scopeBerjalan(Builder $query)
    {
    return $query->whereDate('event_date', '>=', Carbon::today())
                     ->whereRaw('
                         (SELECT COUNT(*) FROM ticket_orders 
                          WHERE ticket_orders.event_id = events.id 
                          AND ticket_orders.status = "confirmed")
                         < events.capacity
                     ');
    }

    public function scopeSelesai(Builder $query)
    {
    return $query->whereDate('event_date', '<', Carbon::today())
                     ->orWhereRaw('
                         (SELECT COUNT(*) FROM ticket_orders 
                          WHERE ticket_orders.event_id = events.id 
                          AND ticket_orders.status = "confirmed")
                         >= events.capacity
                     ');
    }
    // app/Models/Event.php
    public function ticketOrders()
    {
        return $this->hasMany(\App\Models\TicketOrder::class);
    }
    public function checkins()
{
    return $this->hasMany(\App\Models\Checkin::class);
}




    
} 