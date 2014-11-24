<?php namespace Insa\Recipes\Presenters;

use Lang;
use Insa\Recipes\Models\Location;
use Laracasts\Presenter\Presenter;

class LocationPresenter extends Presenter {

	public function iconType()
	{
		switch ($this->entity->type) {
			case Location::MANUSCRIPT:
				return '<i class="locations__icon mdi-content-create"></i>';

			case Location::BOOK:
				return '<i class="locations__icon mdi-action-book"></i>';

			case Location::URL:
				return '<i class="locations__icon mdi-av-web"></i>';

			case Location::MAGAZINE:
				return '<i class="locations__icon mdi-action-account-box"></i>';
		}
	}

	public function date()
	{
		if (! $this->entity->hasDate())
			return '';

		$dateDiff = $this->entity->date->diffForHumans();

		switch ($this->entity->type) {
			case Location::MAGAZINE:
				return Lang::get('locations.publishDate').' '.$dateDiff;

			case Location::MAGAZINE:
				return Lang::get('locations.lastVisit').' '.$dateDiff;
		}
	}
}