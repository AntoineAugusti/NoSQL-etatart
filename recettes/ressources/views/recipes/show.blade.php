@extends('layouts.page')

@section('pageTitle')
{{{ $recipe->title }}}
@stop

@section('content')
	<ul class="breadcrumb">
		<li><a href="{{ URL::previous() }}">Recipes</a></li>
		<li class="active">{{{ $recipe->title }}}</li>
	</ul>
	@include('recipes.partials.single')
	
	<h2>{{ Lang::get('recipes.listOfIngredients') }}</h2>
	@include('ingredients.index', ['ingredients' => $recipe->ingredients])
@stop