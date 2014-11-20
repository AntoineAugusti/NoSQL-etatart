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
}