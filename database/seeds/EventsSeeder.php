<?php

use App\Event;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class EventsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Let's truncate our existing records to start from scratch.
        Event::truncate();

        $faker = \Faker\Factory::create();

        // And now, let's create a few articles in our database:
        for ($i = 0; $i < 5; $i++) {
            Event::create([
                'name' => $faker->sentence,
                'description' => $faker->paragraph,
                'description_in_form' => $faker->paragraph,
                'quota' => $faker->numberBetween(10,100),
                'start_time' => Carbon::parse('2000-01-01'),
                'end_time' => Carbon::parse('2000-01-01')
            ]);
        }
    }
}
