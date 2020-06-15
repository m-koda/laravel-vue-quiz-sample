<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Carbon\Carbon;

class Ranking extends Model
{
    public function insertScore(int $correctRatio, int $userId)
    {
        $ranking = new Ranking();
        $ranking->percentage_correct_answer = $correctRatio;
        $ranking->user_id = $userId;
        $ranking->save();
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function getCreatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y/m/d');
    }
}
