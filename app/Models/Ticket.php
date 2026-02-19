<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table = "tickets";
    protected $primaryKey = "id";
   
    public function event()
    {
        return $this->belongsTo(Events::class, 'event_id');
    }

}
