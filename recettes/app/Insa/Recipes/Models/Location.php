<?php namespace Insa\Recipes\Models;

use Moloquent;
use Laracasts\Presenter\PresentableTrait;

class Location extends Moloquent {

	use PresentableTrait;

	const MANUSCRIPT = 'manuscript';
	const BOOK       = 'book';
	const URL        = 'url';
	const MAGAZINE   = 'magazine';

	protected $presenter = 'Insa\Recipes\Presenters\LocationPresenter';
	protected $fillable = ['date', 'name', 'description', 'type'];
	protected $dates = ['date'];

	public function recipes()
	{
		return $this->hasMany(\Insa\Recipes\Models\Recipe::class);
	}

	public function setDateAttribute($value)
	{
		if (! in_array($this->type, self::getTypesWithDate()))
			throw new \InvalidArgumentException("Can only set the date for the following types: ".implode(',', self::getTypesWithDate()));

		$this->attributes['date'] = $this->fromDateTime($value);
	}

	public function setTypeAttribute($value)
	{
		$allowedValues = self::getAllowedTypeValues();
		if ( ! in_array($value, $allowedValues))
			throw new \InvalidArgumentException($value." is not a valid type. Possible values are: ".implode('|', $allowedValues));
			
		$this->attributes['type'] = $value;
	}

	public function hasDate()
	{
		return in_array($this->type, self::getTypesWithDate());
	}

	public static function getAllowedTypeValues()
	{
		return [self::MANUSCRIPT, self::BOOK, self::URL, self::MAGAZINE];
	}

	/**
	 * Get values for the type attribute that require a date attribute
	 * @return array
	 */
	public static function getTypesWithDate()
	{
		return [self::MAGAZINE, self::URL];
	}
}