<?php

use Insa\Recipes\Models\Recipe;
use Insa\Ingredients\Models\Ingredient;
use Insa\Quantities\Models\Quantity;

Route::get('/', function()
{
	Recipe::truncate();
	Ingredient::truncate();
	Quantity::truncate();

	$r = new Recipe(['title' => 'Test', 'note' => 8, 'type' => Recipe::MAIN, 'cookingTime' => 80]);	
	$ing = new Ingredient(['name' => "Carottes"]);
	$q = new Quantity(['type' => 'unite', 'value' => 10]);

	$ing->quantity()->associate($q);
	$r->ingredients()->associate($ing);
	$r->save();

	$r = Recipe::with('ingredients.quantity')->first();

	return $r;
	foreach ($r->ingredients as $i) {
		var_dump($i->quantity->type);
	}
});