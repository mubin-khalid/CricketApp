<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Matches extends Model
{
    protected $fillable = ['batting_team_id', 'bowling_team_id', 'result', 'type'];

    public function team()
    {
        return $this->belongsTo('App\Team');
    }
}
