@if (Session::has('warning'))
	<div class="animated lightSpeedIn alert alert-warning alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<h4 class="flashMessages__warning-title">
			<i class="mdi-alert-warning"></i> {{ Session::get('warning') }}
		</h4>
	</div>
@endif