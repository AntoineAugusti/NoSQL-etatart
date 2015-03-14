<?php namespace Insa\Ingredients\Models;

use InvalidArgumentException, Moloquent;
use Laracasts\Presenter\PresentableTrait;
use Insa\Quantities\Models\Quantity;

class Ingredient extends Moloquent {

	use PresentableTrait;

	/**
	 * Tell if an ingredient should have timestamp attributes
	 * @var boolean
	 */
	public $timestamps = false;

	/**
	 * Fillable attributes for an ingredient
	 * @var array
	 */
	public $fillable = ['name', 'unit', 'price'];

	/**
	 * The class to use when presenting an Ingredient
	 * @var string
	 */
	protected $presenter = 'Insa\Ingredients\Presenters\IngredientPresenter';

	const GRAMMES_LITER = '100g-liter';
	const KILO = 'kilo';
	const UNIT = 'unit';

	/**
	 * Get the quantity of an ingredient
	 * @return \Illuminate\Database\Eloquent\Model
	 */
	public function quantity()
	{
		return $this->embedsOne(Quantity::class);
	}

	/**
	 * Set the unit attribute
	 * @param string $value
	 * @throws InvalidArgumentException If the given value is not allowed
	 */
	public function setUnitAttribute($value)
	{
		$allowedValues = self::getAllowedUnitValues();
		if ( ! in_array($value, $allowedValues))
			throw new InvalidArgumentException($value." is not a valid unit. Possible values are: ".implode('|', $allowedValues));

		$this->attributes['unit'] = $value;
	}

	/**
	 * Create a new ingredient
	 * @param  string $name
	 * @param  string $unit
	 * @param  string $price
	 * @return Ingredient
	 */
	public static function build($name, $unit, $price = null)
	{
		return new static(compact('name', 'unit', 'price'));
	}

	/**
	 * Get allowed values for the unit attribute
	 * @return array
	 */
	public static function getAllowedUnitValues()
	{
		return [self::UNIT, self::KILO, self::GRAMMES_LITER];
	}
}