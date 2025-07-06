<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Userticket extends Model
{
    protected $table = "userticket";
    protected $primaryKey="user_ticket_id";

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }
    public function payment()
{
    return $this->hasOne(Payment::class, 'user_ticket_id', 'user_ticket_id');
}



}
