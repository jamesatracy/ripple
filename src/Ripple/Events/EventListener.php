<?php
namespace Ripple\Events;

/**
 * Base class for EventListener objects.
 *
 * @since 0.1.0
 * @author	James Tracy <james.a.tracy@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 */
class EventListener
{
    /** @var array Map of events and callback function names */
    protected $eventMap = array();
    
    /**
     * Subscribes the EventListener object to its events on the given dispatcher.
     * @since 0.1.0
     * @param \Ripple\Events\Dispatcher $dispatcher
     */
    public function subscribe(Dispatcher $dispatcher)
    {
       foreach($eventMap as $event => $callback) {
           $dispatcher->on($event, array($this, $callback));
       } 
    }
};
?>