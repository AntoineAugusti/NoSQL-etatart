<?php
if ($i % 2 != 0)
	$animation = 'fadeInLeft';
else
	$animation = 'fadeInRight';
?>
<div class="col-lg-6">				
	<div class="list-group-item animated {{ $animation }}">
		<!-- PRICE -->
		<div class="row-action-primary ingredients__price">
			<div class="">
				{{ $ingredient->present()->price }}
			</div>
		</div>
		<div class="row-content">
			<h4 class="list-group-item-heading">{{{ $ingredient->name }}}</h4>
			
			<!-- QUANTITY -->
			<p class="list-group-item-text ingredients__quantity-line">
				<i class="mdi-action-add-shopping-cart"></i> <span class="green">{{ $ingredient->quantity->quantity }}</span> <span class="gray">({{ $ingredient->present()->unit }})</span>
			</p>
		</div>
	</div>
	<div class="list-group-separator"></div>
</div>