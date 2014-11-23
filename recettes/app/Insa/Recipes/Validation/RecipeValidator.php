<?php namespace Insa\Recipes\Validation;

use Lang, Str;
use Insa\Quantities\Models\Quantity;
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

	public function quantitiesAreCorrectForIngredients(array $ingredients, array $data)
	{
		$rules = [];
		$messages = [];
		
		foreach ($ingredients as $ingredient)
		{
			// Set rules
			$rules = $this->appendRules($ingredient, $rules);

			// Set messages
			$messages = $this->appendMessages($ingredient, $messages);
		}

		$this->validation = $this->make($data, $rules, $messages);

		return $this->handleValidation();
	}

	/**
	 * Append validation rules for an ingredient
	 * @param  string $ingredient
	 * @param  array $rules
	 * @return array
	 */
	private function appendRules($ingredient, array $rules)
	{
		$slug = $this->computeSlug($ingredient);
		$allowedUnits = Quantity::getAllowedUnitValues();
		
		$rules['unit-'.$slug]     = 'required|in:'.implode(',', $allowedUnits);
		$rules['price-'.$slug]    = 'required|numeric|between:0,1000';
		$rules['quantity-'.$slug] = 'required|numeric|between:0,1000';

		return $rules;
	}

	/**
	 * Append translation messages used for validation, for an ingredient
	 * @param  string $ingredient
	 * @param  array $messages
	 * @return array
	 */
	private function appendMessages($ingredient, array $messages)
	{
		$slug = $this->computeSlug($ingredient);
		$replace = ['ing' => $ingredient];

		// Unit
		$messages['unit-'.$slug.'.required'] = Lang::get('quantities.validationUnit', $replace); 
		$messages['unit-'.$slug.'.in'] = Lang::get('quantities.validationUnit', $replace); 
		
		// Price
		$messages['price-'.$slug.'.required'] = Lang::get('quantities.validationPrice', $replace); 
		$messages['price-'.$slug.'.numeric'] = Lang::get('quantities.validationPrice', $replace); 
		$messages['price-'.$slug.'.between'] = Lang::get('quantities.validationPrice', $replace); 
		
		// Quantity
		$messages['quantity-'.$slug.'.required'] = Lang::get('quantities.validationQuantity', $replace); 
		$messages['quantity-'.$slug.'.numeric'] = Lang::get('quantities.validationQuantity', $replace); 
		$messages['quantity-'.$slug.'.between'] = Lang::get('quantities.validationQuantity', $replace);

		return $messages;
	}

	/**
	 * Compute the slug of a string
	 * @param  string $value
	 * @return string
	 */
	private function computeSlug($value)
	{
		return Str::slug($value);
	}
}