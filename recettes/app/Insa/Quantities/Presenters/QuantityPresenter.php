<?php namespace Insa\Quantities\Presenters;

use Laracasts\Presenter\Presenter;
use Insa\Quantities\Models\Quantity;

class QuantityPresenter extends Presenter {

	public function price()
	{
		return $this->entity->value. ' €';
	}

	public function unit()
	{
		switch ($this->entity->type) {
			case Quantity::GRAMMES_LITER:
				return '/ 100 grammes / liter';

			case Quantity::KILO:
				return ' / kilo';

			case Quantity::UNIT:
				return ' / unit';
		}
	}
}