<?php namespace Insa\Recipes\Presenters;

use Lang;
use Laracasts\Presenter\Presenter;

class RecipePresenter extends Presenter {
	
	public function totalTime()
	{
		$time = $this->entity->cookingTime + $this->entity->preparationTime;
		
		return $this->htmlForTime($time);
	}

	public function cookingTime()
	{
		return $this->htmlForTime($this->entity->cookingTime);
	}

	public function preparationTime()
	{
		return $this->htmlForTime($this->entity->preparationTime);
	}

	public function type()
	{
		return Lang::get('recipes.'.$this->entity->type);	
	}

	public function rating()
	{
		$nbStars = floor($this->entity->note / 2);
		$nbStarsGray = 5 - $nbStars;
		
		$star = '<i class="recipes__star mdi-action-star-rate"></i>';
		$starYellow = '<i class="recipes__star mdi-action-star-rate yellow"></i>';
		$html = '';

		// Yellow stars
		for ($i = 1; $i <= $nbStars ; $i++)
			$html .= $starYellow;

		// Gray stars
		for ($i = 1; $i <= $nbStarsGray ; $i++)
			$html .= $star;

		return $html;
	}

	private function htmlForTime($time)
	{
		$hours = floor($time / 60);
		$minutes = ($time % 60);
		// Add a leading 0 to single digits
		$minutes = sprintf("%02s", $minutes);

		return Lang::choice('recipes.cookingTime', $hours, compact('hours', 'minutes'));
	}
}