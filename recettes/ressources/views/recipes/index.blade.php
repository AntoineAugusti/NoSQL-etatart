@extends('layouts.page')

@section('pageTitle')
	{{ Lang::get('recipes.ourRecipes') }}
@stop

@section('content')
	<h1 class="recipes__big-title">{{ Lang::get('recipes.ourRecipes') }}</h1>
	
	@foreach ($recipes as $recipe)
		@include('recipes.partials.single', ['totalTime' => true])
	@endforeach

	<div class="paginator">
		{{ $paginator->links() }}
	</div>
@stop