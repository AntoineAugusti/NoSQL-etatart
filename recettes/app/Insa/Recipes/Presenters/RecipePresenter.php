<?php namespace Insa\Recipes\Presenters;

use Lang;
use Laracasts\Presenter\Presenter;

class RecipePresenter extends Presenter {
	
	public function cookingTime()
	{
		$hours = floor($this->entity->cookingTime / 60);
		$minutes = ($this->entity->cookingTime % 60);

		return Lang::choice('recipes.cookingTime', $hours, compact('hours', 'minutes'));
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
}