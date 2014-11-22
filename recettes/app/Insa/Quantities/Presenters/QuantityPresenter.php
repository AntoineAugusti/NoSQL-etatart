<?php namespace Insa\Quantities\Presenters;

use Lang;
use Laracasts\Presenter\Presenter;
use Insa\Quantities\Models\Quantity;

class QuantityPresenter extends Presenter {

	public function price()
	{
		$price = $this->entity->computePrice();

		return $price. ' €';
	}

	public function unit()
	{
		return Lang::get('quantities.for'.ucfirst($this->entity->unit));
	}
}