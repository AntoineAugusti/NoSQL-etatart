<?php namespace Insa\Recipes\Repositories;

use Cache, Str;
use Insa\Ingredients\Models\Ingredient;
use Insa\Quantities\Models\Quantity;
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
		return Recipe::with('location')
			->whereSlug($slug)
			->first();
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

		return Recipe::with('location')->latest()
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
		foreach ($ingredients as $ingredient) {

			$ing = $this->createIngredientWithQuantity($ingredient, $quantities);

			// Add the ingredient to the recipe
			$recipe = $this->addIngredient($recipe, $ing);
		}

		// If a new ingredient was found, delete the cache
		if ($this->listOfIngredientsNeedsUpdate($ingredients))
			Cache::forget('recipes.allIngredients');

		return $recipe;
	}

	/**
	 * Get an array of the name of all ingredients used in recipes
	 * @return array
	 */
	public function getAllIngredients()
	{
		$instance = $this;

		return Cache::remember('recipes.allIngredients', 10, function() use ($instance)
		{
			$ingredientsArray = $instance->getAll()->lists('ingredients');
			$ingredientsCollections = new \Illuminate\Support\Collection($ingredientsArray);

			$ingredients = [];
			foreach ($ingredientsCollections as $ingredientsCollection)
				$ingredients = array_merge($ingredients, $ingredientsCollection->lists('name'));

			// Remove duplicates
			$ingredients = array_unique($ingredients);
			// Sort alphabetically
			sort($ingredients);

			return $ingredients;
		});
	}

	/**
	 * Determine if the list of all ingredients needs a refresh because we have a new ingredient
	 * @param  array  $ingredients The list of ingredients
	 * @return boolean
	 */
	private function listOfIngredientsNeedsUpdate(array $ingredients)
	{
		$existingIngredients = $this->getAllIngredients();
		
		foreach ($ingredients as $ingredient) {
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
		
		$ing = new Ingredient(['name' => $ingredient]);
		$q = new Quantity([
			'unit'     => $quantities['unit-'.$slug],
			'price'    => $quantities['price-'.$slug],
			'quantity' => $quantities['quantity-'.$slug],
		]);
		
		$ing->quantity()->associate($q);

		return $ing;
	}

	private function computeSlug($value)
	{
		return Str::slug($value);
	}

	private function computeSkip($page, $pagesize)
	{
		return $pagesize * ($page - 1);	
	}
}