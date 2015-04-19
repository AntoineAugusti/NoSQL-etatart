<?php namespace Insa\Events\Models;

use Insa\Guests\Models\Guest;
use Insa\Recipes\Models\Recipe;
use InvalidArgumentException;
use Laracasts\Presenter\PresentableTrait;
use Jenssegers\Mongodb\Model;

class Event extends Model {

	use PresentableTrait;

	const BIRTHDAY  = "birthday";
	const PARTY     = "party";
	const CHRISTMAS = "christmas";
	const NEW_YEAR  = "new-year";

	/**
	 * The class to use when presenting an object
	 * @var string
	 */
	protected $presenter = 'Insa\Events\Presenters\EventPresenter';

	/**
	 * Fillable properties for a event
	 * @var array
	 */
	public $fillable = ['name', 'type', 'date'];

	public $dates = ['date'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function guests()
    {
        return $this->belongsToMany(Guest::class);
    }

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function recipes()
	{
		return $this->belongsToMany(Recipe::class);
	}

	/**
	 * Set the type attribute
	 * @param string $value
	 * @throws \InvalidArgumentException If the type is not allowed
	 */
	public function setTypeAttribute($value)
	{
		$allowedValues = self::getAllowedTypeValues();

		if (! in_array($value, $allowedValues))
			throw new InvalidArgumentException("Type not supported. Got ".$value.". Allowed values are:".implode('|', $allowedValues));

		$this->attributes['type'] = $value;
	}

	/**
	 * Get allowed values for the type attribute
	 * @return array
	 */
	public static function getAllowedTypeValues()
	{
		return [self::BIRTHDAY, self::CHRISTMAS, self::NEW_YEAR, self::PARTY];
	}

	public function hasGuests()
	{
		return !$this->guests->isEmpty();
	}
}