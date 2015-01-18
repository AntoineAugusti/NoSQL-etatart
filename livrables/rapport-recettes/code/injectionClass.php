<?php namespace Insa\Recipes\Controllers;

use Insa\Recipes\Repositories\RecipeRepository;

class RecipesController extends BaseController {

	/**
	 * @var \Insa\Recipes\Repositories\RecipeRepository
	 */
	private $recipeRepo;

	public function __construct(RecipeRepository $recipeRepo)
	{
		// L'implémentation concrète de l'interface sera injectée
		// grâce à la l'injection de dépendance et l'IoC Container
		$this->recipeRepo = $recipeRepo;
	}

	/**
	 * Liste toutes les recettes
	 *
	 * @return \Illuminate\Support\Collection
	 */
	public function index()
	{
		// On défère la tâche au répertoire
		return $this->recipeRepo->all();
	}
}