<?php

use Faker\Factory as Faker;
use Insa\Ingredients\Models\Ingredient;
use Insa\Quantities\Models\Quantity;
use Insa\Recipes\Models\Location;
use Insa\Recipes\Models\Recipe;

class RecipeTableSeeder extends Seeder
{
    private $unitsForIngredients = [];

    public function run()
    {
        $this->command->info('Deleting existing Recipes table ...');
        Recipe::truncate();

        $faker = Faker::create();

        $this->command->info('Seeding Recipes table using Faker...');

        // Convert the collection to an array of models
        $allLocations = Location::all()->all();

        foreach (range(1, 20) as $index) {
            $title = ucwords($faker->sentence(3));

            $r = new Recipe([
                'title' => $title,
                'slug' => Str::slug($title),
                'rating' => $faker->numberBetween(1, 10),
                'type' => $faker->randomElement(Recipe::getAllowedTypeValues()),
                'cookingTime' => $faker->numberBetween(20, 200),
                'preparationTime' => $faker->numberBetween(20, 200),
                'description' => $faker->text(300),
            ]);

            // Create ingredients and quantities
            foreach (range(1, $faker->numberBetween(3, 10)) as $dummy) {
                $name = $faker->sentence(2);

                $ing = new Ingredient([
                    'name' => $name,
                    'unit' => $this->getUnitForIngredient($name),
                    'price' => $faker->randomFloat(2, 1, 15),
                ]);
                $q = new Quantity([
                    'quantity' => $faker->randomFloat(2, 0.1, 10),
                ]);

                $ing->quantity()->associate($q);
                $r->ingredients()->associate($ing);
            }

            // Associate a location for this recipe
            $r->location()->associate($faker->randomElement($allLocations));

            $r->save();
        }
    }

    private function getUnitForIngredient($name)
    {
        $faker = Faker::create();

        if (!array_key_exists($name, $this->unitsForIngredients)) {
            $unit = $faker->randomElement(Ingredient::getAllowedUnitValues());
            $this->unitsForIngredients[$name] = $unit;

            return $unit;
        }

        return $this->unitsForIngredients[$name];
    }
}
