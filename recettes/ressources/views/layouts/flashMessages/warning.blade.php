@if (Session::has('warning'))
	<div class="animated lightSpeedIn alert alert-warning alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<i class="mdi-alert-warning"></i> {{ Session::get('warning') }}
	</div>
@endif