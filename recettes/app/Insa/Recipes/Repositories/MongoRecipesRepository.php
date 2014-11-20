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

	/**
	 * Get last recipes
	 * @param  int $page The page number
	 * @param  int $pagesize The number of recipes per page
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function index($page, $pagesize)
	{
		$skip = $this->computeSkip($page, $pagesize);

		return Recipe::latest()
			->take($pagesize)
			->skip($skip)
			->get();
	}

	/**
	 * Get the total number of recipes
	 * @return int
	 */
	public function getTotalRecipes()
	{
		return Recipe::count();
	}

	private function computeSkip($page, $pagesize)
	{
		return $pagesize * ($page - 1);	
	}
}