<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Events;

class Category extends Model
{
    protected $table = "categories";
    protected $primaryKey = "id";



    public function events()
    {
        return $this->hasMany(Events::class, 'category_id');
    }


}
