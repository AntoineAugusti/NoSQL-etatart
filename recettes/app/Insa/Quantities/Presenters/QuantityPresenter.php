<?php namespace Insa\Quantities\Presenters;

use Laracasts\Presenter\Presenter;

class QuantityPresenter extends Presenter {

	public function price()
	{
		$price = $this->entity->computePrice();

		return $price. ' €';
	}
}