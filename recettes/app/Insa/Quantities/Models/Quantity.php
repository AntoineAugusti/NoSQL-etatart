<?php

namespace Insa\Quantities\Models;

use Moloquent;
use Insa\Ingredients\Models\Ingredient;
use Laracasts\Presenter\PresentableTrait;

class Quantity extends Moloquent
{
    use PresentableTrait;

    /**
     * Tell if a quantity should have timestamp attributes.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Fillable attributes for a quantity.
     *
     * @var array
     */
    public $fillable = ['quantity'];

    /**
     * The class to use when presenting an Ingredient.
     *
     * @var string
     */
    protected $presenter = 'Insa\Quantities\Presenters\QuantityPresenter';

    /**
     * Get the ingredient associated to a quantity.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class);
    }

    /**
     * Return the price of the ingredient given the amount and the price / unit.
     *
     * @return float
     */
    public function computePrice()
    {
        return round($this->ingredient->price * $this->quantity, 2);
    }
}
