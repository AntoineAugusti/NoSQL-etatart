<?php namespace Insa\Ingredients\Presenters;

use Lang;
use Laracasts\Presenter\Presenter;

class IngredientPresenter extends Presenter {

	/**
	 * Display the price of an ingredient
	 * @return string
	 */
	public function price()
	{
		// Defer to the quantity presenter
		return $this->entity->quantity->present()->price;
	}

	/**
	 * Display a translated version of the unit
	 * @return string
	 */
	public function unit()
	{
		return Lang::get('quantities.'.$this->entity->unit);
	}
}