<div class="panel panel-default animated fadeInUp">
    <div class="panel-heading recipes__title">
            {{ $event->name }}
    </div>
    <div class="panel-body">

        <div class="row recipes__recipe-info">
            <div class="col-xs-6">
                <i class="mdi-action-description" data-toggle="tooltip" data-placement="left" data-original-title="{{ Lang::get('events.type' )}}"></i>
                {{ $event->present()->type() }}
            </div>

            <div class="col-xs-6">
                <i class="mdi-action-today" data-toggle="tooltip" data-placement="left" data-original-title="{{ Lang::get('events.phoneNumber' )}}"></i>
                {{ $event->present()->date() }}
            </div>
        </div>

        @if($event->hasGuests())
            <p class="recipes__description">
                <i class="mdi-social-group"></i> <span class="green">{{ Lang::get('events.guests') }}:</span> <span class="gray">{{ implode(', ', $event->guests->lists('name')) }}</span>
            </p>
        @endif
    </div>
</div>