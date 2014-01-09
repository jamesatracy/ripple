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
        $this->add('GET', $path, $callback);
    }
    
    /**
     * Creates a new POST route.
     * @since 0.1.0
     * @param string $path
     * @param mixed $callback
     */
    public function post($path, $callback)
    {
        $this->add('POST', $path, $callback);
    }
    
    /**
     * Creates a new PUT route.
     * @since 0.1.0
     * @param string $path
     * @param mixed $callback
     */
    public function put($path, $callback)
    {
        $this->add('PUT', $path, $callback);
    }
    
    /**
     * Creates a new DELETE route.
     * @since 0.1.0
     * @param string $path
     * @param mixed $callback
     */
    public function delete($path, $callback)
    {
        $this->add('DELETE', $path, $callback);
    }
    
    /**
     * Creates a new PATCH route.
     * @since 0.1.0
     * @param string $path
     * @param mixed $callback
     */
    public function patch($path, $callback)
    {
        $this->add('PATCH', $path, $callback);
    }
    
    /**
     * Creates a new route based on method, path, and callback
     * @since 0.1.0
     * @param array|string $methods
     * @param string $path
     * @param mixed $callback
     */
    public function add($methods, $path, $callback)
    {
        $action = new RouteAction($callback);
        $route = new Route($methods, $path, $action);
        $this->collection->addRoute($route);
    }
};
?>