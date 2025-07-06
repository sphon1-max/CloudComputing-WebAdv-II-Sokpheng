<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EventImage extends Model
{
    use HasFactory;

    protected $table = 'eventimage'; // 👈 or use 'eventimages' if that's your table name

    protected $primaryKey = 'event_id';

    public function events()
    {
        return $this->belongsTo(Events::class, 'event_id');
    }
}
