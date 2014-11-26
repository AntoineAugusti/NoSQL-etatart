<?php namespace Insa\Recipes\Controllers;

use Config, Input, Paginator, Session, Redirect, Str, View;
use Illuminate\Routing\Controller;
use Illuminate\Support\Collection;
use Insa\Exceptions\RecipeNotFoundException;
use Insa\Ingredients\Models\Ingredient;
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
		$ingredients = $this->recipesRepo->getAllIngredients()->lists('name');
		
		$data = [
			// Keys and values are the same
			'ingredients' => array_combine($ingredients, $ingredients),
		];
		
		return View::make('ingredients.create', $data);
	}

	public function createQuantities()
	{
		$ingredientsData = $this->recipesRepo->getAllIngredients();
		$ingredientsName = $ingredientsData->lists('name');

		// Compute the slug foreach ingredient
		$slugs = array_map(array($this, "computeSlug"), $ingredientsName);
		
		$data = [
			'ingredients'     => new Collection(Session::get('ingredients')),
			'ingredientsData' => $ingredientsData,
			'ingredientsName' => $ingredientsName,
			'ingredientsSlug' => array_combine($ingredientsName, $slugs),
			'possibleTypes'   => Ingredient::getAllowedUnitValues(),
			'recipe'          => Session::get('recipe'),
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
		$quantities = $this->getQuantitiesForIngredients($ingredients);
		
		// Perform validation
		$this->recipesValidator->quantitiesAreCorrectForIngredients($ingredients, $quantities);

		// Store the recipe
		$recipe = $this->recipesRepo->createWithIngredientsAndQuantities(Session::get('recipe'), $ingredients, $quantities);

		// Forget values stored in session
		Session::forget('recipe');
		Session::forget('ingredients');

		return Redirect::route('recipes.show', $recipe->slug)
			->withSuccess(trans('recipes.recipeCreated'));
	}

	private function getQuantitiesForIngredients(array $ingredients)
	{
		$quantities = [];
		foreach ($ingredients as $ingredient)
			$quantities = $this->grabQuantitiesForIngredient($ingredient, $quantities);

		return $quantities;
	}

	private function grabQuantitiesForIngredient($ingredient, array $quantities)
	{
		$slug = $this->computeSlug($ingredient);

		$quantities['unit-'.$slug]     = Input::get('unit-'.$slug);
		$quantities['price-'.$slug]    = Input::get('price-'.$slug);
		$quantities['quantity-'.$slug] = Input::get('quantity-'.$slug);

		return $quantities;
	}

	private function computeSlug($value)
	{
		return Str::slug($value);
	}
}