@extends('layouts.page')

@section('pageTitle')
    {{ Lang::get('events.createEvent') }}
@stop

@section('content')
    <div class="panel panel-default">
        <div class="panel-body">
            <h1 class="recipes__big-title"><i class="mdi-action-perm-contact-cal"></i> {{ Lang::get('events.createEvent') }}</h1>
            <!-- FORM ERRORS -->

            @include('layouts.partials.formErrors')
            <!-- FORM -->
            {{
                Form::open([
                    'route' => 'events.store',
                    'class' => 'form-horizontal'
                ]);
            }}
                <!-- NAME -->
                <div class="form-group">
                    <label for="name" class="col-lg-2 control-label">{{ trans('events.name') }}</label>
                    <div class="col-lg-10">
                        {{ Form::text('name', '', ['class' => 'form-control', 'required' => true]) }}
                    </div>
                </div>

                <!-- TYPE -->
                <div class="form-group">
                    <label class="col-lg-2 control-label">{{ trans('events.type') }}</label>
                    <div class="col-lg-10">
                        @foreach ($possibleTypes as $element)
                            <div class="radio radio-primary">
                                <label>
                                    {{ Form::radio('type', $element, false) }}
                                    {{ trans('events.'.$element) }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- DATE -->
                <div class="form-group">
                    <label for="date" class="col-lg-2 control-label">{{ trans('events.date') }}</label>
                    <div class="col-lg-10">
                        {{ Form::text('date', '', ['class' => 'form-control']) }}
                    </div>
                </div>

                <fieldset>
                    @yield('form')

                    <!-- SUBMIT -->
                    <div class="form-group">
                        <div class="col-lg-10 col-lg-offset-2">
                            <button type="submit" class="btn btn-primary">{{ trans('events.submit') }}</button>
                        </div>
                    </div>
                </fieldset>
            {{ Form::close() }}
        </div>
    </div>
@stop