<?php

namespace Insa\Recipes\Controllers;

use Config;
use Input;
use Lang;
use Paginator;
use Session;
use Redirect;
use Str;
use View;
use Illuminate\Routing\Controller;
use Illuminate\Support\Collection;
use Insa\Events\Repositories\EventsRepository;
use Insa\Exceptions\RecipeNotFoundException;
use Insa\Ingredients\Models\Ingredient;
use Insa\Recipes\Models\Recipe;
use Insa\Recipes\Repositories\LocationsRepository;
use Insa\Recipes\Repositories\RecipesRepository;
use Insa\Recipes\Validation\LocationValidator;
use Insa\Recipes\Validation\RecipeValidator;

class RecipesController extends Controller
{
    /**
     * @var LocationsRepository
     */
    private $locationsRepo;

    /**
     * @var LocationValidator
     */
    private $locationValidator;

    /**
     * @var RecipesRepository
     */
    private $recipesRepo;

    /**
     * @var RecipeValidator
     */
    private $recipeValidator;

    /**
     * @var EventsRepository
     */
    private $eventsRepository;

    public function __construct(LocationsRepository $locationsRepo, LocationValidator $locationValidator, RecipesRepository $recipesRepo, RecipeValidator $recipeValidator, EventsRepository $eventsRepository)
    {
        $this->locationsRepo = $locationsRepo;
        $this->locationValidator = $locationValidator;
        $this->recipesRepo = $recipesRepo;
        $this->recipeValidator = $recipeValidator;
        $this->eventsRepository = $eventsRepository;

        $this->beforeFilter('csrf', ['only' => ['redirectToIngredients', 'redirectToQuantities', 'redirectToLocation', 'store']]);
        $this->beforeFilter('hasCreatedRecipe', ['only' => ['createIngredients']]);
        $this->beforeFilter('hasChoosenIngredients', ['only' => ['createQuantities']]);
        $this->beforeFilter('hasChoosenQuantities', ['only' => ['createLocation', 'store']]);
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
            'possibleTypes' => Recipe::getAllowedTypeValues(),
        ];

        return View::make('recipes.create', $data);
    }

    public function show($slug)
    {
        $recipe = $this->recipesRepo->getBySlug($slug);
        $events = $this->eventsRepository->getAll();
        $allEvents = [];
        foreach ($events as $event) {
            $allEvents[$event->id] = $event->name;
        }

        if (is_null($recipe)) {
            throw new RecipeNotFoundException();
        }

        return View::make('recipes.show', compact('recipe', 'allEvents'));
    }

    public function redirectToIngredients()
    {
        $recipeData = Input::only(['title', 'rating', 'type', 'preparationTime', 'cookingTime', 'description']);

        $this->recipeValidator->validateCreate($recipeData);

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

    public function redirectToQuantities()
    {
        Session::set('ingredients', Input::get('ingredients'));

        return Redirect::route('recipes.ingredients.quantities.create');
    }

    public function createQuantities()
    {
        $ingredientsData = $this->recipesRepo->getAllIngredients();
        $ingredientsName = $ingredientsData->lists('name');
        $ingredients = new Collection(Session::get('ingredients'));
        $recipe = Session::get('recipe');

        // Compute the slug for each ingredient
        $slugs = $this->computeSlugs($ingredients->all());

        // For existing ingredients, grab data from the ingredientsData collection
        $existingIngredients = $this->computeExistingIngredients($ingredients->all(), $ingredientsData);

        $data = compact('ingredients', 'ingredientsName', 'ingredientsData', 'recipe', 'existingIngredients');
        $data['ingredientsSlug'] = array_combine($ingredients->all(), $slugs);
        $data['possibleTypes'] = Ingredient::getAllowedUnitValues();

        return View::make('quantities.create', $data);
    }

    public function redirectToLocation()
    {
        $ingredients = Session::get('ingredients');
        $quantities = $this->getQuantitiesForIngredients($ingredients);

        // Perform validation
        $this->recipeValidator->quantitiesAreCorrectForIngredients($ingredients, $quantities);

        // Store quantities in session
        Session::set('quantities', $quantities);

        return Redirect::route('recipes.location.create');
    }

    public function createLocation()
    {
        $locations = $this->computeLocationsForSelect(
            $this->locationsRepo->getAll()
        );

        return View::make('locations.choose', compact('locations'));
    }

    public function store()
    {
        $ingredients = Session::get('ingredients');
        $quantities = Session::get('quantities');
        $locationID = Input::get('location');

        // Perform validaton
        $this->locationValidator->validateChoose(['id' => $locationID]);

        // Store the recipe
        $recipe = $this->recipesRepo->createWithIngredientsAndQuantities(Session::get('recipe'), $ingredients, $quantities);

        // Set the location
        $this->recipesRepo->addLocation($recipe, $this->locationsRepo->findById($locationID));

        // Forget values stored in session
        Session::forget('recipe');
        Session::forget('ingredients');
        Session::forget('quantities');

        return Redirect::route('recipes.show', $recipe->slug)
            ->withSuccess(trans('recipes.recipeCreated'));
    }

    public function getRanking($note = null)
    {
        $possibleRanks = Config::get('recipes.possibleRanks');

        // Display best recipes by default
        if (is_null($note)) {
            return Redirect::route('recipes.ranking', end($possibleRanks));
        }

        $pagesize = Config::get('recipes.perPage');
        $recipes = $this->recipesRepo->getForRank($note, Input::get('page', 1), $pagesize);
        $totalRecipes = $this->recipesRepo->getTotalForRank($note);

        $data = [
            'notes' => $possibleRanks,
            'rating' => $note,
            'recipes' => $recipes,
            'paginator' => Paginator::make($recipes->toArray(), $totalRecipes, $pagesize),
        ];

        return View::make('recipes.ranking', $data);
    }

    /**
     * For each ingredient given, try to find a correspondance in the collection.
     *
     * @param array                          $ingredients
     * @param \Illuminate\Support\Collection $ingredientsData
     *
     * @return array Keys are slugs identifying an ingredient and the value is the ingredient
     *               object if it was found, or null
     */
    private function computeExistingIngredients(array $ingredients, Collection $ingredientsData)
    {
        $instance = $this;

        $existingIngredients = array_map(function ($a) use ($ingredientsData, $instance) {
            return $instance->findByNameInCollection($a, $ingredientsData);
        }, $ingredients);

        // Construct the final array, keys are ingredients' slugs
        $existingIngredients = array_combine(array_map(array($this, 'computeSlug'), $ingredients), $existingIngredients);

        return $existingIngredients;
    }

    /**
     * Find an element by the value of its name attribute in a collection.
     *
     * @param string                         $nameValue
     * @param \Illuminate\Support\Collection $collection
     *
     * @return mixed|null
     */
    private function findByNameInCollection($nameValue, Collection $collection)
    {
        foreach ($collection as $element) {
            if ($element->name == $nameValue) {
                return $element;
            }
        }

        return null;
    }

    private function getQuantitiesForIngredients(array $ingredients)
    {
        $quantities = [];
        foreach ($ingredients as $ingredient) {
            $quantities = $this->grabQuantitiesForIngredient($ingredient, $quantities);
        }

        return $quantities;
    }

    private function grabQuantitiesForIngredient($ingredient, array $quantities)
    {
        $slug = $this->computeSlug($ingredient);

        $quantities['unit-'.$slug] = Input::get('unit-'.$slug);
        $quantities['price-'.$slug] = Input::get('price-'.$slug);
        $quantities['quantity-'.$slug] = Input::get('quantity-'.$slug);

        return $quantities;
    }

    /**
     * Create an array of locations in order to select a location, by its type.
     *
     * @param Illuminate\Support\Collection $locations
     *
     * @return array
     *
     * @example [
     *   'book' => ['22' => 'Awesome', '23' => 'Amazing'],
     *   'URL' => ['42' => 'Awesome 2', '43' => 'Amazing 2'],
     * ]
     */
    private function computeLocationsForSelect(Collection $locations)
    {
        $groupedByType = $locations->groupBy('type');

        $results = [];

        foreach ($groupedByType as $key => $value) {
            $results[Lang::get('locations.type'.ucfirst($key))] = $this->extractKeyAndNameFromLocations($value);
        }

        return $results;
    }

    private function extractKeyAndNameFromLocations(array $locations)
    {
        $out = [];

        foreach ($locations as $loc) {
            $out[$loc->_id] = $loc->name;
        }

        return $out;
    }

    /**
     * Compute slug for each element.
     *
     * @param array $items
     *
     * @return array
     */
    private function computeSlugs(array $items)
    {
        return array_map(array($this, 'computeSlug'), $items);
    }

    private function computeSlug($value)
    {
        return Str::slug($value);
    }
}
