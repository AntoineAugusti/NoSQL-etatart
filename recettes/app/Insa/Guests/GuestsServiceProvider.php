<?php namespace Insa\Guests;

use Illuminate\Support\ServiceProvider;
use Insa\Tools\Namespaces\NamespaceTrait;

class GuestsServiceProvider extends ServiceProvider {

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
		//
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerGuestsRoutes();
		$this->registerGuestsBindings();
	}

	private function registerGuestsRoutes()
	{
		$controller = 'GuestsController';

		$this->app['router']->group($this->getRouteGroupParams(), function() use ($controller) {
            $this->app['router']->get('/guests', ['as' => 'guests.index', 'uses' => $controller.'@index']);

			$this->app['router']->get('guests/create', ['as' => 'guests.create', 'uses' => $controller.'@create']);
			$this->app['router']->post('guests/store', ['as' => 'guests.store', 'uses' => $controller.'@store']);
		});
	}

	private function registerGuestsBindings()
	{
		$namespace = $this->getNamespaceRepositories();

		$this->app->bind(
			$namespace.'GuestsRepository',
			$namespace.'MongoGuestsRepository'
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