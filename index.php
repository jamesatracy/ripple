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

// 2) make a route collection
$routes = new Ripple\Routing\RouteCollection();

// 3) create routes
$action = new Ripple\Routing\RouteAction('hello_world');
$route = new Ripple\Routing\Route('GET', '/', $action);
$routes->addRoute($route);

// 4) create event dispatcher
$dispatcher = new Ripple\Events\Dispatcher();

// 5) subscribe route listener
$listener = new Ripple\Routing\RouteListener($routes);
$listener->subscribe($dispatcher);

// 6) create and start http engine
$http = new Ripple\HTTP\HttpEngine($dispatcher);
$http->handle($request);
?>