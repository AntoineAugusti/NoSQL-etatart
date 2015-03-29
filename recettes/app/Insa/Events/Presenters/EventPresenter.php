<?php namespace Insa\Events\Presenters;

use Illuminate\Support\Facades\Lang;
use Laracasts\Presenter\Presenter;

class EventPresenter extends Presenter {

    public function date()
    {
        return $this->entity->date->format('d/m/Y');
    }

    public function type()
    {
        return Lang::get('events.' . $this->entity->type);
    }
}