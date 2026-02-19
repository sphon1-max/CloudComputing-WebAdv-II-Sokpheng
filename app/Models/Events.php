<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\EventImage;

class Events extends Model
{
    protected $table = "events";
    protected $primaryKey = "id";
    
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // Events belongs to ONE city
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    // Events has MANY tickets
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'event_id');
    }

    // Events belongs to ONE user (organizer)
    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    // Events has MANY images
    public function eventimage()
    {
        return $this->hasMany(EventImage::class, 'event_id');
    }

    
}

