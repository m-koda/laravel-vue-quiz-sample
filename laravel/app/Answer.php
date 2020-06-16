<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    public function findAnswersSelectBoxInAdmin(): array
    {
        $answersIds = Answer::select('id')->get();
        $answersIdsArray = [];
        $count = count($answersIds);
        foreach ($answersIds as $answersId) {
            $answersIdsArray[$answersId->id] = $answersId->id;
            if ($count === $answersId->id) {
                // foreachが最後であれば、Answerテーブルの最新IDの次のIDを追加する
                $answersIdsArray[$answersId->id + 1] = $answersId->id + 1;
            }
        }
        return $answersIdsArray;
    }

    public function find4AnswersSelectBoxInAdmin(): array
    {
        $correctAnswerNoArray = [];
        // 4択問題なので、1-4のセレクトボックスを生成
        for ($i = 1; $i <= 4; $i++) {
            $correctAnswerNoArray[$i] = $i;
        }
        return $correctAnswerNoArray;
    }
}
