<?php namespace Insa\Guests\Models;

use InvalidArgumentException;
use Laracasts\Presenter\PresentableTrait;
use Jenssegers\Mongodb\Model;

class Guest extends Model {

	use PresentableTrait;

	const FRIEND    = "friend";
	const FAMILY    = "family";
	const COLLEAGUE = "colleague";

	/**
	 * The class to use when presenting an object
	 * @var string
	 */
	protected $presenter = 'Insa\Guests\Presenters\GuestPresenter';

	/**
	 * Fillable properties for a guest
	 * @var array
	 */
	public $fillable = ['name', 'type', 'phone'];

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
		return [self::FRIEND, self::FAMILY, self::COLLEAGUE];
	}
}