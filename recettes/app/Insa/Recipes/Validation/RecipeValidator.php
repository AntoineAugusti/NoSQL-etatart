<?php namespace Insa\Recipes\Validation;

use Insa\Tools\Validation\Validator as BaseValidator;

class RecipeValidator extends BaseValidator {
	
	/**
	 * The validation rules when signing in
	 * @var array
	 */
	protected $rulesCreate = [
		'title'           => 'required|unique:recipes,title|min:5',
		'rating'          => 'required|integer|between:1,10',
		'type'            => 'required|in:amuse-gueule,dessert,main,starter',
		'cookingTime'     => 'required|integer|between:5,180',
		'preparationTime' => 'required|integer|between:5,180',
		'description'     => 'required|between:20,1000'
	];
}