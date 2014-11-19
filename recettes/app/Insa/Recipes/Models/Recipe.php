<?php namespace Insa\Recipes\Models;

use Moloquent;

class Recipe extends Moloquent {

	public function setNoteAttribute($value)
	{
		if (! is_int($value) OR $value < 0 OR $value > 10)
			throw new \InvalidArgumentException("The rating should be between 0 and 10");

		$this->attributes['note'] = $value;
	}

	public function setTypeAttribute($value)
	{
		$allowedValues = ['amuse-gueule', 'dessert', 'plat', 'entree'];
		if ( ! in_array($value, $allowedValues))
			throw new \InvalidArgumentException($value." is not a valid type. Possible values are: ".implode('|', $allowedValues));
			
		$this->attributes['type'] = $value;
	}
}