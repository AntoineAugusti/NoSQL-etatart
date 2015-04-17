<?php namespace Insa\Guests\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Insa\Events\Models\Event;
use Insa\Guests\Models\Guest;

class MongoGuestsRepository implements GuestsRepository {

	/**
	 * Get all guests
	 * @return Collection
	 */
	public function getAll()
	{
		return Guest::all();
	}

	/**
	 * Retrieve a guest by its id
	 * @param  string $id
	 * @return Guest
	 */
	public function getById($id)
	{
		return Guest::find($id);
	}

    /**
     * Save a guest
     * @param  Guest $guest
     * @return bool
     */
    public function save(Guest $guest)
    {
        return $guest->save();
    }

    /**
     * Invite a guest in an event
     * @param  Guest $guest
     * @param  Event $event
     * @return void
     */
    public function inviteIn(Guest $guest, Event $event)
    {
        $event->guests()->attach($guest->id);

        $invite = $guest->invite;
        $invite->toInvite = false;
        $invite->lastInvite = $event->date;
        $invite->numberOfInvitations++;

        $guest->invite()->save($invite);

        dd($event->guests->toJson());
    }
}