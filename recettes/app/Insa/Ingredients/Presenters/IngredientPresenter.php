<?php namespace Insa\Ingredients\Presenters;

use Laracasts\Presenter\Presenter;

class IngredientPresenter extends Presenter {

	public function price()
	{
		// Defer to the quantity presenter
		return $this->entity->quantity->present()->price;
	}

	public function unit()
	{
		// Defer to the quantity presenter
		return $this->entity->quantity->present()->unit;
	}
}