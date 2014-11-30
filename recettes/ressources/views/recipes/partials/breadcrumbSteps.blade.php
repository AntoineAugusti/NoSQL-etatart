<?php
$routes = ['recipes.create', 'recipes.ingredients.create', 'recipes.ingredients.quantities.create', 'recipes.location.create'];
$translations = ['recipes.createRecipe', 'recipes.chooseYourIngredients', 'recipes.chooseIngredientsQuantities', 'recipes.chooseLocation'];
?>
<ul class="breadcrumb recipes__breadcrumb-steps">
	<div class="row">
		@foreach ($routes as $i => $route)
			<div class="col-sm-3">
				@if (Route::currentRouteName() == $route)
					<li class="active">
						<i class="mdi-navigation-chevron-right"></i> {{ trans($translations[$i]) }}
					</li>
				@else
					<li>
						{{ trans($translations[$i]) }}
					</li>
				@endif
			</div>
		@endforeach
	</div>
</ul>