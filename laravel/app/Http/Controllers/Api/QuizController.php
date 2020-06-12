<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Quiz;

class QuizController extends Controller
{
    public function index(Request $request)
    {
        $categories = $request->input('categories');
        if ($categories) {
            $categories = explode(',', $categories); //stringで受け取るのでarrayに変換する
        } else {
            return [];
        }
        $quizzes = Quiz::with('answer', 'category')
            ->whereIn('quizzes.categories_id', $categories)
            ->inRandomOrder()
            ->limit(10)
            ->get();
        return $quizzes;
    }
}
