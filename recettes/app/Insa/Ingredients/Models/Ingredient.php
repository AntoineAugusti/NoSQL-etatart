<?php namespace Insa\Ingredients\Models;

use Moloquent;
use Laracasts\Presenter\PresentableTrait;

class Ingredient extends Moloquent {

	use PresentableTrait;

	public $timestamps = false;
	public $fillable = ['name', 'unit', 'price'];
	protected $presenter = 'Insa\Ingredients\Presenters\IngredientPresenter';

	const GRAMMES_LITER = '100g-liter';
	const KILO = 'kilo';
	const UNIT = 'unit';

	public function quantity()
	{
		return $this->embedsOne(\Insa\Quantities\Models\Quantity::class);
	}

	public function setUnitAttribute($value)
	{
		$allowedValues = self::getAllowedUnitValues();
		if ( ! in_array($value, $allowedValues))
			throw new \InvalidArgumentException($value." is not a valid unit. Possible values are: ".implode('|', $allowedValues));
			
		$this->attributes['unit'] = $value;
	}

	public static function build($name, $unit, $price = null)
	{
		return new static(compact('name', 'unit', 'price'));
	}

	public static function getAllowedUnitValues()
	{
		return [self::UNIT, self::KILO, self::GRAMMES_LITER];
	}
}