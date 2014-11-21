<?php

use Faker\Factory as Faker;
use Insa\Ingredients\Models\Ingredient;
use Insa\Quantities\Models\Quantity;
use Insa\Recipes\Models\Recipe;

class RecipeTableSeeder extends Seeder {

	public function run()
	{
		$this->command->info('Deleting existing Recipes table ...');
		Recipe::truncate();

		$faker = Faker::create();

		$this->command->info('Seeding Recipes table using Faker...');
		
		foreach(range(1, 20) as $index)
		{
			$title = ucwords($faker->sentence(3));
			
			$r = new Recipe([
				'title'           => $title,
				'slug'            => Str::slug($title),
				'rating'          => $faker->numberBetween(1, 10),
				'type'            => $faker->randomElement(Recipe::getAllowedTypeValues()),
				'cookingTime'     => $faker->numberBetween(20, 200),
				'preparationTime' => $faker->numberBetween(20, 200),
				'description'     => $faker->text(300)
			]);	

			// Create ingredients and quantities
			foreach (range(1, $faker->numberBetween(3, 10)) as $dummy)
			{
				$ing = new Ingredient(['name' => $faker->sentence(2)]);
				$q = new Quantity(['type' => $faker->randomElement([Quantity::UNIT, Quantity::GRAMMES_LITER, Quantity::KILO]), 'value' => $faker->randomFloat(2, 1, 15)]);

				$ing->quantity()->associate($q);
				$r->ingredients()->associate($ing);
			}

			$r->save();
		}
	}
}