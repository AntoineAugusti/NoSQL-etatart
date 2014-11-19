@if (Session::has('success'))
	<div class="animated flipInX alert alert-success alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<i class="mdi-action-done"></i> {{ Session::get('success') }}
	</div>
@endif