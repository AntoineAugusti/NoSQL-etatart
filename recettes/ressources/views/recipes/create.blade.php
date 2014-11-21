@extends('layouts.page')

@section('pageTitle')
	{{ Lang::get('recipes.createRecipe') }}
@stop

@section('content')
	<div class="panel panel-default animated fadeInUp">
		<div class="panel-body">
			<h1 class="recipes__big-title"><i class="mdi-maps-restaurant-menu"></i> {{ Lang::get('recipes.createRecipe') }}</h1>
			<div class="row">
				<div class="col-lg-8 col-lg-offset-2">				
				{{
					Form::open([
						'route' => 'recipes.create',
						'class' => 'form-horizontal'
					]);
				}}
					<fieldset>
						<!-- TITLE -->
						<div class="form-group">
							<label for="title" class="col-lg-2 control-label">{{ trans('recipes.title') }}</label>
							<div class="col-lg-10">
								{{ Form::text('title', '', ['class' => 'form-control', 'required' => true]) }}
							</div>
						</div>

						<!-- RATING -->
						<div class="form-group">
							<label for="rating" class="col-lg-2 control-label">{{ trans('recipes.rating') }}</label>
							<div class="col-lg-10">
								<div id="slider-rating" class="slider shor"></div>
								<div id="display-stars"></div>
								{{ Form::hidden('rating', 0, ['id' => 'rating']) }}
							</div>
						</div>

						<!-- TYPE -->
						<div class="form-group">
							<label class="col-lg-2 control-label">{{ trans('recipes.type') }}</label>
							<div class="col-lg-10">
								@foreach ($possibleTypes as $element)
									<div class="radio radio-primary">
										<label>
										{{ Form::radio('type', $element, false) }}
										{{ Lang::get('recipes.'.$element) }}
										</label>
									</div>
								@endforeach
							</div>
						</div>

						<!-- PREPARATION TIME -->
						<div class="form-group">
							<label class="col-lg-2 control-label">{{ trans('recipes.preparationTime') }}</label>
							<div class="col-lg-10">
								<div id="slider-preparation-time" class="slider shor"></div>
								<div id="display-preparation-time"></div>
								{{ Form::hidden('preparationTime', 0, ['id' => 'preparationTime']) }}
							</div>
						</div>

						<!-- COOKING TIME -->
						<div class="form-group">
							<label class="col-lg-2 control-label">{{ trans('recipes.cookingTimeInput') }}</label>
							<div class="col-lg-10">
								<div id="slider-cooking-time" class="slider shor"></div>
								<div id="display-cooking-time"></div>
								{{ Form::hidden('cookingTime', 0, ['id' => 'cookingTime']) }}
							</div>
						</div>
						
						<!-- DESCRIPTION -->
						<div class="form-group">
							<label for="description" class="col-lg-2 control-label">{{ trans('recipes.description') }}</label>
							<div class="col-lg-10">
								{{ Form::textarea('description', null, ['rows' => 3, 'class' => 'form-control']) }}
								<span class="help-block">{{ trans('recipes.descriptionHelp') }}</span>
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