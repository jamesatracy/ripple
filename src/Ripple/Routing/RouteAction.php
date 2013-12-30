<?php
namespace Ripple\Routing;

use \Ripple\HTTP\Request;
use \Ripple\Routing\RouteActionInterface;

/**
 * Represents a basic action to take on a matched route.
 * The action must be a valid 'callable' string or array that can be
 * passed to call_user_func_array().
 *
 * @since 0.1.0
 * @author	James Tracy <james.a.tracy@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 */
class RouteAction implements RouteActionInterface
{
    /** @var string|array */
    protected $callable = null;
    
    /**
     * @constructor
     * @param string|array $callable Valid argument for call_user_func_array()
     */
    public function __construct($callable)
    {
       $this->callable = $callable;
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
        if($this->callable) {
            // request is the first argument
            array_unshift($args, $request);
            $response = \call_user_func_array($this->callable, $args);
            return $response;
        }
        throw new \RuntimeException('Invalid Route Action');
    }
};
?>