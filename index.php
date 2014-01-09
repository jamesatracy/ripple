<?php
require __DIR__.'/src/Ripple/Loader/ClassLoader.php';

$loader = new Ripple\Loader\ClassLoader('Ripple', __DIR__.'/src', '.php');
$loader->register();

function hello_world($request)
{
	return 'Hello World';
}

// 1) make request
$request = new Ripple\HTTP\Request();
$request->fromGlobals();

// 2) create event dispatcher
$dispatcher = new Ripple\Events\Dispatcher();

// 3) create routes
$router = new Ripple\Routing\Router($dispatcher);
$router->get('/', 'hello_world');

// 4) create and start http engine
$http = new Ripple\HTTP\HttpEngine($dispatcher);
$http->handle($request);
?>