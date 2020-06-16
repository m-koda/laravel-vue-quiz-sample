<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Answer;
use App\Category;

class Quiz extends Model
{
    public function answer()
    {
        return $this->hasOne('App\Answer', 'id', 'answers_id');
    }

    public function category()
    {
        return $this->hasOne('App\Category', 'id', 'categories_id');
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($answer_model) {
            $answer_model->answer()->delete();
        });
    }
}
