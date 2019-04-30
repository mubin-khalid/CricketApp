<?php

use Illuminate\Database\Seeder;
use \Illuminate\Database\Eloquent\Model;
class DatabaseSeeder extends Seeder
{
    protected $toTruncate = ['teams', 'players'];
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        foreach ($this->toTruncate as $table) {
            DB::table($table)->truncate();
        }
        // $this->call(UsersTableSeeder::class);
        $this->call(TeamsTableSeeder::class);
        $this->call(PlayersTableSeeder::class);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
