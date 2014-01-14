<?php
namespace Ripple\Routing;

/**
 * Interface for creating routes. Under the hood it takes care of setting up
 * the RouteController and RouteListener objects.
 *
 * @since 0.1.0
 * @author	James Tracy <james.a.tracy@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 */
class Router
{
    /** @var \Ripple\Routing\RouteCollection */
    protected $collection = null;
    
    /** @var \Ripple\Routing\RouteListener */
    protected $listener = null;
    
    /** @var array */
    protected $aliases = array();
    
    /** @var \Ripple\Routing\Route */
    protected $lastRoute = null;
    
    /**
     * @constructor
     * @since 0.1.0
     * @param \Ripple\Events\Dispatcher $dispatcher
     */
    public function __construct($dispatcher)
    {
        $this->collection = new RouteCollection();
        $this->listener = new RouteListener($this->collection);
        $this->listener->subscribe($dispatcher);
    }
    
    /**
     * Creates a new GET route.
     * @since 0.1.0
     * @param string $path
     * @param mixed $callback
     */
    public function get($path, $callback)
    {
        return $this->add('GET', $path, $callback);
    }
    
    /**
     * Creates a new POST route.
     * @since 0.1.0
     * @param string $path
     * @param mixed $callback
     */
    public function post($path, $callback)
    {
        return $this->add('POST', $path, $callback);
    }
    
    /**
     * Creates a new PUT route.
     * @since 0.1.0
     * @param string $path
     * @param mixed $callback
     */
    public function put($path, $callback)
    {
        return $this->add('PUT', $path, $callback);
    }
    
    /**
     * Creates a new DELETE route.
     * @since 0.1.0
     * @param string $path
     * @param mixed $callback
     */
    public function delete($path, $callback)
    {
        return $this->add('DELETE', $path, $callback);
    }
    
    /**
     * Creates a new PATCH route.
     * @since 0.1.0
     * @param string $path
     * @param mixed $callback
     */
    public function patch($path, $callback)
    {
        return $this->add('PATCH', $path, $callback);
    }
    
    /**
     * Creates a new route based on method, path, and callback
     * @since 0.1.0
     * @param array|string $methods
     * @param string $path
     * @param mixed $callback
     * @return \Ripple\Routing\Router
     */
    public function add($methods, $path, $callback)
    {
        // determine what kind of action this represents
        if($callable instanceof RouteActionInterface) {
            $action = $callable;
        } else {
            if(is_string($callback)) {
                $arr = explode('@', $callback);
                if(count($arr) === 1) {
                    // simple action
                    $action = new RouteAction($callback);
                } else {
                    // controller action
                    // format: ControllerClassName@methodName
                    $action = new RouteControllerAction($arr[0], $arr[1]);
                }
            } else {
                // simple action
                $action = new RouteAction($callback);
            }
        }
        
        $route = new Route($methods, $path, $action);
        $this->collection->addRoute($route);
        $this->lastRoute = $route;
        return $this;
    }
    
    /**
     * Create an alias for the last route added
     * @since 0.1.0
     * @param string $alias
     * @return \Ripple\Routing\Router
     * @throws \RuntimeException
     */
    public function alias($alias)
    {
        if($this->lastRoute) {
            if(isset($this->aliases[$alias])) {
                throw new \RuntimeException('Duplicate alias: '.$alias);
            }
            $this->aliases[$alias] = $this->lastRoute->getPath();
        }
    }
};
?>