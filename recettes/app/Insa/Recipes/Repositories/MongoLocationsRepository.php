<?php

namespace Insa\Recipes\Repositories;

use Insa\Recipes\Models\Location;

class MongoLocationsRepository implements LocationsRepository
{
    /**
     * Get all locations.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        return Location::all();
    }

    /**
     * Get a location by its ID.
     *
     * @param string $id
     *
     * @return Insa\Recipes\Models\Location
     */
    public function findById($id)
    {
        return Location::find($id);
    }
}
