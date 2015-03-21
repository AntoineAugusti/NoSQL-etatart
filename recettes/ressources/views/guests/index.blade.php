@extends('layouts.page')

@section('pageTitle')
    {{ Lang::get('guests.ourGuests') }}
@stop

@section('content')
    <h1 class="recipes__big-title">{{ Lang::get('guests.ourGuests') }}</h1>

    @foreach ($guests as $guest)
        @include('guests.partials.single')
    @endforeach
@stop