<?php

use Faker\Factory as Faker;
use Insa\Recipes\Models\Location;

class LocationTableSeeder extends Seeder {

	public function run()
	{
		$this->command->info('Deleting existing Location table ...');
		Location::truncate();

		$faker = Faker::create();

		$this->command->info('Seeding Location table using Faker...');
		
		foreach(range(1, 10) as $index)
		{
			$location = new Location([
				'name'        => $faker->sentence(2),
				'description' => $faker->text(300),
				'type'        => $faker->randomElement(Location::getAllowedTypeValues()),
			]);
			
			$location->save();
		}
	}
}