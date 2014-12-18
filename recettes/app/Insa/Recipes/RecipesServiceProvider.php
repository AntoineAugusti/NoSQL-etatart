<?php namespace Insa\Recipes;

use Illuminate\Support\ServiceProvider;
use Insa\Tools\Namespaces\NamespaceTrait;

class RecipesServiceProvider extends ServiceProvider {

	use NamespaceTrait;

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerPatterns();
		$this->registerRecipesRoutes();
		$this->registerRecipesBindings();
	}

	private function registerPatterns()
	{
		$this->app['router']->pattern('rank', implode('|', $this->getPossibleRanks()));
	}

	private function registerRecipesRoutes()
	{
		$controller = 'RecipesController';

		$this->app['router']->group($this->getRouteGroupParams(), function() use ($controller) {
			$this->app['router']->get('/', ['as' => 'recipes.index', 'uses' => $controller.'@index']);

			// Step 1
			$this->app['router']->get('recipes/create', ['as' => 'recipes.create', 'uses' => $controller.'@create']);
			$this->app['router']->post('recipes/create', ['as' => 'recipes.redirect', 'uses' => $controller.'@redirectToIngredients']);
			// Step 2
			$this->app['router']->get('recipes/ingredients/create', ['as' => 'recipes.ingredients.create', 'uses' => $controller.'@createIngredients']);
			$this->app['router']->post('recipes/ingredients/create', ['as' => 'recipes.ingredients.redirect', 'uses' => $controller.'@redirectToQuantities']);
			// Step 3
			$this->app['router']->get('recipes/ingredients/quantities/create', ['as' => 'recipes.ingredients.quantities.create', 'uses' => $controller.'@createQuantities']);
			$this->app['router']->post('recipes/ingredients/quantities/create', ['as' => 'recipes.ingredients.quantities.redirect', 'uses' => $controller.'@redirectToLocation']);
			// Step 4
			$this->app['router']->get('recipes/location/create', ['as' => 'recipes.location.create', 'uses' => $controller.'@createLocation']);
			$this->app['router']->post('recipes', ['as' => 'recipes.store', 'uses' => $controller.'@store']);

			$this->app['router']->get('recipes/ranks/{rank?}', ['as' => 'recipes.ranking', 'uses' => $controller.'@getRanking']);
			$this->app['router']->get('recipes/{slug}', ['as' => 'recipes.show', 'uses' => $controller.'@show']);
		});
	}

	private function getPossibleRanks()
	{
		return $this->app['config']->get('recipes.possibleRanks');
	}

	private function registerRecipesBindings()
	{
		$namespace = $this->getNamespaceRepositories();

		$this->app->bind(
			$namespace.'RecipesRepository',
			$namespace.'MongoRecipesRepository'
		);

		$this->app->bind(
			$namespace.'LocationsRepository',
			$namespace.'MongoLocationsRepository'
		);
	}

	/**
	 * Parameters for the group of routes
	 * @return array
	 */
	private function getRouteGroupParams()
	{
		return [
			'namespace' => $this->getNamespaceControllers(),
		];
	}
}