<?php namespace Insa\Ingredients\Presenters;

use Laracasts\Presenter\Presenter;

class IngredientPresenter extends Presenter {

	public function price()
	{
		return $this->entity->quantity->present()->price;
	}

	public function unit()
	{
		return $this->entity->quantity->present()->unit;
	}
}