<?php
use Ripple\HTTP\Request;
use Ripple\Routing\RouteControllerAction;

require_once __DIR__.'/../src/Ripple/HTTP/Request.php';
require_once __DIR__.'/../src/Ripple/Routing/RouteActionInterface.php';
require_once __DIR__.'/../src/Ripple/Routing/RouteControllerAction.php';

class RouteControllerActionTestController
{
    public function route_action_test_cb($request)
    {
        return true;
    }
    
    public function argumentTestCallback()
    {
        if(func_num_args() !== 4) {
            return false;
        }
        
        $args = func_get_args();
        if(get_class($args[0]) !== 'Ripple\HTTP\Request') {
            return false;
        }
        
        return true;
    }
}

/**
 * PHPUnit Test suite for RouteControllerAction class
 * 
 */
class RouteControllerActionTest extends PHPUnit_Framework_TestCase
{
	public function testBehavior_callback()
	{
	    $request = new Request();
	    $action = new RouteControllerAction('RouteControllerActionTestController', 'route_action_test_cb');
	    $this->assertTrue($action->run($request));
	}
	
	public function testBehavior_argumentTestCallback()
	{
	    $request = new Request();
	    $action = new RouteControllerAction('RouteControllerActionTestController', 'argumentTestCallback');
	    $this->assertTrue($action->run($request, array(1, 2, 3)));
	}
};
?>