<?php
namespace Ripple\Routing;

use \Ripple\HTTP\Request;
use \Ripple\HTTP\Response;

/**
 * Maintains a collection of routes and, given a request, attempts to match
 * a route with the request. When a route is matched it is dispatched and a
 * response is returned back to the caller.
 *
 * @since 0.1.0
 * @author	James Tracy <james.a.tracy@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 */
class RouteCollection
{
    /** @var array Holds the collection of Route objects */
    protected $routes = array();
    
    /**
     * Add a route to the collection.
     * @since 0.1.0
     * @param \Ripple\Routing\Route $route 
     */
    public function addRoute(Route $route)
    {
       $this->routes[] = $route; 
    }
    
    /**
     * Attempt to match a route in the collection against a given request.
     * If a match is found the route is dispatched and the response returned.
     * Otherwise, match returns false.
     * @since 0.1.0
     * @param \Ripple\HTTP\Request $request
     * @return \Ripple\HTTP\Response|bool
     */
    public function match(Request $request)
    {
       foreach($this->routes as $route) {
           if($route->matches($request)) {
               $response = $route->dispatch($request);
               if(is_string($response)) {
                   return Response::create(200, $response);
               }
               return $response;
           }
       }
       
       return false;
    }
};
?>