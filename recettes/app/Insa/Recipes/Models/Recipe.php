<?php namespace Insa\Recipes\Models;

use InvalidArgumentException, Moloquent;
use Insa\Ingredients\Models\Ingredient;
use Insa\Recipes\Models\Location;
use Laracasts\Presenter\PresentableTrait;

class Recipe extends Moloquent {

	use PresentableTrait;

	const AMUSE_GUEULE = 'amuse-gueule';
	const DESSERT      = 'dessert';
	const MAIN         = 'main';
	const STARTER      = 'starter';

	/**
	 * The class to use when presenting a Recipe object
	 * @var string
	 */
	protected $presenter = 'Insa\Recipes\Presenters\RecipePresenter';

	/**
	 * Fillable attributes for a recipe
	 * @var array
	 */
	public $fillable = ['title', 'rating', 'cookingTime', 'preparationTime', 'type', 'slug', 'description'];

	/**
	 * Get ingredients for a recipe
	 * @return \Illuminate\Database\Eloquent\Model
	 */
	public function ingredients()
	{
		return $this->embedsMany(Ingredient::class);
	}

	/**
	 * Get the location of a recipe
	 * @return \Illuminate\Database\Eloquent\Model
	 */
	public function location()
	{
		return $this->belongsTo(Location::class);
	}

	/**
	 * Set the rating
	 * @param int $value
	 * @throws \InvalidArgumentException If the given rating is not between bounds
	 */
	public function setRatingAttribute($value)
	{
		if (! is_numeric($value) OR $value < 1 OR $value > 10)
			throw new InvalidArgumentException("The rating should be between 1 and 10");

		$this->attributes['rating'] = $value;
	}

	/**
	 * Compute the total price for a recipe
	 * @return float
	 */
	public function computeTotalPrice()
	{
		$price = 0;

		foreach ($this->ingredients as $ingredient)
			$price += $ingredient->quantity->computePrice();

		return $price;
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
	 * Tell if a recipe has a location
	 * @return boolean
	 */
	public function hasLocation()
	{
		return ! is_null($this->location);
	}

	/**
	 * Get allowed types
	 * @return array
	 */
	public static function getAllowedTypeValues()
	{
		return [self::AMUSE_GUEULE, self::STARTER, self::MAIN, self::DESSERT];
	}
}