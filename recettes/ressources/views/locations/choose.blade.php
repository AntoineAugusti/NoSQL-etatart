<?php 
$pageTitle = trans('locations.chooseLocation');
$postRoute = 'recipes.store';
$submitKey = 'locations.setThisLocation';
?>
@extends('recipes.partials.addRecipeStep')

@section('form')
	<div class="form-group">
		<label for="ingredients" class="col-lg-2 control-label">{{ trans('recipes.location') }}</label>
		<div class="col-lg-10">
			{{ Form::select('location', $locations, null, ['class' => 'form-control chosen-select']) }}
			<span class="help-block">{{ trans('locations.chooseLocationHelp') }}</span>
		</div>
	</div>
@stop