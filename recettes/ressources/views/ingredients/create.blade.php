@extends('layouts.page')

@section('content')
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="row">
				<div class="col-lg-8 col-lg-offset-2">
					{{ Form::open(['route' => 'recipes.ingredients.store', 'class' => 'form-horizontal']) }}
					<fieldset>
						<!-- INGREDIENTS -->
						<div class="form-group">
							<label for="ingredients" class="col-lg-2 control-label">Ingredients</label>
							<div class="col-lg-10">
								{{ Form::select('ingredients[]', $ingredients, null, ['multiple' => true, 'class' => 'form-control chosen-select'])}}
							</div>
						</div>

						<!-- SUBMIT -->
						<div class="form-group">
							<div class="col-lg-10 col-lg-offset-2">
								<button type="submit" class="btn btn-primary">{{ trans('recipes.addMyRecipe') }}</button>
							</div>
						</div>
					</fieldset>
					{{ Form::close() }}
				</div>
			</div>
		</div>
	</div>
@stop