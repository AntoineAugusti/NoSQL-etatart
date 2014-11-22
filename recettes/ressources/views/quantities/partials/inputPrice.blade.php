<div class="form-group">
	<label for="price-{{ $ingredientSlug }}" class="col-lg-2 control-label">{{ trans('quantities.price') }}</label>
	<div class="col-lg-10">
		{{ Form::text('price-'.$ingredientSlug, '', ['class' => 'form-control', 'required' => true]) }}
		<span class="help-block">{{ trans('quantities.priceForAUnit' )}}</span>
	</div>
</div>