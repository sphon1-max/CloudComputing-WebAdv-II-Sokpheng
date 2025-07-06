<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admin'; // 👈 match your actual table name
    protected $primaryKey = 'admin_id'; // 👈 if not using 'id'
    public $timestamps = false; // 👈 add this if no created_at/updated_at

    protected $fillable = ['first_name', 'last_name', 'email', 'password'];
    protected $hidden = ['password'];
}
