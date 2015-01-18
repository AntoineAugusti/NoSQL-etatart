<?php

// Bind de foo à la classe FooBar à l'aide d'une Closure
App::bind('foo', function($app)
{
    return new FooBar;
});

// $value sera un objet de type Foo
$value = App::make('foo');