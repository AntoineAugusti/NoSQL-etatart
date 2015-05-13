<?php

use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Insa\Guests\Models\Guest;
use Insa\Guests\Models\Invite;

class GuestTableSeeder extends Seeder
{
    public function run()
    {
        $this->command->info('Deleting existing Guests table ...');
        Guest::truncate();

        $faker = Faker::create();

        $this->command->info('Seeding Guests table using Faker...');

        foreach (range(1, 20) as $index) {
            $guest = new Guest([
                'name' => $faker->name,
                'phoneNumber' => $faker->phoneNumber,
                'type' => $faker->randomElement(Guest::getAllowedTypeValues()),
            ]);

            $invite = new Invite();

            $toInvite = $faker->boolean();
            $invite->toInvite = $toInvite;

            if ($toInvite) {
                $invite->numberOfInvitations = 0;
            } else {
                $invite->numberOfInvitations = 1;
                $invite->lastInvite = Carbon::createFromTimestamp($faker->dateTime->getTimestamp());
            }

            $guest->invite()->save($invite);
            $guest->save();
        }
    }
}
