@extends('layouts.page')

@section('pageTitle')
	{{ strip_tags(Lang::get('recipes.withRating', compact('rating'))) }}
@stop

@section('content')
	<h1 class="recipes__big-title">{{ Lang::get('recipes.withRating', compact('rating')) }}</h1>

	<div class="recipes__rating-container">
		<div class="row">
			@foreach ($notes as $note)
				<div class="col-md-4 recipes__rank-name">
					<a href="{{ URL::route('recipes.ranking', $note)}}">
						{{ trans('recipes.note'.ucfirst($note)) }}
					</a>
				</div>
			@endforeach
		</div>
	</div>

	@foreach ($recipes as $recipe)
		@include('recipes.partials.single', ['totalTime' => true])
	@endforeach

	<div class="paginator">
		{{ $paginator->links() }}
	</div>
@stop