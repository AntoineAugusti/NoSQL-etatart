@extends('layouts.page')

@section('content')
	<h1>{{ Lang::get('recipes.ourRecipes') }}</h1>
	
	@foreach ($recipes as $recipe)
		@include('recipes.partials.single')
	@endforeach
@stop