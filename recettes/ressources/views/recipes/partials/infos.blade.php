<div class="row recipes__recipe-info">		
	<div class="col-xs-6 col-sm-4">
		<i class="mdi-maps-restaurant-menu"></i> {{ $recipe->present()->type }}
	</div>
	<div class="col-xs-6 col-sm-4">
		<i class="mdi-image-timer"></i> {{ $recipe->present()->cookingTime }}
	</div>
	<div class="col-xs-12 col-sm-4">
		{{ $recipe->present()->rating }}
	</div>		
</div>