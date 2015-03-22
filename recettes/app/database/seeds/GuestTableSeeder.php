<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Insa\Guests\Models\Guest;

class GuestTableSeeder extends Seeder {

    public function run()
    {
        $this->command->info('Deleting existing Guests table ...');
        Guest::truncate();

        $faker = Faker::create();

        $this->command->info('Seeding Guests table using Faker...');

        foreach(range(1, 20) as $index)
        {
            $guest = new Guest([
                'name'        => $faker->name,
                'phoneNumber' => $faker->phoneNumber,
                'type'        => $faker->randomElement(Guest::getAllowedTypeValues()),
            ]);

            $guest->save();
        }
    }
}