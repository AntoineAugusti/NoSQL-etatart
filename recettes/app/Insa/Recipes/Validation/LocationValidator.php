<?php namespace Insa\Recipes\Validation;

use Insa\Tools\Validation\Validator as BaseValidator;

class LocationValidator extends BaseValidator {
	
	/**
	 * The validation rules when choosing a location
	 * @var array
	 */
	protected $rulesChoose = [
		'id' => 'exists:locations,_id',
	];
}