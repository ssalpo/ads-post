<?php

use Illuminate\Database\Seeder;

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

        factory(\App\Advertising::class, 50)->create()->each(function ($advertising, $faker) {
            $advertising->images()->createMany([
                ['url' => 'https://via.placeholder.com/150'],
                ['url' => 'https://via.placeholder.com/300'],
                ['url' => 'https://via.placeholder.com/500'],
            ]);
        });
    }
}
