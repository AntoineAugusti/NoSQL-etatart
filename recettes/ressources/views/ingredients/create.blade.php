@extends('layouts.page')

@section('pageTitle')
	{{ trans('recipes.chooseYourIngredients') }}
@stop

@section('content')
	@include('recipes.partials.breadcrumbSteps')
	
	<div class="panel panel-default">
		<div class="panel-body">
			<h1 class="recipes__big-title"><i class="mdi-maps-restaurant-menu"></i> {{ trans('recipes.chooseYourIngredients') }}</h1>
			<div class="row">
				<div class="col-lg-8 col-lg-offset-2">
					{{ Form::open(['route' => 'recipes.ingredients.store', 'class' => 'form-horizontal']) }}
					<fieldset>
						<!-- INGREDIENTS -->
						<div class="form-group">
							<label for="ingredients" class="col-lg-2 control-label">{{ trans('recipes.ingredients') }}</label>
							<div class="col-lg-10">
								{{ Form::select('ingredients[]', $ingredients, null, ['multiple' => true, 'class' => 'form-control chosen-select', 'data-placeholder' => trans('recipes.ingredientsHelpInput') ]) }}
								<span class="help-block">{{ trans('recipes.ingredientsHelp') }}</span>
							</div>
						</div>

						<!-- SUBMIT -->
						<div class="form-group">
							<div class="col-lg-10 col-lg-offset-2">
								<button type="submit" class="btn btn-primary">{{ trans('recipes.addTheseIngredients') }}</button>
							</div>
						</div>
					</fieldset>
					{{ Form::close() }}
				</div>
			</div>
		</div>
	</div>
@stop