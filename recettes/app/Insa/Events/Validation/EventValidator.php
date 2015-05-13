<?php

namespace Insa\Events\Validation;

use Carbon\Carbon;
use Illuminate\Support\MessageBag;
use Insa\Events\Models\Event;
use Insa\Tools\Validation\Validator as BaseValidator;
use Laracasts\Validation\FormValidationException;

class EventValidator extends BaseValidator
{
    /**
     * The validation rules when creating an event.
     *
     * @var array
     */
    protected $rules = [
        'name' => 'required',
        'date' => 'date_format:d/m/Y',
        'type' => 'required|in:birthday,party,christmas,new-year',
    ];

    public function getValidatedDate($type, $date)
    {
        if (($type == Event::PARTY or $type == Event::BIRTHDAY) and empty($date)) {
            throw new FormValidationException('Wrong date (required if event of type PARTY ot BIRTHDAY)', new MessageBag(['Wrong date (required if event of type PARTY ot BIRTHDAY)']));
        }

        if ($type == Event::NEW_YEAR) {
            return Carbon::create(null, '01', '01');
        }

        if ($type == Event::CHRISTMAS) {
            return Carbon::create(null, '12', '25');
        }

        return Carbon::createFromFormat('d/m/Y', $date);
    }
}
