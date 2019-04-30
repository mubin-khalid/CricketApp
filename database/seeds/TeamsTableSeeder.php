<?php

use Illuminate\Database\Seeder;

class TeamsTableSeeder extends Seeder
{
    public function run()
    {
        factory('App\Team', 10)->create();
    }
}
