<?php

use Faker\Factory as Faker;
use Insa\Recipes\Models\Location;

class LocationTableSeeder extends Seeder {

	public function run()
	{
		$this->command->info('Deleting existing Location table ...');
		Location::truncate();

		$this->command->info('Seeding Location table using Faker...');
		
		foreach(range(1, 10) as $index)
		{
			$location = $this->getNewLocation();
			$location->save();
		}
	}

	/**
	 * Create a new location with data generated by Faker
	 * @return \Insa\Recipes\Models\Location
	 */
	private function getNewLocation()
	{		
		$faker = Faker::create();

		$type = $faker->randomElement(Location::getAllowedTypeValues());
		
		$data = [
			'name'        => $faker->sentence(2),
			'description' => $faker->text(300),
			'type'        => $type,
		];

		// For a magazine or a website, associate a date
		if (in_array($type, [Location::MAGAZINE, Location::URL]))
			$data['date'] = $faker->dateTimeThisYear();

		return new Location($data);
	}
}