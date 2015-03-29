@extends('layouts.page')

@section('pageTitle')
    {{ Lang::get('events.events') }}
@stop

@section('content')
    <h1 class="recipes__big-title">{{ Lang::get('events.events') }}</h1>

    @foreach ($events as $event)
        @include('events.partials.single')
    @endforeach
@stop