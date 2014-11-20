<?php namespace Insa\Ingredients\Models;

use Moloquent;

class Ingredient extends Moloquent {

	public $timestamps = false;
	public $fillable = ['name'];

	public function quantity()
	{
		return $this->embedsOne(\Insa\Quantities\Models\Quantity::class);
	}
}