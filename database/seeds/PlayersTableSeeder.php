<?php

use Illuminate\Database\Seeder;

class PlayersTableSeeder extends Seeder
{
    public function run()
    {
        $totalPlayers = 15;
        $teams = DB::table('teams')->pluck('id');
        foreach($teams as $teamId) {
            foreach (range(0, $totalPlayers) as $item) {
                factory('App\Player', 1)->create([
                    'team_id' => $teamId
                ]);
            }
        }

    }
}
