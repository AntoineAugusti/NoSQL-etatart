<?php namespace Insa\Recipes\Controllers;

use Config, Input, Paginator, Session, Redirect, View;
use Illuminate\Routing\Controller;
use Insa\Exceptions\RecipeNotFoundException;
use Insa\Recipes\Models\Recipe;
use Insa\Recipes\Repositories\RecipesRepository;
use Insa\Recipes\Validation\RecipeValidator;

class RecipesController extends Controller {

	private $recipesRepo;
	private $recipesValidator;
	
	public function __construct(RecipesRepository $recipesRepo, RecipeValidator $recipesValidator)
	{
		$this->recipesRepo = $recipesRepo;
		$this->recipesValidator = $recipesValidator;

		$this->beforeFilter('csrf', ['only' => 'store']);
		$this->beforeFilter('hasCreatedRecipe', ['only' => 'createIngredients']);
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

	public function store()
	{
		$data = Input::only(['title', 'rating', 'type', 'preparationTime', 'cookingTime', 'description']);

		$this->recipesValidator->validateCreate($data);

		// Store the recipe
		extract($data);
		$recipe = $this->recipesRepo->create($title, $rating, $type, $preparationTime, $cookingTime, $description);

		return Redirect::route('recipes.ingredients.create')->withRecipe($recipe);
	}

	public function createIngredients()
	{
		$ingredients = $this->recipesRepo->getAllIngredients();
		
		$data = [
			// Keys and values are the same
			'ingredients' => array_combine($ingredients, $ingredients),
		];
		
		return View::make('ingredients.create', $data);
	}

	public function storeIngredients()
	{
		return Input::all();
	}
}