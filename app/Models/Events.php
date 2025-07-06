<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\EventImage;

class Events extends Model
{
    protected $table = "events";
    protected $primaryKey = "event_id";
    
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'event_id');
    }
    public function organizer()
    {
        return $this->belongsTo(Organizers::class, 'organizer_id');
    }
    public function eventimage()
    {
        return $this->hasMany(EventImage::class, 'event_id');
    }

    
}

