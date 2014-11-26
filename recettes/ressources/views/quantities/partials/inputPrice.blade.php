<?php
// If we have some data, grab the corresponding element
$value = ! is_null($ingredientInCollection) ? $ingredientInCollection->price : null;
?>
<div class="form-group">
	<label for="price-{{ $ingredientSlug }}" class="col-lg-2 control-label">{{ trans('quantities.price') }}</label>
	<div class="col-lg-10">
		{{ Form::text('price-'.$ingredientSlug, $value, ['class' => 'form-control', 'required' => true]) }}
		<span class="help-block">{{ trans('quantities.priceForAUnit' )}}</span>
	</div>
</div>