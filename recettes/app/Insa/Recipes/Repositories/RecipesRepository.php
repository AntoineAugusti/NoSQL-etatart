<?php namespace Insa\Recipes\Repositories;

use Insa\Ingredients\Models\Ingredient;
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
	 * @param  string $type            [description]
	 * @param  string $preparationTime
	 * @param  string $cookingTime
	 * @param  string $description
	 * @return \Insa\Recipes\Models\Recipe
	 */
	public function create($title, $rating, $type, $preparationTime, $cookingTime, $description);

	/**
	 * Get an array of the name of all ingredients used in recipes
	 * @return array
	 */
	public function getAllIngredients();
}