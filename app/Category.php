<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function posts(){
        // il $this indica proprio la categoria, in questo caso Category.

        // N.B.: belongsTo-> singolare (infatti category)
        return $this->belongsTo('App\Category');
    }
};
