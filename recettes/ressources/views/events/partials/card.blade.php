<?php
if ($i % 2 != 0)
    $animation = 'fadeInLeft';
else
    $animation = 'fadeInRight';
?>
<div class="col-lg-6">
    <div class="list-group-item animated {{ $animation }}">
        <!-- PRICE -->
        <div class="row-action-primary ingredients__price">
            <div class="">
                {{ $event->guests->count() }} {{ Lang::choice('events.guestsCount', $event->guests->count()) }}
            </div>
        </div>
        <div class="row-content">
            <h4 class="list-group-item-heading">{{{ $event->name }}}</h4>

            <!-- GUESTS -->
            @if($event->hasGuests())
                <p class="list-group-item-text ingredients__quantity-line">
                    <i class="mdi-social-group"></i> <span class="green">{{ Lang::get('events.guests') }}</span> <span class="gray">({{ implode(', ', $event->guests->lists('name')) }})</span>
                </p>
            @endif
        </div>
    </div>
    @if (! $isLast)
        <div class="list-group-separator"></div>
    @endif
</div>