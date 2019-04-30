<?php


namespace App\MatchCenter;

use App\Team;
use App\Matches as MatchesModel;

class Matches
{
    public function getTeams()
    {
        $playing = MatchesModel::where('result', 'underway')->get(['id', 'batting_team_id', 'bowling_team_id']);
        $playingTeams = [];
        foreach ($playing as $team) {
            $playingTeams[] = $team->batting_team_id;
            $playingTeams[] = $team->bowling_team_id;
        }
        if (count($playingTeams)) {
            $query = Team::whereNotIn('id', $playingTeams);
        } else {
            $query = Team::query();
        }
        $teams = $query->get('id');
        if (count($teams)) {
            $teamAIndex = rand(0, count($teams) - 1);
            $teamA = $teams[$teamAIndex]->id;
            $teamBIndex = $teamAIndex;
            while ($teamBIndex == $teamAIndex) {
                $teamBIndex = rand(0, count($teams) - 1);
            }
            $teamB = $teams[$teamBIndex]->id;
            return [$teamA, $teamB];
        }
        return null;
    }

    public function updateMatch($teams)
    {
        $match = MatchesModel::create([
            'batting_team_id' => $teams[0],
            'bowling_team_id' => $teams[1],
            'type' => '20',
            'result' => 'underway',
        ]);
        return $match;
    }

    public function getBattingTeam($teamId)
    {
        return Team::find($teamId)->players;
    }

    public function getBowlingTeam($teamId)
    {
        return Team::find($teamId)->players;
    }
}
