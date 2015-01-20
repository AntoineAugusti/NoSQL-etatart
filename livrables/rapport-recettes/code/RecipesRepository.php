<?php namespace Insa\Recipes\Repositories;

use Insa\Ingredients\Models\Ingredient;
use Insa\Recipes\Models\Location;
use Insa\Recipes\Models\Recipe;

interface RecipesRepository {

	/**
	 * Get all recipes
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function getAll();

	/**
	 * Retrieve a recipe by its slug
	 * @param  string $slug
	 * @return \Insa\Recipes\Models\Recipe
	 */
	public function getBySlug($slug);

	/**
	 * Set the location of a recipe
	 * @param  \Insa\Recipes\Models\Recipe   $r
	 * @param  \Insa\Recipes\Models\Location $l
	 * @return \Insa\Recipes\Models\Recipe
	 */
	public function addLocation(Recipe $r, Location $l);

	/**
	 * Get last recipes
	 * @param  int $page The page number
	 * @param  int $pagesize The number of recipes per page
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function index($page, $pagesize);
}