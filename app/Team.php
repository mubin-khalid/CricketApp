<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    public function players()
    {
        return $this->hasMany('App\Player');
    }

    public function match()
    {
        return $this->hasMany('App\Matches', 'batting_team_id');
    }

    public function getNotPlayingTeams()
    {
        return $this->hasMany('App\Matches', 'batting_team_id')->wherePivot('result', null);
    }

}
