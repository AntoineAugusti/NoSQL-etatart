<?php namespace Insa\Quantities\Models;

use Moloquent;
use Laracasts\Presenter\PresentableTrait;

class Quantity extends Moloquent {

	use PresentableTrait;

	public $timestamps = false;
	public $fillable = ['unit', 'price', 'quantity'];
	protected $presenter = 'Insa\Quantities\Presenters\QuantityPresenter';

	const GRAMMES_LITER = '100g-liter';
	const KILO = 'kilo';
	const UNIT = 'unit';

	public function ingredient()
	{
		return $this->belongsTo('Insa\Ingredients\Models\Ingredient');
	}

	public function setUnitAttribute($value)
	{
		$allowedValues = $this->getAllowedUnitValues();
		if ( ! in_array($value, $allowedValues))
			throw new \InvalidArgumentException($value." is not a valid unit. Possible values are: ".implode('|', $allowedValues));
			
		$this->attributes['unit'] = $value;
	}

	/**
	 * Return the price of the ingredient given the amount and the price / unit
	 * @return float
	 */
	public function computePrice()
	{
		return round($this->price * $this->quantity, 2);
	}

	public static function getAllowedUnitValues()
	{
		return [self::UNIT, self::KILO, self::GRAMMES_LITER];
	}
}