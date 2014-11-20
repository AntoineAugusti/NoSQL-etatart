<?php namespace Insa\Recipes\Repositories;

use Insa\Recipes\Models\Recipe;

class MongoRecipesRepository implements RecipesRepository {

	/**
	 * Get all recipes
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function getAll()
	{
		return Recipe::all();
	}

	/**
	 * Retrieve a recipe by its slug
	 * @param  string $slug
	 * @return \Insa\Recipes\Models\Recipe
	 */
	public function getBySlug($slug)
	{
		return Recipe::whereSlug($slug)->first();
	}
}