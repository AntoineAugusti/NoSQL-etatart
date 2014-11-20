<?php namespace Insa\Recipes\Controllers;

use View;
use Illuminate\Routing\Controller;
use Insa\Recipes\Repositories\RecipesRepository;
use Insa\Exceptions\RecipeNotFoundException;

class RecipesController extends Controller {

	private $recipesRepo;
	
	public function __construct(RecipesRepository $recipesRepo)
	{
		$this->recipesRepo = $recipesRepo;
	}

	public function index()
	{
		$recipes = $this->recipesRepo->getAll();

		return View::make('recipes.index', compact('recipes'));
	}

	public function show($slug)
	{
		$recipe = $this->recipesRepo->getBySlug($slug);

		if (is_null($recipe)) throw new RecipeNotFoundException;

		return View::make('recipes.show', compact('recipe'));
	}
}