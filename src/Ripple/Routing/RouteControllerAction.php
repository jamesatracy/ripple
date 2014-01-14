<?php
namespace Ripple\Routing;

use \Ripple\HTTP\Request;

/**
 * Handles routing to a controller method. A controller is simpley a class
 * with action handler methods.
 *
 * @since 0.1.0
 * @author	James Tracy <james.a.tracy@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 */
class RouteControllerAction implements RouteActionInterface
{
    /** @var string */
    protected $controller = null;
    
    /** @var string */
    protected $method = null;
    
    /**
     * @constructor
     * @param string|array $callable Valid argument for call_user_func_array()
     */
    public function __construct($controller, $method)
    {
       $this->controller = $controller;
       $this->method = $method;
    }
    
    /**
     * Executes the action and returns the action's response.
     * This should be a valid Response object.
     * @since 0.1.0
     * @param Ripple\HTTP\Request $request The active request object
     * @param array $args Optional parameters to pass along with the action
     * @return Ripple\HTTP\Response
     * @throws \RuntimeException
     */
    public function run(Request $request, $args = array())
    {
        if($this->controller && $this->method) {
            $controller = $this->controller;
            $method = $this->method;
            
            // request is the first argument
            array_unshift($args, $request);
            
            $obj = new $controller;
            if(!method_exists($obj, $method)) {
                throw new \RuntimeException($controller.': Has no method '.$method);
            }
            $response = \call_user_func_array(array($obj, $method), $args);
            return $response;
        }
        throw new \RuntimeException('Invalid Route Action');
    }
};
?>