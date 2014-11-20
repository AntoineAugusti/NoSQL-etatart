<div class="panel panel-default">
	<div class="panel-heading recipes__title">
		<a href="{{ route('recipes.show', $recipe->slug) }}">
			{{ $recipe->title }}
		</a>
	</div>
	<div class="panel-body">
		<!-- Type, cooking time and rating -->
		@include('recipes.partials.infos')
		
		<!-- Description -->
		<div class="recipes__description">
			{{{ $recipe->description }}}
		</div>
	</div>
</div>