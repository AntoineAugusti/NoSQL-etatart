@if ($errors->has())
	<div class="animated lightSpeedIn alert alert-warning alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<h4><i class="mdi-alert-warning"></i> {{ trans('app.formError') }}</h4>
		<ul>
			@foreach ($errors->all() as $error)
				<li>{{$error}}</li>
			@endforeach
		</ul>
	</div>
@endif