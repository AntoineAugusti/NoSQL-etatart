<?php namespace Insa\Recipes\Repositories;

use Illuminate\Support\Str;
use Insa\Ingredients\Models\Ingredient;
use Insa\Quantities\Models\Quantity;
use Insa\Recipes\Models\Location;
use Insa\Recipes\Models\Recipe;

class MongoRecipesRepository implements RecipesRepository {

	/**
	 * @var \Illuminate\Support\Str
	 */
	private $str;

	public function __construct(Str $str)
	{
		$this->str = $str;
	}

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
		return Recipe::with('location')
			->whereSlug($slug)
			->first();
	}

	/**
	 * Set the location of a recipe
	 * @param  \Insa\Recipes\Models\Recipe   $r
	 * @param  \Insa\Recipes\Models\Location $l
	 * @return \Insa\Recipes\Models\Recipe
	 */
	public function addLocation(Recipe $r, Location $l)
	{
		$r->location()->associate($l);
		$r->save();

		return $r;
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

		return Recipe::with('location')->latest()
			->take($pagesize)
			->skip($skip)
			->get();
	}

	private function computeSkip($page, $pagesize)
	{
		return $pagesize * ($page - 1);
	}
}