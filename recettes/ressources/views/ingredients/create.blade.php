<?php 
$pageTitle = trans('recipes.chooseYourIngredients');
$postRoute = 'recipes.ingredients.redirect';
$submitKey = 'recipes.addTheseIngredients';
?>
@extends('recipes.partials.addRecipeStep')

@section('form')
	<!-- INGREDIENTS -->
	<div class="form-group">
		<label for="ingredients" class="col-lg-2 control-label">{{ trans('recipes.ingredients') }}</label>
		<div class="col-lg-10">
			{{ Form::select('ingredients[]', $ingredients, null, ['multiple' => true, 'class' => 'form-control chosen-select', 'data-placeholder' => trans('recipes.ingredientsHelpInput') ]) }}
			<span class="help-block">{{ trans('recipes.ingredientsHelp') }}</span>
		</div>
	</div>
@stop