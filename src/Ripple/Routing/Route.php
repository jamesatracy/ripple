<?php
namespace Ripple\Routing;

use \Ripple\HTTP\Request;
use \Ripple\Routing\RouteActionInterface;

/**
 * Holds information for an HTTP route.
 *
 * @since 0.1.0
 * @author	James Tracy <james.a.tracy@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 */
class Route
{
	/** @var array The http methods. */
	protected $methods = array();
	
	/** @var string The route path. */
	protected $path = '';
	
	/** @var Ripple\Routing\RouteActionInterface The route action. */
	protected $action = '';
	
	/** @var bool Whether or not the route requires a secure connection */
	protected $secure = false;
	
	/** @var string Regex pattern for the route. */
	protected $regex = '';
	
	/** @var array Array of matched route parameters. */
	protected $parameters = array();
	
	/**
	 * @since 0.1.0
	 * @constructor
	 * @param array $methods Array of http methods
	 * @param string $path The route's uri path
	 * @param Ripple\Routing\RouteAction $action The route action
	 * @param bool Whether or not the route requires a secure connection
	 */
	public function __construct($methods, $path, $action, $secure = false)
	{
		if(is_string($methods)) {
			$methods = array($methods);
		}
		$this->methods = $methods;
		$this->path = $path;
		$this->action = $action;
		$this->secure = $secure;
	}
	
	/**
	 * Returns the route's methods
	 * @since 0.1.0
	 * @return string
	 */
	public function getMethods()
	{
		return $this->methods;
	}
	
	/**
	 * Returns the route's path
	 * @since 0.1.0
	 * @return string
	 */
	public function getPath()
	{
		return $this->path;
	}
	
	/**
	 * Set the secure flag for this route
	 * @since 0.1.0
	 * @param bool $secure
	 */
	public function secure($secure)
	{
	    $this->secure = $secure;
	}
	
	/**
	 * Check whether or not this route is secure
	 * @since 0.1.0
	 * @return bool
	 */
	public function isSecure()
	{
	    return $this->secure;
	}
	
	/**
	 * Returns true if the request matches the route.
	 * Any matched route parameters can be retrieved through 
	 * getMatchedParameters().
	 * @since 0.1.0
	 * $param Ripple\HTTP\Request $request The request object
	 * @return bool
	 */
	public function matches(Request $request)
	{
		$path = $request->getPath();
		$method = $request->getMethod();

        $this->prepare($request);
		
		// match secure
		if($this->secure && !$request->isSecure()) {
			return false;
		}
		
		// match method
		if(!in_array(strtolower($method), $this->methods)) {
			return false;
		}
		
		// match path
		if($this->path === $path) {
			// exact match
			return true;
		}
		if(preg_match("{^".$this->regex."$}", $path)) {
			// we have a match
			return true;
		}
		return false;
	}
	
	/**
	 * Dispatches the route by executing the corresponding route action.
	 * Returns the response object.
	 * Must be called after matches()
	 * @since 0.1.0
	 * @param Ripple\HTTP\Request The active request object
	 * @return Ripple\HTTP\Response
	 * @throws \RuntimeException
	 */
	public function dispatch($request)
	{
	    if($this->action && $this->action instanceof RouteActionInterface) {
	        return $this->action->run($request, $this->parameters);
	    }
	    throw new \RuntimeException('Invalid Route Action');
	}
	
	/**
	 * Returns the matched parameters for a given request.
	 * If the route does not match, then it returns an empty array.
	 * @since 0.1.0
	 * @return array
	 */
	public function getMatchedParameters()
	{
		return $this->parameters;
	}
	
	/**
	 * Prepare the route for matching.
	 * @since 0.1.0
	 * @param Ripple\HTTP\Request The active request object
	 */
	protected function prepare(Request $request)
	{
	    // create regex 
	    $this->regex = preg_replace("/(:[a-z0-9_\-]+)/", "([a-z0-9_\-]+)", $this->path);
		
		// normalize methods
		foreach($this->methods as $i => $method) {
			$this->methods[$i] = strtolower($method);
		}
		
		$this->bindParameters($request);
		
		return $this;
	}
	
	/**
	 * Binds any parameters matched for the given request to the route.
	 * @since 0.1.0
	 * @param Ripple\HTTP\Request The active request object
	 */ 
	protected function bindParameters(Request $request)
	{
	    $params = array();
	    if(preg_match("{^".$this->regex."$}", $request->getPath(), $params)) {
			// we have a match
			if(count($params) > 0) {
				$params = array_slice($params, 1);
			} else {
				$params = array();
			}
			$this->parameters = $params;
		} else {
		    $this->parameters = array();
		}
	}
};
?>