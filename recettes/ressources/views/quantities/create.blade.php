<?php 
$pageTitle = trans('recipes.chooseYourQuantities');
$postRoute = 'recipes.ingredients.quantities.redirect';
$submitKey = 'recipes.submitTheseQuantities';
$bigForm   = true;
?>
@extends('recipes.partials.addRecipeStep')

@section('form')
	@foreach ($ingredients->chunk(2) as $ings)
		<div class="row quantities__row">
			@foreach ($ings as $ingredient)
				<?php 
				$ingredientSlug = $ingredientsSlug[$ingredient];
				$ingredientInCollection = $existingIngredients[$ingredientSlug];
				?>
				<div class="col-lg-6">
					<h4 class="orange">{{ $ingredient }}</h4>
					@include('quantities.partials.radiosType')
					@include('quantities.partials.inputPrice')
					@include('quantities.partials.inputQuantity')
				</div>
			@endforeach
		</div>
	@endforeach
@stop