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
    protected $event_map = array();
    
    /**
     * Set the event map.
     * @since 0.1.0
     * @param array $event_map
     */
    public function setEventMap($event_map)
    {
        $this->event_map = $event_map;
    }
    /**
     * Subscribes the EventListener object to its events on the given dispatcher.
     * @since 0.1.0
     * @param \Ripple\Events\Dispatcher $dispatcher
     */
    public function subscribe(Dispatcher $dispatcher)
    {
       foreach($this->event_map as $event => $callback) {
           $dispatcher->on($event, array($this, $callback));
       }
       
       return $this;
    }
};
?>