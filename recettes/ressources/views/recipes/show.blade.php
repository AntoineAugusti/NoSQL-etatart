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
@stop