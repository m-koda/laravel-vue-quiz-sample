<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Keyword extends Model
{
    public function category()
    {
        return $this->hasOne('App\Category', 'id', 'categories_id');
    }
}
