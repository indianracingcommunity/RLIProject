<?php

// namespace Database\Seeder;

use Illuminate\Database\Seeder;

// phpcs:ignore
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        // $this->call(SeriesTableSeeder::class);
        $this->call(TierSeeder::class);
    }
}
