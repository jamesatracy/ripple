<?php
use Ripple\Routing\Route;

require_once __DIR__.'/../src/Ripple/Routing/Route.php';

/**
 * PHPUnit Test suite for Route class
 * 
 */
class RouteTest extends PHPUnit_Framework_TestCase
{
	public function testMethod_matches()
	{
		$request = new Request();
        $request->setServer('SCRIPT_NAME', '/htdocs/index.php');
        $request->setServer('REQUEST_URI', '/htdocs/path/');
		$request->setServer('REQUEST_METHOD', 'GET');
		$request->setServer('HTTPS', false);
		
		$route = new Route('GET', '/path/', '');
		$this->assertTrue($route->matches($request));
	}
	
	public function testBehavior_secureRoute()
	{
		$request = new Request();
        $request->setServer('SCRIPT_NAME', '/htdocs/index.php');
        $request->setServer('REQUEST_URI', '/htdocs/path/');
		$request->setServer('REQUEST_METHOD', 'GET');
		$request->setServer('HTTPS', true);
		
		$route = new Route('GET', '/path/', '', true);
		$this->assertTrue($route->matches($request));
		
		$request->setServer('HTTPS', false);
		$route = new Route('GET', '/path/', '', true);
		$this->assertFalse($route->matches($request));
	}
};
?>