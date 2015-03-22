<?php namespace Insa\Guests\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Insa\Guests\Models\Guest;

interface GuestsRepository {

	/**
	 * Get all guests
	 * @return Collection
	 */
	public function getAll();

	/**
	 * Retrieve a guest by its id
	 * @param  string $id
	 * @return Guest
	 */
	public function getById($id);

	/**
	 * Save a guest
	 * @param  Guest $guest
	 * @return bool
	 */
	public function save(Guest $guest);
}