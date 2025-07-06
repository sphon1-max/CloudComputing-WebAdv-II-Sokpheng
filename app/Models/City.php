<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'city'; 
    protected $primaryKey = 'city_id';


    public function events()
    {
        return $this->hasMany(Events::class, 'city_id');
    }
}
