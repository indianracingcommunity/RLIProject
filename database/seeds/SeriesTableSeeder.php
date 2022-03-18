<?php

// namespace Database\Seeder;

use Illuminate\Database\Seeder;
use App\Series;

class SeriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Series::class, 5)->create();
    }
}
