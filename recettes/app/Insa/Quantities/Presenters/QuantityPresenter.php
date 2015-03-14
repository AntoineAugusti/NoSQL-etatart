<?php namespace Insa\Quantities\Presenters;

use Laracasts\Presenter\Presenter;

class QuantityPresenter extends Presenter {

	/**
	 * Display the price in Euro
	 * @return string
	 */
	public function price()
	{
		$price = $this->entity->computePrice();

		return $price. ' €';
	}
}