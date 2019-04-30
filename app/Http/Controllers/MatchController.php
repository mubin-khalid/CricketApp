<?php

namespace App\Http\Controllers;

use App\MatchCenter\PlayMatch;
use App\MatchCenter\Matches;
use App\Player;
use App\Team;
use Illuminate\Http\Request;

class MatchController extends Controller
{
    protected $matches;
    protected $play;
    protected $battingTeam;
    protected $bowlingTeam;
    protected $batsman;
    protected $batterA;
    protected $batterB;
    protected $chase;

    public function __construct(Matches $matches, PlayMatch $play)
    {
        $this->matches = $matches;
        $this->play = $play;
        $this->chase = false;
    }

    public function index($matchId = 0)
    {
        //$this->play->getBowledOversByBowler();
        return $this->startMatch();
    }

    public function startMatch()
    {
        $teams = $this->matches->getTeams();
        if ($teams) {
            shuffle($teams);
            $match = $this->matches->updateMatch($teams);
            $this->battingTeam = $this->matches->getBattingTeam($teams[0]);
            $this->bowlingTeam = $this->matches->getBowlingTeam($teams[1]);
            $this->playMatch($match->id);
            $temp = $this->battingTeam;
            $this->battingTeam = $this->bowlingTeam;
            $this->bowlingTeam = $temp;
            echo "<hr />Second Innings<br />";
            $this->chase = true;
            $this->playMatch($match->id);
        }
    }

    private function playMatch($matchId)
    {
        $lastBowler = 0;
        $bowler = 0;
        $over = 1;
        $this->batterB = $this->batterA = $this->getBatsman();
        while ($this->batterA == $this->batterB) {
            $this->batterB = $this->getBatsman();
        }
        $this->batsman = $this->batterA;
        do {
            while ($lastBowler == $bowler) {
                $bowler = $this->getBowler();
            }
            $bowl = 1;
            $outcome = null;
            do {
                $outcome = $this->play->playBowl();
                if ($outcome == 'w') {
                    $col = 'wicket';
                } elseif ($outcome == 'extra') {
                    $col = 'extra';
                } else {
                    $col = $outcome . 's';
                }
                echo "Over: $over, Bowl: $bowl, $outcome<br />";
                $this->play->updateStatus([
                    'match_id' => $matchId,
                    'batsman_id' => $this->batsman,
                    'bowler_id' => $bowler,
                    'bowl' => $bowl,
                    'over_number' => $over,
                    $col => 1,
                ]);
                if($this->chase) {
                    $this->checkMatchStatus($matchId);
                }
                if ($col != 'extra') {
                    $this->changeBatter($outcome, $bowl);
                    $bowl += 1;
                }
            } while ($bowl <= 6);
            $lastBowler = $bowler;
            $over += 1;
        } while ($over <= 3);
    }
    private function checkMatchStatus($matchId)
    {
        //todo
    }
    private function changeBatter($outcome, $bowl)
    {

        if ($outcome == 'w' && $bowl != 6) {
            if ($this->batterA == $this->batsman) {
                $this->batterA = $this->getBatsman();
                $this->batsman = $this->batterA;
            } else {
                $this->batterB = $this->getBatsman();
                $this->batsman = $this->batterB;
            }
        } elseif ($outcome == 'w' && $bowl == 6) {
            if ($this->batterA = $this->batsman) {
                $this->batterA = $this->getBatsman();
                $this->batsman = $this->batterB;
            } else {
                $this->batterB = $this->getBatsman();
                $this->batsman = $this->batterA;
            }
        } elseif ($bowl != 6 && ($outcome == 1 || $outcome == 3) ) {
            if ($this->batsman == $this->batterA) {
                $this->batsman = $this->batterB;
            }else{
                $this->batsman = $this->batterA;
            }
        } else {
            if ($bowl == 6 && ($outcome == 0 || $outcome == 2 || $outcome == 4 || $outcome == 6)) {
                $this->batsman = ($this->batsman == $this->batterA) ? $this->batterB : $this->batterA;
            }
            elseif ($bowl == 6 && ($outcome == 1 || $outcome == 3)) {
                $this->batsman = ($this->batsman == $this->batterA) ? $this->batterA : $this->batterB;
            }
        }
    }

    private function getBatsman()
    {
        $batsman = $this->battingTeam[rand(0, count($this->battingTeam) - 1)]->id;

        return $batsman;
    }

    private function getBowler()
    {
        $bowler = $this->bowlingTeam[rand(0, count($this->bowlingTeam) - 1)]->id;
        //$this->play->get();
        return $bowler;
    }
}
