<?php
$i = 1;
$lastChunk = $ingredients->chunk(2)->last();
?>
<div class="panel panel-default">
	<div class="panel-body">
		@foreach ($ingredients->chunk(2) as $ings)
			<?php $isLast = $ings == $lastChunk; ?>
			<div class="list-group">
				<div class="row">
					@foreach ($ings as $ingredient)
						@include('ingredients.partials.single', compact('i', 'isLast'))
						<?php $i++ ?>
					@endforeach
				</div>
			</div>
		@endforeach
	</div>
</div>