<?php namespace Insa\Quantities\Models;

use Moloquent;

class Quantity extends Moloquent {

	public $timestamps = false;
	public $fillable = ['type', 'value'];

	const GRAMMES_LITRE = '100g-litre';
	const KILO = 'KILO';
	const UNITE = 'unite';

	public function ingredient()
	{
		return $this->belongsTo('Insa\Ingredients\Models\Ingredient');
	}

	public function setTypeAttribute($value)
	{
		$allowedValues = [self::GRAMMES_LITRE, self::KILO, self::UNITE];
		if ( ! in_array($value, $allowedValues))
			throw new \InvalidArgumentException($value." is not a valid type. Possible values are: ".implode('|', $allowedValues));
			
		$this->attributes['type'] = $value;
	}
}