<div class="panel panel-default">
	<div class="panel-body">
		<div class="list-group">
			<div class="list-group-item">
				<!-- ICON FOR TYPE -->
				<div class="row-action-primary">
					{{ $location->present()->iconType() }}
				</div>
				<div class="row-content">
					<h4 class="locations__name list-group-item-heading">{{ $location->name }}</h4>
					
					<!-- NAME, DESCRIPTION, DATE -->
					<p class="list-group-item-text">
						{{{ $location->description }}}
						@if ($location->hasDate())
							<span class="locations__date">{{ $location->present()->date }}</span>
						@endif
					</p>
				</div>
			</div>
		</div>
	</div>
</div>