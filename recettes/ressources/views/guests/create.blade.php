@extends('layouts.page')

@section('pageTitle')
    {{ Lang::get('guests.addGuest') }}
@stop

@section('content')
    <div class="panel panel-default">
        <div class="panel-body">
            <h1 class="recipes__big-title"><i class="mdi-action-perm-contact-cal"></i> {{ Lang::get('guests.addGuest') }}</h1>
            <!-- FORM ERRORS -->

            @include('layouts.partials.formErrors')
            <!-- FORM -->
            {{
                Form::open([
                    'route' => 'guests.store',
                    'class' => 'form-horizontal'
                ]);
            }}
                <!-- NAME -->
                <div class="form-group">
                    <label for="name" class="col-lg-2 control-label">{{ trans('guests.name') }}</label>
                    <div class="col-lg-10">
                        {{ Form::text('name', '', ['class' => 'form-control', 'required' => true]) }}
                    </div>
                </div>

                <!-- PHONE NUMBER -->
                <div class="form-group">
                    <label for="phoneNumber" class="col-lg-2 control-label">{{ trans('guests.phoneNumber') }}</label>
                    <div class="col-lg-10">
                        {{ Form::text('phoneNumber', '', ['class' => 'form-control', 'required' => true]) }}
                    </div>
                </div>

                <!-- TYPE -->
                <div class="form-group">
                    <label class="col-lg-2 control-label">{{ trans('guests.type') }}</label>
                    <div class="col-lg-10">
                        @foreach ($possibleTypes as $element)
                            <div class="radio radio-primary">
                                <label>
                                    {{ Form::radio('type', $element, false) }}
                                    {{ trans('guests.'.$element) }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <fieldset>
                    @yield('form')

                    <!-- SUBMIT -->
                    <div class="form-group">
                        <div class="col-lg-10 col-lg-offset-2">
                            <button type="submit" class="btn btn-primary">{{ trans('guests.submit') }}</button>
                        </div>
                    </div>
                </fieldset>
            {{ Form::close() }}
        </div>
    </div>
@stop