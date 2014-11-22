<div class="form-group">
	<label for="quantity-{{ $ingredientSlug }}" class="col-lg-2 control-label">{{ trans('quantities.quantity') }}</label>
	<div class="col-lg-10">
		{{ Form::text('quantity-'.$ingredientSlug, '', ['class' => 'form-control', 'required' => true]) }}
		<span class="help-block">{{ trans('quantities.quantityNeeded') }}</span>
	</div>
</div>