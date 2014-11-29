<?php namespace Insa\Recipes\Presenters;

use Lang;
use Insa\Recipes\Models\Location;
use Laracasts\Presenter\Presenter;

class LocationPresenter extends Presenter {

	public function iconType()
	{
		$icon = $this->getIconForType($this->entity->type);

		return '<i class="locations__icon '.$icon.'"></i>';
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

	private function getIconForType($type)
	{
		switch ($type) {
			case Location::MANUSCRIPT:
				return "mdi-content-create";

			case Location::BOOK:
				return "mdi-action-book";

			case Location::URL:
				return "mdi-av-web";

			case Location::MAGAZINE:
				return "mdi-action-account-box";
		}
	}
}