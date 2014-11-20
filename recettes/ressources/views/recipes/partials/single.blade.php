<div class="panel panel-default">
	<div class="panel-heading">{{ $recipe->title }}</div>
	<div class="panel-body">
		<div class="row recipes__recipe-info">		
			<div class="col-sm-4">
				<i class="mdi-maps-restaurant-menu"></i> {{ $recipe->present()->type }}
			</div>
			<div class="col-sm-4">
				<i class="mdi-image-timer"></i> {{ $recipe->present()->cookingTime }}
			</div>
			<div class="col-sm-4">
				{{ $recipe->present()->rating }}
			</div>		
		</div>
	</div>
</div>