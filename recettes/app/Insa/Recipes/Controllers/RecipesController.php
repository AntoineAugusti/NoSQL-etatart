<?php namespace Insa\Recipes\Controllers;

use Config, Input, Paginator, View;
use Illuminate\Routing\Controller;
use Insa\Exceptions\RecipeNotFoundException;
use Insa\Recipes\Models\Recipe;
use Insa\Recipes\Repositories\RecipesRepository;

class RecipesController extends Controller {

	private $recipesRepo;
	
	public function __construct(RecipesRepository $recipesRepo)
	{
		$this->recipesRepo = $recipesRepo;
	}

	public function index()
	{
		$pagesize = Config::get('recipes.perPage');
		$recipes = $this->recipesRepo->index(Input::get('page', 1), $pagesize);
		$totalRecipes = $this->recipesRepo->getTotalRecipes();

		$data = [
			'recipes' => $recipes,
			'paginator' => Paginator::make($recipes->toArray(), $totalRecipes, $pagesize),
		];

		return View::make('recipes.index', $data);
	}

	public function create()
	{
		$data = [
			'possibleTypes' => Recipe::getAllowedTypeValues()
		];
		
		return View::make('recipes.create', $data);
	}

	public function show($slug)
	{
		$recipe = $this->recipesRepo->getBySlug($slug);

		if (is_null($recipe)) throw new RecipeNotFoundException;

		return View::make('recipes.show', compact('recipe'));
	}
}