<?php namespace Insa\Recipes;

use Illuminate\Support\ServiceProvider;
use Insa\Recipes\Controllers\RecipesController;

class RecipesServiceProvider extends ServiceProvider {

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $controller = RecipesController::class;

        $this->app['router']->get('/', [
            // Le nom de la route
            'as'   => 'recipes.index',
            // Définition du contrôleur et de la méthode
            'uses' => $controller.'@index'
        ]);
    }
}