<?php namespace Insa\Recipes\Repositories;

use InvalidArgumentException;
use Illuminate\Cache\Repository as Cache;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Insa\Ingredients\Models\Ingredient;
use Insa\Quantities\Models\Quantity;
use Insa\Recipes\Models\Location;
use Insa\Recipes\Models\Recipe;

class MongoRecipesRepository implements RecipesRepository {

	/**
	 * @var \Illuminate\Cache\Repository
	 */
	private $cache;

	/**
	 * @var \Illuminate\Support\Str
	 */
	private $str;

	public function __construct(Cache $cache, Str $str)
	{
		$this->cache = $cache;
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
	 * @param \Insa\Recipes\Models\Recipe   $r
	 * @param \Insa\Recipes\Models\Location $l
	 * @return \Insa\Recipes\Models\Recipe
	 */
	public function addLocation(Recipe $r, Location $l)
	{
		$r->location()->associate($l);
		$r->save();

		return $r;
	}

	/**
	 * Add an ingredient to a recipe
	 * @param \Insa\Recipes\Models\Recipe $r
	 * @param \Insa\Ingredients\Models\Ingredient $i
	 */
	public function addIngredient(Recipe $r, Ingredient $i)
	{
		$r->ingredients()->associate($i);
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

		return Recipe::with('location')
			->latest()
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

	/**
	 * Store a new recipe
	 * @param  string $title The name of the recipe
	 * @param  int $rating
	 * @param  string $type            [description]
	 * @param  string $preparationTime
	 * @param  string $cookingTime
	 * @param  string $description
	 * @return \Insa\Recipes\Models\Recipe
	 */
	public function create($title, $rating, $type, $preparationTime, $cookingTime, $description)
	{
		$r = new Recipe(compact('title', 'rating', 'type', 'preparationTime', 'cookingTime', 'description'));
		$r->slug = $this->computeSlug($title);

		$r->save();

		return $r;
	}

	/**
	 * Create a recipe with its ingredients and quantities
	 * @param  array  $recipeData  Data for the creation of the recipe
	 * @param  array  $ingredients List of ingredients, as strings
	 * @param  array  $quantities  Data for quantitites, associated with ingredients
	 * @see \Insa\Recipes\Repositories\RecipesRepository@create
	 * @return \Insa\Recipes\Models\Recipe
	 */
	public function createWithIngredientsAndQuantities(array $recipeData, array $ingredients, array $quantities)
	{
		// Store the new recipe
		extract($recipeData);
		$recipe = $this->create($title, $rating, $type, $preparationTime, $cookingTime, $description);

		// Foreach ingredient, associate its quantity
		foreach ($ingredients as $ingredient)
		{
			$ing = $this->createIngredientWithQuantity($ingredient, $quantities);

			// Add the ingredient to the recipe
			$recipe = $this->addIngredient($recipe, $ing);
		}

		// If a new ingredient was found, delete the cache
		if ($this->listOfIngredientsNeedsUpdate($ingredients))
			$this->cache->forget('recipes.allIngredients');

		return $recipe;
	}

	/**
	 * Get a collection representing all ingredients used in recipes, without duplicates
	 * @return \Illuminate\Support\Collection
	 */
	public function getAllIngredients()
	{
		$instance = $this;

		return $this->cache->remember('recipes.allIngredients', 10, function() use ($instance)
		{
			$finalIngredients = [];
			$ingredientsName = [];
			$prices = [];

			foreach ($instance->allIngredients() as $ingredient)
			{
				// Add the ingredient to the final collection
				if (! in_array($ingredient, $ingredientsName))
				{
					$ingredientsName[] = $ingredient->name;
					$finalIngredients[] = Ingredient::build($ingredient->name, $ingredient->unit);
				}

				// Remember the price for this ingredient
				$prices[$ingredient->name][] = $ingredient->price;
			}

			// Set the mean price for each ingredient
			foreach ($finalIngredients as $ing)
				$ing->price = round(array_sum($prices[$ing->name]) / count($prices[$ing->name]), 2);

			return new Collection($finalIngredients);
		});
	}

	/**
	 * Get all ingredients from all recipes in a single array with duplicates
	 * @return array
	 */
	private function allIngredients()
	{
		// We have an array of collections
		$ingredientsArray = $this->getAll()->lists('ingredients');
		// Merge the collections in a single array
		$out = [];
		foreach ($ingredientsArray as $ing)
		{
			$out = array_merge($out, $ing->all());
		}

		return $out;
	}

	/**
	 * Get recipes for a rating description
	 * @param  string $rank
	 * @return \Illuminate\Support\Collection
	 */
	public function getForRank($rank)
	{
		return Recipe::with('location')
			->whereBetween('rating', $this->getBoundsForRank($rank))
			->get();
	}

	/**
	 * Get the number of recipes for a rating description
	 * @param  string $rank
	 * @return integer
	 */
	public function getTotalForRank($rank)
	{
		return Recipe::whereBetween('rating', $this->getBoundsForRank($rank))
			->count();
	}

	/**
	 * Get the rating bounds for a rank
	 * @param  string $rank
	 * @return array An array of 2 integers. Both bounds are inclusive
	 */
	private function getBoundsForRank($rank)
	{
		switch ($rank)
		{
			case 'fine':
				return [0, 4];

			case 'great':
				return [5, 7];

			case 'awesome':
				return [8, 10];
		}

		throw new InvalidArgumentException("Can't find bounds for rank ".$rank);
	}

	/**
	 * Determine if the list of all ingredients needs a refresh because we have a new ingredient
	 * @param  array  $ingredients The list of ingredients
	 * @return boolean
	 */
	private function listOfIngredientsNeedsUpdate(array $ingredients)
	{
		$existingIngredients = $this->getAllIngredients()->lists('name');

		foreach ($ingredients as $ingredient)
		{
			if ( ! in_array($ingredient, $existingIngredients))
				return true;
		}

		return false;
	}

	/**
	 * Create an ingredient with its quantity
	 * @param  string $ingredient The name of the ingredient
	 * @param  array  $quantities Data for quantity associated with the ingredient
	 * @return \Insa\Ingredients\Models\Ingredient
	 */
	private function createIngredientWithQuantity($ingredient, array $quantities)
	{
		$slug = $this->computeSlug($ingredient);

		$ing = Ingredient::build($ingredient, $quantities['unit-'.$slug], $quantities['price-'.$slug]);

		$q = new Quantity([
			'quantity' => $quantities['quantity-'.$slug],
		]);

		$ing->quantity()->associate($q);

		return $ing;
	}

	/**
	 * Get the slug for a string
	 * @param  string $value
	 * @return string
	 */
	private function computeSlug($value)
	{
		return $this->str->slug($value);
	}

	/**
	 * Compute the number of elements to skip
	 * @param  int $page
	 * @param  int $pagesize
	 * @return int
	 */
	private function computeSkip($page, $pagesize)
	{
		return $pagesize * ($page - 1);
	}
}