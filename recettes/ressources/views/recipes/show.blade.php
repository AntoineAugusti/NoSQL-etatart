@extends('layouts.page')

@section('pageTitle')
{{{ $recipe->title }}}
@stop

@section('content')
	<!-- BREADCRUMB -->
	@include('recipes.partials.breadcrumbShow')

	<!-- RECIPE -->
	@include('recipes.partials.single')
	
	<!-- LIST OF INGREDIENTS -->
	<h2 class="ingredients__title">
		{{ Lang::get('recipes.listOfIngredients') }}
		<div class="pull-right orange">
			{{ $recipe->present()->totalPrice() }}
		</div>
	</h2>
	@include('ingredients.index', ['ingredients' => $recipe->ingredients])

	<!-- LOCATION -->
	@if ($recipe->hasLocation())
		<h2 class="locations__title">{{ trans('recipes.location') }}</h2>
		@include('locations.partials.single', ['location' => $recipe->location]);
	@endif
@stop