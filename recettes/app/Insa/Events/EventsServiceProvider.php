<?php namespace Insa\Events;

use Illuminate\Support\ServiceProvider;
use Insa\Tools\Namespaces\NamespaceTrait;

class EventsServiceProvider extends ServiceProvider {

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
		$this->registerEventsRoutes();
		$this->registerEventsBindings();
	}

	private function registerEventsRoutes()
	{
		$controller = 'EventsController';

		$this->app['router']->group($this->getRouteGroupParams(), function() use ($controller) {
            $this->app['router']->get('/events', ['as' => 'events.index', 'uses' => $controller.'@index']);

			$this->app['router']->get('events/create', ['as' => 'events.create', 'uses' => $controller.'@create']);
			$this->app['router']->post('events/store', ['as' => 'events.store', 'uses' => $controller.'@store']);
		});
	}

	private function registerEventsBindings()
	{
		$namespace = $this->getNamespaceRepositories();

		$this->app->bind(
			$namespace.'EventsRepository',
			$namespace.'MongoEventsRepository'
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