<?php namespace Insa\Recipes\Repositories;

interface RecipesRepository {

	/**
	 * Get all recipes
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function getAll();
}