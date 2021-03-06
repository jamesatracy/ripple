<?php
use Ripple\HTTP\Request;
use Ripple\Routing\Route;

require_once __DIR__.'/../src/Ripple/HTTP/Request.php';
require_once __DIR__.'/../src/Ripple/HTTP/Response.php';
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
		
		$route = new Route('POST', '/path/', '');
		$this->assertFalse($route->matches($request));
	}
	
	public function testBehavior_multipleMethods()
	{
	    $request = new Request();
        $request->setServer('SCRIPT_NAME', '/htdocs/index.php');
        $request->setServer('REQUEST_URI', '/htdocs/path/');
		$request->setServer('REQUEST_METHOD', 'GET');
		$request->setServer('HTTPS', false);
		
		$route = new Route(array('GET', 'POST', 'PUT'), '/path/', '');
		$this->assertTrue($route->matches($request));
		
		$request = new Request();
        $request->setServer('SCRIPT_NAME', '/htdocs/index.php');
        $request->setServer('REQUEST_URI', '/htdocs/path/');
		$request->setServer('REQUEST_METHOD', 'DELETE');
		$request->setServer('HTTPS', false);
		$route = new Route(array('GET', 'POST', 'PUT'), '/path/', '');
		$this->assertFalse($route->matches($request));
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
	
	public function testBehavior_matchedParameters()
	{
	    $request = new Request();
        $request->setServer('SCRIPT_NAME', '/htdocs/index.php');
        $request->setServer('REQUEST_URI', '/htdocs/path/12/');
		$request->setServer('REQUEST_METHOD', 'GET');
		$request->setServer('HTTPS', false);
		
		$route = new Route('GET', '/path/:id/', '');
		$this->assertTrue($route->matches($request));
		$params = $route->getMatchedParameters();
		$this->assertEquals(count($params), 1);
		$this->assertEquals($params[0], 12);
	}
	
	public function testBehavior_multipleMatchedParameters()
	{
	    $request = new Request();
        $request->setServer('SCRIPT_NAME', '/htdocs/index.php');
        $request->setServer('REQUEST_URI', '/htdocs/path/12/foo/');
		$request->setServer('REQUEST_METHOD', 'GET');
		$request->setServer('HTTPS', false);
		
		$route = new Route('GET', '/path/:id/:name/', '');
		$this->assertTrue($route->matches($request));
		$params = $route->getMatchedParameters();
		$this->assertEquals(count($params), 2);
		$this->assertEquals($params[0], 12);
		$this->assertEquals($params[1], 'foo');
	}
};
?>