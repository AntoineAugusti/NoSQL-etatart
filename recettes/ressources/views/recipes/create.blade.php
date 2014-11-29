<?php
$pageTitle = trans('recipes.createRecipe');
$postRoute = 'recipes.redirect';
$submitKey = 'recipes.addMyRecipe';
?>
@extends('recipes.partials.addRecipeStep')

@section('form')
	<!-- TITLE -->
	<div class="form-group">
		<label for="title" class="col-lg-2 control-label">{{ trans('recipes.title') }}</label>
		<div class="col-lg-10">
			{{ Form::text('title', '', ['class' => 'form-control', 'required' => true]) }}
		</div>
	</div>

	<!-- RATING -->
	<div class="form-group">
		<label for="rating" class="col-lg-2 control-label">{{ trans('recipes.rating') }}</label>
		<div class="col-lg-10">
			<div id="display-stars"></div>
			{{ Form::hidden('rating', 5, ['id' => 'rating']) }}
		</div>
	</div>

	<!-- TYPE -->
	<div class="form-group">
		<label class="col-lg-2 control-label">{{ trans('recipes.type') }}</label>
		<div class="col-lg-10">
			@foreach ($possibleTypes as $element)
				<div class="radio radio-primary">
					<label>
					{{ Form::radio('type', $element, false) }}
					{{ trans('recipes.'.$element) }}
					</label>
				</div>
			@endforeach
		</div>
	</div>

	<!-- PREPARATION TIME -->
	<div class="form-group">
		<label class="col-lg-2 control-label">{{ trans('recipes.preparationTime') }}</label>
		<div class="col-lg-10">
			<div id="slider-preparation-time" class="slider shor"></div>
			<div id="display-preparation-time"></div>
			{{ Form::hidden('preparationTime', 10, ['id' => 'preparationTime']) }}
		</div>
	</div>

	<!-- COOKING TIME -->
	<div class="form-group">
		<label class="col-lg-2 control-label">{{ trans('recipes.cookingTimeInput') }}</label>
		<div class="col-lg-10">
			<div id="slider-cooking-time" class="slider shor"></div>
			<div id="display-cooking-time"></div>
			{{ Form::hidden('cookingTime', 20, ['id' => 'cookingTime']) }}
		</div>
	</div>

	<!-- DESCRIPTION -->
	<div class="form-group">
		<label for="description" class="col-lg-2 control-label">{{ trans('recipes.description') }}</label>
		<div class="col-lg-10">
			{{ Form::textarea('description', null, ['rows' => 3, 'class' => 'form-control']) }}
			<span class="help-block">{{ trans('recipes.descriptionHelp') }}</span>
		</div>
	</div>
@stop