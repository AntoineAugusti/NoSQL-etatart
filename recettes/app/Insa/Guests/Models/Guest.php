<?php

namespace Insa\Guests\Models;

use Insa\Events\Models\Event;
use InvalidArgumentException;
use Laracasts\Presenter\PresentableTrait;
use Jenssegers\Mongodb\Model;

class Guest extends Model
{
    use PresentableTrait;

    const FRIEND = 'friend';
    const FAMILY = 'family';
    const COLLEAGUE = 'colleague';

    /**
     * The class to use when presenting an object.
     *
     * @var string
     */
    protected $presenter = 'Insa\Guests\Presenters\GuestPresenter';

    /**
     * Fillable properties for a guest.
     *
     * @var array
     */
    public $fillable = ['name', 'type', 'phoneNumber'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\EmbedsMany
     */
    public function invite()
    {
        return $this->embedsOne(Invite::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function events()
    {
        return $this->belongsToMany(Event::class);
    }

    /**
     * Set the type attribute.
     *
     * @param string $value
     *
     * @throws \InvalidArgumentException If the type is not allowed
     */
    public function setTypeAttribute($value)
    {
        $allowedValues = self::getAllowedTypeValues();

        if (!in_array($value, $allowedValues)) {
            throw new InvalidArgumentException('Type not supported. Got '.$value.'. Allowed values are:'.implode('|', $allowedValues));
        }

        $this->attributes['type'] = $value;
    }

    /**
     * Get allowed values for the type attribute.
     *
     * @return array
     */
    public static function getAllowedTypeValues()
    {
        return [self::FRIEND, self::FAMILY, self::COLLEAGUE];
    }

    public function hasBeenInvited()
    {
        return !$this->getInvite()->toInvite;
    }

    public function getInvite()
    {
        $invite = $this->invite;
        if (is_null($invite)) {
            $invite = new Invite();
            $invite->toInvite = true;
            $invite->numberOfInvitations = 0;

            $this->invite()->save($invite);
            $this->save();
        }

        return $this->invite;
    }
}
