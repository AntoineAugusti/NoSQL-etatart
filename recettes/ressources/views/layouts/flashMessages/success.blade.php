@if (Session::has('success'))
	<div class="animated flipInX alert alert-success alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<h4>
			<i class="mdi-action-done"></i> {{ Session::get('success') }}
		</h4>
	</div>
@endif