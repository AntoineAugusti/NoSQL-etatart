<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Insa\Events\Models\Event;

class EventTableSeeder extends Seeder
{
    public function run()
    {
        $this->command->info('Deleting existing Events table ...');
        Event::truncate();

        $faker = Faker::create();

        $this->command->info('Seeding Events table using Faker...');

        foreach (range(1, 20) as $index) {
            $event = new Event([
                'name' => $faker->sentence,
                'date' => $faker->date,
                'type' => $faker->randomElement(Event::getAllowedTypeValues()),
            ]);

            $event->save();
        }
    }
}
