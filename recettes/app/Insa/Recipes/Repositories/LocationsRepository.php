<?php

namespace Insa\Recipes\Repositories;

interface LocationsRepository
{
    /**
     * Get all locations.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll();

    /**
     * Get a location by its ID.
     *
     * @param string $id
     *
     * @return Insa\Recipes\Models\Location
     */
    public function findById($id);
}
