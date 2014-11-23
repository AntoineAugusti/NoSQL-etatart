<?php namespace Insa\Recipes\Models;

use Moloquent;
use Laracasts\Presenter\PresentableTrait;

class Recipe extends Moloquent {

	use PresentableTrait;

	const AMUSE_GUEULE = 'amuse-gueule';
	const DESSERT      = 'dessert';
	const MAIN         = 'main';
	const STARTER      = 'starter';

	protected $presenter = 'Insa\Recipes\Presenters\RecipePresenter';
	public $fillable = ['title', 'rating', 'cookingTime', 'preparationTime', 'type', 'slug', 'description'];

	public function ingredients()
	{
		return $this->embedsMany(\Insa\Ingredients\Models\Ingredient::class);
	}

	public function location()
	{
		return $this->belongsTo(\Insa\Recipes\Models\Location::class);
	}

	public function setRatingAttribute($value)
	{
		if (! is_numeric($value) OR $value < 1 OR $value > 10)
			throw new \InvalidArgumentException("The rating should be between 1 and 10");

		$this->attributes['rating'] = $value;
	}

	public function computeTotalPrice()
	{
		$price = 0;

		foreach ($this->ingredients as $ingredient)
			$price += $ingredient->quantity->computePrice();

		return $price;
	}

	public function setTypeAttribute($value)
	{
		$allowedValues = self::getAllowedTypeValues();
		if ( ! in_array($value, $allowedValues))
			throw new \InvalidArgumentException($value." is not a valid type. Possible values are: ".implode('|', $allowedValues));
			
		$this->attributes['type'] = $value;
	}

	public static function getAllowedTypeValues()
	{
		return [self::AMUSE_GUEULE, self::STARTER, self::MAIN, self::DESSERT];
	}
}