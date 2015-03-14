<?php namespace Insa\Recipes\Presenters;

use Lang;
use Laracasts\Presenter\Presenter;

class RecipePresenter extends Presenter {

	/**
	 * Get the HTML for the total time
	 * @return string
	 */
	public function totalTime()
	{
		$time = $this->entity->cookingTime + $this->entity->preparationTime;

		return $this->htmlForTime($time);
	}

	/**
	 * Get the total price in Euro
	 * @return string
	 */
	public function totalPrice()
	{
		return $this->entity->computeTotalPrice().' €';
	}

	/**
	 * Get the HTML for the cooking time
	 * @return string
	 */
	public function cookingTime()
	{
		return $this->htmlForTime($this->entity->cookingTime);
	}

	/**
	 * Get the HTML for the preparation time
	 * @return string
	 */
	public function preparationTime()
	{
		return $this->htmlForTime($this->entity->preparationTime);
	}

	/**
	 * Get the type, translated
	 * @return string
	 */
	public function type()
	{
		return Lang::get('recipes.'.$this->entity->type);
	}

	/**
	 * Get the HTML for the rating
	 * @return string
	 */
	public function rating()
	{
		$nbStars = floor($this->entity->rating / 2);
		$nbStarsGray = 5 - $nbStars;

		$star = '<i class="recipes__star mdi-action-star-rate"></i>';
		$starYellow = '<i class="recipes__star mdi-action-star-rate yellow"></i>';

		// Yellow stars
		$html = str_repeat($starYellow, $nbStars);

		// Gray stars
		$html .= str_repeat($star, $nbStarsGray);

		return $html;
	}

	/**
	 * Compute the HTML to display the total time
	 * @param  int $time The number of minutes
	 * @return string
	 */
	private function htmlForTime($time)
	{
		$hours = floor($time / 60);
		$minutes = ($time % 60);
		// Add a leading 0 to single digits
		$minutes = sprintf("%02s", $minutes);

		return Lang::choice('recipes.cookingTime', $hours, compact('hours', 'minutes'));
	}
}