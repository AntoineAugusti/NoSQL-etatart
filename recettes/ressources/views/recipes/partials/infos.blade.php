<?php
if ( ! isset($totalTime))
	$totalTime = false;
?>

<div class="row recipes__recipe-info">		
	<!-- Type -->
	@if ($totalTime)
		<div class="col-xs-6 col-sm-4">
	@else
		<div class="col-xs-6 col-sm-3">
	@endif
		<i class="mdi-maps-restaurant-menu"></i> {{ $recipe->present()->type }}
	</div>

	<!-- Time -->
	@if ($totalTime)
		<!-- Total time -->
		<div class="col-xs-6 col-sm-4">
			<i class="mdi-image-timer" data-toggle="tooltip" data-placement="left" data-original-title="{{ Lang::get('recipes.totalTimeLabel' )}}"></i> {{ $recipe->present()->totalTime }}
		</div>
	@else
		<!-- Cooking and preparation time -->
		<div class="col-xs-6 col-sm-3">
			<i class="mdi-image-timer" data-toggle="tooltip" data-placement="left" data-original-title="{{ Lang::get('recipes.preparationTimeLabel' )}}"></i> {{ $recipe->present()->preparationTime }}
		</div>
		<div class="col-xs-6 col-sm-3">
			<i class="mdi-image-timer" data-toggle="tooltip" data-placement="left" data-original-title="{{ Lang::get('recipes.cookingTimeLabel') }}"></i> {{ $recipe->present()->cookingTime }}
		</div>
	@endif
	
	<!-- Rating	 -->
	@if ($totalTime)
		<div class="col-xs-6 col-sm-4">
	@else
		<div class="col-xs-6 col-sm-3">
	@endif
		{{ $recipe->present()->rating }}
	</div>		
</div>