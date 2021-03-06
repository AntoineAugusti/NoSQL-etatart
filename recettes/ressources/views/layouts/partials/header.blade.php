<!DOCTYPE html>
<html>
<head>
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Crete+Round|Roboto:400,300,500' rel='stylesheet' type='text/css'>
	<link href="/assets/css/styles.min.css" rel="stylesheet">
	<link href="/assets/css/datepicker.css" rel="stylesheet">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>@yield('pageTitle')</title>
</head>
<body>
	<div class="navbar navbar-default navbar-fixed-top">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="{{ URL::route('recipes.index') }}">INSA</a>
			</div>
			<div class="navbar-collapse collapse navbar-responsive-collapse">
				<ul class="nav navbar-nav">
					@foreach (['recipes.index', 'recipes.create', 'recipes.ranking'] as $route)
						<?php
						$active = (Route::currentRouteName() == $route) ? 'class="active"' : '';
						?>
						<li {{ $active }}><a href="{{ URL::route($route) }}">{{ Lang::get('menu.'.$route) }}</a></li>
					@endforeach
					<li class="dropdown">
						<a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">{{ Lang::get('menu.guests') }} <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="{{ URL::route('guests.index') }}">{{ Lang::get('menu.guests.index') }}</a></li>
							<li><a href="{{ URL::route('guests.create') }}">{{ Lang::get('menu.guests.create') }}</a></li>
							<li><a href="javascript:void(0)">{{ Lang::get('menu.guests.invite') }}</a></li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">{{ Lang::get('menu.events') }} <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="{{ URL::route('events.index') }}">{{ Lang::get('menu.events.index') }}</a></li>
							<li><a href="{{ URL::route('events.create') }}">{{ Lang::get('menu.events.create') }}</a></li>
						</ul>
					</li>
				</ul>
				<form class="navbar-form navbar-left">
					<input type="text" class="form-control col-lg-8" placeholder="Search">
				</form>
				<ul class="nav navbar-nav navbar-right">
					<li><a href="javascript:void(0)">Link</a></li>
					<li class="dropdown">
						<a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="javascript:void(0)">Action</a></li>
							<li><a href="javascript:void(0)">Another action</a></li>
							<li><a href="javascript:void(0)">Something else here</a></li>
							<li class="divider"></li>
							<li><a href="javascript:void(0)">Separated link</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</div>