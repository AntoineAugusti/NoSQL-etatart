<?php

namespace Insa\Recipes\Presenters;

use Lang;
use Insa\Recipes\Models\Location;
use Laracasts\Presenter\Presenter;

class LocationPresenter extends Presenter
{
    /**
     * Get the HTML for the icon associated to a location.
     *
     * @return string
     */
    public function iconType()
    {
        $icon = $this->getIconForType($this->entity->type);

        return '<i class="locations__icon '.$icon.'"></i>';
    }

    /**
     * Get the name of a location.
     *
     * @return string
     */
    public function name()
    {
        return Lang::get('locations.tooltip'.ucfirst($this->entity->type), ['name' => $this->entity->name]);
    }

    /**
     * Display the date of a location.
     *
     * @return string
     */
    public function date()
    {
        if (!$this->entity->hasDate()) {
            return '';
        }

        $dateDiff = $this->entity->date->diffForHumans();

        switch ($this->entity->type) {
            case Location::MAGAZINE:
                return Lang::get('locations.publishDate').' '.$dateDiff;

            case Location::MAGAZINE:
                return Lang::get('locations.lastVisit').' '.$dateDiff;
        }
    }

    /**
     * Get the icon for a given type.
     *
     * @param string $type
     *
     * @return string
     */
    private function getIconForType($type)
    {
        switch ($type) {
            case Location::MANUSCRIPT:
                return 'mdi-content-create';

            case Location::BOOK:
                return 'mdi-action-book';

            case Location::URL:
                return 'mdi-av-web';

            case Location::MAGAZINE:
                return 'mdi-action-account-box';
        }
    }
}
