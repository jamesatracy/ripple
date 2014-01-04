<?php
namespace Ripple\Routing;

use Ripple\HTTP\HttpEvents;
use Ripple\Events\EventListener;
use Ripple\Routing\RouteCollection;

/**
 * RouteListener is an EventListener that binds to a RouteCollection and
 * and attempts to match it to a request when the http.request event is
 * triggered.
 *
 * @since 0.1.0
 * @author	James Tracy <james.a.tracy@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 */
class RouteListener extends EventListener
{
    /** @var array Map of events and callback function names */
    protected $event_map = array(
        HttpEvents::REQUEST => 'onRequest'    
    );
    
    /** @var \Ripple\Routing\RouteCollection */
    protected $collection = null;
    
    /**
     * Creates a new RouteListener and binds it to the given RouteCollection.
     * @constructor
     * @param \Ripple\Routing\RouteCollection $collection
     */
    public function __construct(RouteCollection $collection)
    {
        $this->collection = $collection;
    }
    
    /**
     * Creates a new RouteListener and binds it to the given RouteCollection.
     * @since 0.1.0
     * @param \Ripple\Routing\RouteCollection $collection
     */
    public static function create(RouteCollection $collection)
    {
        return new RouteListener($collection);
    }
    
    /**
     * Called when the http.request event is triggered.
     * @since 0.1.0
     * @return mixed
     */
    public function onRequest()
    {
        // TODO: attempt to match the request with a route in the bound RouteCollection
    }
};
?>