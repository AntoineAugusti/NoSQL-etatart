<?php namespace Insa\Recipes\Repositories;

use Insa\Recipes\Models\Location;

class MongoLocationsRepository implements LocationsRepository {

	/**
	 * Get all locations
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function getAll()
	{
		return Location::all();
	}
}