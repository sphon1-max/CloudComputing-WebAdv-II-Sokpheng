<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Events;

class category extends Model
{
    protected $table = "category";
    protected $primaryKey = "category_id";



    public function events()
    {
        return $this->hasMany(Events::class, 'category_id');
    }


}
