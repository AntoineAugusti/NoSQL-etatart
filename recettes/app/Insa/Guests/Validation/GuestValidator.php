<?php

namespace Insa\Guests\Validation;

use Insa\Tools\Validation\Validator as BaseValidator;

class GuestValidator extends BaseValidator
{
    /**
     * The validation rules when creating a guest.
     *
     * @var array
     */
    protected $rules = [
        'name' => 'required',
        'phoneNumber' => 'required|regex:/[0-9]{10,11}/',
        'type' => 'required|in:family,colleague,friend',
    ];
}
