<div class="panel panel-default">
	<div class="panel-body">
		@foreach ($ingredients->chunk(2) as $ings)
			<div class="list-group">
				<div class="row">
					@foreach ($ings as $ingredient)
						@include('ingredients.partials.single')
					@endforeach
				</div>
			</div>
		@endforeach
	</div>
</div>