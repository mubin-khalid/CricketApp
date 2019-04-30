<?php


namespace App\MatchCenter;


use App\MatchStats;
use \Config;
use \DB;

class PlayMatch
{
    protected $scoringOptions;

    public function __construct()
    {
        $this->scoringOptions = Config::get('scoringOptions');
    }

    public function playBowl()
    {
        return $this->scoringOptions[rand(0, count($this->scoringOptions) - 1)];
    }

    public function updateStatus($bowlData)
    {
        MatchStats::create($bowlData);
    }

    public function getBowledOversByBowler($matchId = 1, $bowlerId = 69)
    {
        $bowled = DB::table('match_stats')
            ->where('match_id', $matchId)
            ->where('bowler_id', $bowlerId)
            ->count();
        return $bowled;
    }

    public function checkMatchStatus($matchId, $teamA, $teamB)
    {
        $score = DB::table('match_stats')->where('match_id', $matchId)->where();
    }
}
