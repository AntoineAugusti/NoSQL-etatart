<?php namespace Insa\Recipes\Models;

use InvalidArgumentException, Moloquent;
use Insa\Recipes\Models\Recipe;
use Laracasts\Presenter\PresentableTrait;

class Location extends Moloquent {

	use PresentableTrait;

	const MANUSCRIPT = 'handwritten';
	const BOOK       = 'book';
	const URL        = 'url';
	const MAGAZINE   = 'magazine';

	/**
	 * The class to use when presenting a Location object
	 * @var string
	 */
	protected $presenter = 'Insa\Recipes\Presenters\LocationPresenter';

	/**
	 * Fillable attributes for a location
	 * @var array
	 */
	protected $fillable = ['date', 'name', 'description', 'type'];

	/**
	 * Attributes that should be treated as dates
	 * @var array
	 */
	protected $dates = ['date'];

	/**
	 * Get recipes located in this location
	 * @return \Illuminate\Database\Eloquent\Model
	 */
	public function recipes()
	{
		return $this->hasMany(Recipe::class);
	}

	/**
	 * Set the date attribute
	 * @param string $value
	 * @throws \InvalidArgumentException If we can't set a date for this location
	 */
	public function setDateAttribute($value)
	{
		if (! in_array($this->type, self::getTypesWithDate()))
			throw new InvalidArgumentException("Can only set the date for the following types: ".implode(',', self::getTypesWithDate()));

		$this->attributes['date'] = $this->fromDateTime($value);
	}

	/**
	 * Set the type attribute
	 * @param string $value
	 * @throws \InvalidArgumentException If the type is not supported
	 */
	public function setTypeAttribute($value)
	{
		$allowedValues = self::getAllowedTypeValues();
		if ( ! in_array($value, $allowedValues))
			throw new InvalidArgumentException($value." is not a valid type. Possible values are: ".implode('|', $allowedValues));

		$this->attributes['type'] = $value;
	}

	/**
	 * Tell if a location has a date attribute
	 * @return boolean
	 */
	public function hasDate()
	{
		return in_array($this->type, self::getTypesWithDate());
	}

	/**
	 * Get allowed type values
	 * @return array
	 */
	public static function getAllowedTypeValues()
	{
		return [self::MANUSCRIPT, self::BOOK, self::URL, self::MAGAZINE];
	}

	/**
	 * Get location types having a date attribute
	 * @return array
	 */
	public static function getTypesWithDate()
	{
		return [self::MAGAZINE, self::URL];
	}
}