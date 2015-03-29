<?php namespace Insa\Events\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Insa\Events\Models\Event;

interface EventsRepository {

	/**
	 * Get all events
	 * @return Collection
	 */
	public function getAll();

	/**
	 * Retrieve a event by its id
	 * @param  string $id
	 * @return Event
	 */
	public function getById($id);

	/**
	 * Save a event
	 * @param  Event $event
	 * @return bool
	 */
	public function save(Event $event);
}