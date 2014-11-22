<ul class="breadcrumb recipes__breadcrumb-steps">
	<div class="row">
		<div class="col-sm-4">
			@if (Route::currentRouteName() == 'recipes.create')
				<li class="active">
					<i class="mdi-navigation-chevron-right"></i> {{ trans('recipes.createRecipe') }}
				</li>
			@else
				<li>
					{{ trans('recipes.createRecipe') }}
				</li>
			@endif
		</div>
		<div class="col-sm-4">
			@if (Route::currentRouteName() == 'recipes.ingredients.create')
				<li class="active">
					<i class="mdi-navigation-chevron-right"></i> {{ trans('recipes.chooseYourIngredients') }}
				</li>
			@else
				<li>
					{{ trans('recipes.chooseYourIngredients') }}
				</li>
			@endif
		</div>
		<div class="col-sm-4">
			@if (Route::currentRouteName() == 'recipes.ingredients.quantities.create')
				<li class="active">
					<i class="mdi-navigation-chevron-right"></i> {{ trans('recipes.chooseIngredientsQuantities') }}
				</li>
			@else
				<li>
					{{ trans('recipes.chooseIngredientsQuantities') }}
				</li>
			@endif
		</div>
	</div>
</ul>