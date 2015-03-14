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
	 * @param \Insa\Recipes\Models\Recipe   $r
	 * @param \Insa\Recipes\Models\Location $l
	 * @return \Insa\Recipes\Models\Recipe
	 */
	public function addLocation(Recipe $r, Location $l);

	/**
	 * Add an ingredient to a recipe
	 * @param \Insa\Recipes\Models\Recipe $r
	 * @param \Insa\Ingredients\Models\Ingredient $i
	 */
	public function addIngredient(Recipe $r, Ingredient $i);

	/**
	 * Get last recipes
	 * @param  int $page The page number
	 * @param  int $pagesize The number of recipes per page
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function index($page, $pagesize);

	/**
	 * Get the total number of recipes
	 * @return int
	 */
	public function getTotalRecipes();

	/**
	 * Store a new recipe
	 * @param  string $title The name of the recipe
	 * @param  int $rating
	 * @param  string $type
	 * @param  string $preparationTime
	 * @param  string $cookingTime
	 * @param  string $description
	 * @return \Insa\Recipes\Models\Recipe
	 */
	public function create($title, $rating, $type, $preparationTime, $cookingTime, $description);

	/**
	 * Create a recipe with its ingredients and quantities
	 * @param  array  $recipeData  Data for the creation of the recipe
	 * @param  array  $ingredients List of ingredients, as strings
	 * @param  array  $quantities  Data for quantitites, associated with ingredients
	 * @see \Insa\Recipes\Repositories\RecipesRepository@create
	 * @return \Insa\Recipes\Models\Recipe
	 */
	public function createWithIngredientsAndQuantities(array $recipeData, array $ingredients, array $quantities);

	/**
	 * Get a collection representing all ingredients used in recipes, without duplicates
	 * @return @return \Illuminate\Support\Collection
	 */
	public function getAllIngredients();

	/**
	 * Get recipes for a rating description
	 * @param  string $rank
	 * @return \Illuminate\Support\Collection
	 */
	public function getForRank($rank);

	/**
	 * Get the number of recipes for a rating description
	 * @param  string $rank
	 * @return integer
	 */
	public function getTotalForRank($rank);
}