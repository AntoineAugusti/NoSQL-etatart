<?php namespace Insa\Recipes\Repositories;

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
}