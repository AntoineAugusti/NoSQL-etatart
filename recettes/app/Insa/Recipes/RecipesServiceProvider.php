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
		$this->registerRecipesRoutes();
		$this->registerRecipesBindings();
	}

	private function registerRecipesRoutes()
	{
		$controller = 'RecipesController';
		
		$this->app['router']->group($this->getRouteGroupParams(), function() use ($controller) {
			$this->app['router']->get('recipes', ['as' => 'recipes.index', 'uses' => $controller.'@index']);
		});
	}

	private function registerRecipesBindings()
	{
		$namespace = $this->getNamespaceRepositories();

		$this->app->bind(
			$namespace.'RecipesRepository',
			$namespace.'MongoRecipesRepository'
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