<div class="panel-body">
    <!-- FORM ERRORS -->
    @include('layouts.partials.formErrors')

    <fieldset>
        <!-- FORM -->
        {{
            Form::open([
                'route' => 'events.store',
                'class' => 'form-horizontal'
            ]);
        }}

            <!-- ASSOCIATE EVENTS -->
            <div class="form-group">
                <label for="events" class="col-lg-2 control-label">{{ trans('events.associate') }}</label>
                <div class="col-lg-10">
                    {{ Form::select('events[]', $allEvents, null, ['class' => 'form-control chosen-select', 'data-placeholder' => trans('events.associateHelpInput') ]) }}
                    <span class="help-block">{{ trans('events.associateHelp') }}</span>
                </div>
            </div>

            <!-- SUBMIT -->
            <div class="form-group">
                <div class="col-lg-10 col-lg-offset-2">
                    <button type="submit" class="btn btn-primary">{{ trans('events.submitAssociate') }}</button>
                </div>
            </div>
        {{ Form::close() }}
    </fieldset>
</div>