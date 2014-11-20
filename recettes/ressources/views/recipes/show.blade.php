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
@stop