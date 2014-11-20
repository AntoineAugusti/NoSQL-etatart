<?php namespace Insa\Recipes\Controllers;

use View;
use Illuminate\Routing\Controller;
use Insa\Recipes\Repositories\RecipesRepository;

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
}