<?php
// If we have some data, grab the corresponding element
$toCheck = ! is_null($ingredientInCollection) ? $ingredientInCollection->unit : null;
?>
<!-- TYPE -->
<div class="form-group">
	<label class="col-lg-2 control-label">{{ trans('quantities.type') }}</label>
	<div class="col-lg-10">
		@foreach ($possibleTypes as $element)
			<div class="radio radio-primary">
				<label>
				{{ Form::radio('unit-'.$ingredientSlug, $element, $toCheck) }}
				{{ trans('quantities.'.$element) }}
				</label>
			</div>
		@endforeach
	</div>
</div>