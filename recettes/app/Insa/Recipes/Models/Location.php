<?php namespace Insa\Recipes\Models;

use Moloquent;
use Laracasts\Presenter\PresentableTrait;

class Location extends Moloquent {

	use PresentableTrait;

	const MANUSCRIPT = 'manuscript';
	const BOOK       = 'book';
	const URL        = 'url';
	const MAGAZINE   = 'magazine';

	protected $presenter = 'Insa\Recipes\Presenters\LocationPresenter';
	public $fillable = ['date', 'name', 'description', 'type'];

	public function recipes()
	{
		return $this->hasMany(\Insa\Recipes\Models\Recipe::class);
	}

	public function setDateAttribute($value)
	{
		if (! in_array($this->type, [self::URL, self::MAGAZINE]))
			throw new \InvalidArgumentException("Can only set the date for a magazine or a URL");

		$this->attributes['date'] = $value;
	}

	public function setTypeAttribute($value)
	{
		$allowedValues = self::getAllowedTypeValues();
		if ( ! in_array($value, $allowedValues))
			throw new \InvalidArgumentException($value." is not a valid type. Possible values are: ".implode('|', $allowedValues));
			
		$this->attributes['type'] = $value;
	}

	public static function getAllowedTypeValues()
	{
		return [self::MANUSCRIPT, self::BOOK, self::URL, self::MAGAZINE];
	}
}