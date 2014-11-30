<?php namespace Insa\Recipes\Repositories;

interface LocationsRepository {

	/**
	 * Get all locations
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function getAll();
}