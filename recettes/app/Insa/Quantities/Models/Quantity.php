<?php namespace Insa\Quantities\Models;

use Moloquent;
use Laracasts\Presenter\PresentableTrait;

class Quantity extends Moloquent {

	use PresentableTrait;

	public $timestamps = false;
	public $fillable = ['type', 'value'];
	protected $presenter = 'Insa\Quantities\Presenters\QuantityPresenter';

	const GRAMMES_LITER = '100g-liter';
	const KILO = 'kilo';
	const UNIT = 'unit';

	public function ingredient()
	{
		return $this->belongsTo('Insa\Ingredients\Models\Ingredient');
	}

	public function setTypeAttribute($value)
	{
		$allowedValues = [self::GRAMMES_LITER, self::KILO, self::UNIT];
		if ( ! in_array($value, $allowedValues))
			throw new \InvalidArgumentException($value." is not a valid type. Possible values are: ".implode('|', $allowedValues));
			
		$this->attributes['type'] = $value;
	}
}