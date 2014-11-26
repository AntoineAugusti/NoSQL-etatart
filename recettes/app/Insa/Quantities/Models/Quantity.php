<?php namespace Insa\Quantities\Models;

use Moloquent;
use Laracasts\Presenter\PresentableTrait;

class Quantity extends Moloquent {

	use PresentableTrait;

	public $timestamps = false;
	public $fillable = ['quantity'];
	protected $presenter = 'Insa\Quantities\Presenters\QuantityPresenter';

	public function ingredient()
	{
		return $this->belongsTo('Insa\Ingredients\Models\Ingredient');
	}

	/**
	 * Return the price of the ingredient given the amount and the price / unit
	 * @return float
	 */
	public function computePrice()
	{
		return round($this->ingredient->price * $this->quantity, 2);
	}
}