<?php

use App\Event;
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

        // Let's truncate our existing records to start from scratch.
        Event::truncate();

        $faker = \Faker\Factory::create();

        // And now, let's create a few articles in our database:
        for ($i = 0; $i < 5; $i++) {
            Event::create([
                'name' => $faker->sentence,
                'description' => $faker->paragraph,
                'description_in_form' => $faker->paragraph,
                'quota' => $faker->numberBetween(10,100)
            ]);
        }
    }
}
