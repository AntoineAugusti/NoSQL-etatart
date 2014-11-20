<?php
if ($i % 2 != 0)
	$animation = 'fadeInLeft';
else
	$animation = 'fadeInRight';
?>
<div class="col-lg-6">				
	<div class="list-group-item animated {{ $animation }}">
		<div class="row-action-primary ingredients__price">
			<div class="">
				{{ $ingredient->present()->price }}
			</div>
		</div>
		<div class="row-content">
			<h4 class="list-group-item-heading">{{ $ingredient->name }}</h4>
			<p class="list-group-item-text">{{ Lang::get('recipes.priceGiven') }} {{ $ingredient->present()->unit }}</p>
		</div>
	</div>
	<div class="list-group-separator"></div>
</div>