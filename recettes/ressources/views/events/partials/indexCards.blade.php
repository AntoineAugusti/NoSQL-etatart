<?php
$i = 1;
$lastChunk = $events->chunk(2)->last();
?>
<div class="panel panel-default">
    <div class="panel-body">
        @foreach ($events->chunk(2) as $twoEvents)
            <?php $isLast = $twoEvents == $lastChunk; ?>
            <div class="list-group">
                <div class="row">
                    @foreach ($twoEvents as $event)
                        @include('events.partials.card')
                        <?php $i++ ?>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    @include('events.partials.associate', ['events' => $recipe->events])

</div>