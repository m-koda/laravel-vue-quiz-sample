<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Ranking;
use DB;

class RankingController extends Controller
{
    public function index()
    {
        $weekRanking = $this->getWeekRanking();

        $weekRankingData = [
            'percentage_correct_answer' => $weekRanking->pluck('percentage_correct_answer')->all(),
            'name' => $weekRanking->pluck('user.name')->all()
        ];

        $monthRanking = $this->getWeekRanking();

        $monthRankingData = [
            'percentage_correct_answer' => $monthRanking->pluck('percentage_correct_answer')->all(),
            'name' => $monthRanking->pluck('user.name')->all()
        ];

        $totalRanking = $this->getTotalRanking();

        $totalRankingData = [
            'percentage_correct_answer' => $totalRanking->pluck('percentage_correct_answer')->all(),
            'name' => $totalRanking->pluck('user.name')->all()
        ];

        return ['weekRankingData' => $weekRankingData, 'monthRankingData' => $monthRankingData, 'totalRankingData' => $totalRankingData];
    }

    protected function getWeekRanking()
    {
        $weekRanking = Ranking::with('user')
            ->select(DB::raw('MAX(rankings.percentage_correct_answer) as percentage_correct_answer, rankings.user_id'))
            ->whereBetween('rankings.created_at', [now()->startOfWeek()->format('Y-m-d'), now()->endOfWeek()->format('Y-m-d')])
            ->limit(5)
            ->orderby('percentage_correct_answer', 'desc')
            ->groupBy('rankings.user_id')
            ->get();

        return $weekRanking;
    }

    protected function getMonthRanking()
    {
        $monthRanking = Ranking::with('user')
            ->select(DB::raw('MAX(rankings.percentage_correct_answer) as percentage_correct_answer, rankings.user_id'))
            ->whereBetween('rankings.created_at', [now()->startOfMonth()->format('Y-m-d'), now()->endOfMonth()->format('Y-m-d')])
            ->limit(5)
            ->orderby('percentage_correct_answer', 'desc')
            ->groupBy('rankings.user_id')
            ->get();

        return $monthRanking;
    }

    protected function getTotalRanking()
    {
        $totalRanking = Ranking::with('user')
            ->select(DB::raw('MAX(rankings.percentage_correct_answer) as percentage_correct_answer, rankings.user_id'))
            ->limit(5)
            ->orderby('percentage_correct_answer', 'desc')
            ->groupBy('rankings.user_id')
            ->get();

        return $totalRanking;
    }
}
