<?php namespace Insa\Ingredients\Models;

use Moloquent;
use Laracasts\Presenter\PresentableTrait;

class Ingredient extends Moloquent {

	use PresentableTrait;

	public $timestamps = false;
	public $fillable = ['name'];
	protected $presenter = 'Insa\Ingredients\Presenters\IngredientPresenter';

	public function quantity()
	{
		return $this->embedsOne(\Insa\Quantities\Models\Quantity::class);
	}
}