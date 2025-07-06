<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = "payment";
    protected $primaryKey="payment_id";

    public function userticket()
    {
        return $this->belongsTo(Userticket::class, 'user_ticket_id', 'user_ticket_id');
    }
}
