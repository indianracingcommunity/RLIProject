<?php

use Illuminate\Database\Seeder;
use App\Season;

class SeasonTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Season::class, 4)->create();
    }
}