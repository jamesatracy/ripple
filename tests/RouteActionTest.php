<?php
use Ripple\HTTP\Request;
use Ripple\Routing\RouteAction;

require_once __DIR__.'/../src/Ripple/HTTP/Request.php';
require_once __DIR__.'/../src/Ripple/Routing/RouteActionInterface.php';
require_once __DIR__.'/../src/Ripple/Routing/RouteAction.php';

function route_action_test_cb($request)
{
    return true;    
}

/**
 * PHPUnit Test suite for RouteAction class
 * 
 */
class RouteActionTest extends PHPUnit_Framework_TestCase
{
    public function objectCallback($request)
    {
        return true;    
    }
    
    public static function staticCallback($request)
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
    
	public function testBehavior_globalCallback()
	{
	    $request = new Request();
	    $action = new RouteAction('route_action_test_cb');
	    $this->assertTrue($action->run($request));
	}
	
	public function testBehavior_objectCallback()
	{
	    $request = new Request();
	    $action = new RouteAction(array($this, 'objectCallback'));
	    $this->assertTrue($action->run($request));
	}
	
	public function testBehavior_staticCallback()
	{
	    $request = new Request();
	    $action = new RouteAction(array('RouteActionTest', 'staticCallback'));
	    $this->assertTrue($action->run($request));
	}
	
	public function testBehavior_argumentTestCallback()
	{
	    $request = new Request();
	    $action = new RouteAction(array($this, 'argumentTestCallback'));
	    $this->assertTrue($action->run($request, array(1, 2, 3)));
	}
};
?>