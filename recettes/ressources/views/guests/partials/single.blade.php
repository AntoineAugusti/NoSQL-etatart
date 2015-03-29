<div class="panel panel-default animated fadeInUp">
    <div class="panel-heading recipes__title">
            {{ $guest->name }}
    </div>
    <div class="panel-body">

        <div class="row recipes__recipe-info">
            <div class="col-xs-6">
                <i class="mdi-action-perm-contact-cal" data-toggle="tooltip" data-placement="left" data-original-title="{{ Lang::get('guests.type' )}}"></i>
                {{ $guest->present()->type() }}
            </div>

            <div class="col-xs-6">
                <i class="mdi-action-perm-phone-msg" data-toggle="tooltip" data-placement="left" data-original-title="{{ Lang::get('guests.phoneNumber' )}}"></i>
                {{ $guest->present()->phoneNumber() }}
            </div>
        </div>
    </div>
</div>