<?php
namespace Ripple\Routing;

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
	protected $route = '';
	
	/** @var string|array The route action. */
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
	 * @param string $route The route
	 * @param array|string $action The route action
	 * @param bool Whether or not the route requires a secure connection
	 */
	public function __construct($methods, $route, $action, $secure = false)
	{
		if(is_string($methods)) {
			$methods = array($methods);
		}
		$this->methods = $methods;
		$this->route = $route;
		$this->action = $action;
		$this->secure = $secure;
		$this->regex = preg_replace("/(:[a-z0-9_\-]+)/", "([a-z0-9_\-]+)", $route);
		
		// normalize
		foreach($this->methods as $i => $method) {
			$this->methods[$i] = strtolower($method);
		}
	}
	
	/**
	 * Returns the route's method.
	 * @since 0.1.0
	 * @return string
	 */
	public function getMethod()
	{
		return $this->method;
	}
	
	/**
	 * Returns the route
	 * @since 0.1.0
	 * @return string
	 */
	public function getRoute()
	{
		return $this->route;
	}
	
	/**
	 * Returns true if the request matches the route.
	 * Any matched route parameters can be retrieved through 
	 * getMatchedParameters().
	 * @since 0.1.0
	 * $param Ripple\HTTP\Request $request The request object
	 * @return bool
	 */
	public function matches($request)
	{
		$path = $request->getPath();
		$method = $request->getMethod();
		$route = $this->route;
		$regex = $this->regex;
		$params = array();
		
		// match secure
		if($this->secure && !$request->isSecure()) {
			return false;
		}
		
		// match method
		if(!in_array(strtolower($method), $this->methods)) {
			return false;
		}
		
		// match route
		if($route === $path) {
			// exact match
			$this->parameters = array();
			return true;
		}
		if(preg_match("{^".$regex."$}", $path, $params)) {
			// we have a match
			if(count($params) > 0) {
				$params = array_slice($params, 1);
			} else {
				$params = array();
			}
			$this->parameters = $params;
			return true;
		}
		return false;
	}
	
	/**
	 * Returns the matched parameters from a matching route.
	 * Must be preceded by a call to matches().
	 * @since 0.1.0
	 * @return array
	 */
	public function getMatchedParameters()
	{
		return $this->parameters;
	}
};
?>