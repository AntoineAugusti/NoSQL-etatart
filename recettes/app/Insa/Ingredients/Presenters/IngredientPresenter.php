<?php namespace Insa\Ingredients\Presenters;

use Lang;
use Laracasts\Presenter\Presenter;

class IngredientPresenter extends Presenter {

	public function price()
	{
		// Defer to the quantity presenter
		return $this->entity->quantity->present()->price;
	}

	public function unit()
	{
		return Lang::get('quantities.'.$this->entity->unit);
	}
}