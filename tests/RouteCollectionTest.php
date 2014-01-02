<?php
use Ripple\HTTP\Request;
use Ripple\Routing\Route;
use Ripple\Routing\RouteAction;
use Ripple\Routing\RouteCollection;

require_once __DIR__.'/../src/Ripple/HTTP/HttpStatus.php';
require_once __DIR__.'/../src/Ripple/HTTP/Request.php';
require_once __DIR__.'/../src/Ripple/HTTP/Response.php';
require_once __DIR__.'/../src/Ripple/Routing/Route.php';
require_once __DIR__.'/../src/Ripple/Routing/RouteActionInterface.php';
require_once __DIR__.'/../src/Ripple/Routing/RouteAction.php';
require_once __DIR__.'/../src/Ripple/Routing/RouteCollection.php';


function global_callback($request)
{
    return 'Hello World';    
}

/**
 * PHPUnit Test suite for RouteCollection class
 * 
 */
class RouteCollectionTest extends PHPUnit_Framework_TestCase
{
	public function testMethod_match()
	{
	    $collection = new RouteCollection();
	    
		$request = new Request();
        $request->setServer('SCRIPT_NAME', '/htdocs/index.php');
        $request->setServer('REQUEST_URI', '/htdocs/path/');
		$request->setServer('REQUEST_METHOD', 'GET');
		$request->setServer('HTTPS', false);
		
		$action = new RouteAction('global_callback');
		
		$route = new Route('GET', '/path/', $action);
		$collection->addRoute($route);
		
		$resp = $collection->match($request);
		$this->assertTrue($resp !== false);
        $this->assertEquals($resp->body(), 'Hello World');
	}
	
	public function testBehavior_noMatches()
	{
	    $collection = new RouteCollection();
	    
		$request = new Request();
        $request->setServer('SCRIPT_NAME', '/htdocs/index.php');
        $request->setServer('REQUEST_URI', '/htdocs/path/');
		$request->setServer('REQUEST_METHOD', 'GET');
		$request->setServer('HTTPS', false);
		
		$action = new RouteAction('global_callback');
		
		$route = new Route('POST', '/path/', $action);
		$collection->addRoute($route);
		
		$resp = $collection->match($request);
		$this->assertFalse($resp);
	}
};
?>