@extends('layouts.page')

@section('pageTitle')
	{{ $pageTitle }}
@stop

@section('content')
	@include('recipes.partials.breadcrumbSteps')

	<div class="panel panel-default">
		<div class="panel-body">
			<h1 class="recipes__big-title"><i class="mdi-maps-restaurant-menu"></i> {{ $pageTitle }}</h1>
			<div class="row">
				@if (isset($bigForm) AND $bigForm)
					<div class="col-lg-10 col-lg-offset-1">
				@else
					<div class="col-lg-8 col-lg-offset-2">
				@endif
					<!-- FORM ERRORS -->
					
					@include('layouts.partials.formErrors')				
					<!-- FORM -->
					{{
						Form::open([
							'route' => $postRoute,
							'class' => 'form-horizontal'
						]);
					}}
						<fieldset>
							@yield('form')
							
							<!-- SUBMIT -->
							<div class="form-group">
								<div class="col-lg-10 col-lg-offset-2">
									<button type="submit" class="btn btn-primary">{{ trans($submitKey) }}</button>
								</div>
							</div>
						</fieldset>
					{{ Form::close() }}
				</div>
			</div>
		</div>
	</div>
@stop