<?php namespace Insa\Recipes\Controllers;

use Config, Input, Paginator, Session, Redirect, Str, View;
use Illuminate\Routing\Controller;
use Illuminate\Support\Collection;
use Insa\Exceptions\RecipeNotFoundException;
use Insa\Ingredients\Models\Ingredient;
use Insa\Quantities\Models\Quantity;
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

		$this->beforeFilter('csrf', ['only' => ['redirectToIngredients', 'redirectToQuantities', 'store']]);
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

	public function redirectToIngredients()
	{
		$recipeData = Input::only(['title', 'rating', 'type', 'preparationTime', 'cookingTime', 'description']);

		$this->recipesValidator->validateCreate($recipeData);

		Session::set('recipe', $recipeData);

		return Redirect::route('recipes.ingredients.create');
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

	public function createQuantities()
	{
		$data = [
			'ingredients'   => new Collection(Session::get('ingredients')),
			'recipe'        => Session::get('recipe'),
			'possibleTypes' => Quantity::getAllowedUnitValues()
		];

		return View::make('quantities.create', $data);
	}

	public function redirectToQuantities()
	{
		Session::set('ingredients', Input::get('ingredients'));

		return Redirect::route('recipes.ingredients.quantities.create');
	}

	public function store()
	{
		$ingredients = Session::get('ingredients');
		$this->recipesValidator->quantitiesAreCorrectForIngredients($ingredients, Input::all());

		// Store the recipe
		extract(Session::get('recipe'));
		$recipe = $this->recipesRepo->create($title, $rating, $type, $preparationTime, $cookingTime, $description);

		// Foreach ingredient, associate its quantity
		foreach ($ingredients as $ingredient) {
			$slug = Str::slug($ingredient);

			$ing = new Ingredient(['name' => $ingredient]);
			$q = new Quantity([
				'unit'     => Input::get('unit-'.$slug),
				'price'    => Input::get('price-'.$slug),
				'quantity' => Input::get('quantity-'.$slug),
			]);
			
			$ing->quantity()->associate($q);

			// Add the ingredient to the recipe
			$recipe = $this->recipesRepo->addIngredient($recipe, $ing);
		}

		// Forget values stored in session
		Session::forget('recipe');
		Session::forget('ingredients');

		return Redirect::route('recipes.show', $recipe->slug)
			->withSuccess(trans('recipes.recipeCreated'));
	}
}