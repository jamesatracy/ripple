<?php
namespace Ripple\Events;

/**
 * Binds event listeners and dispatches events.
 *
 * @since 0.1.0
 * @author	James Tracy <james.a.tracy@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 */
class Dispatcher
{
    /** @var array List of registered events. */
    protected $events = array();  
    
    /**
	 * Bind a callback function to an event
	 *
	 * @since 0.1.0
	 * @param string $event The event name
	 * @param mixed $listener A valid php callback
	 */
	public function on($event, $listener)
	{
		if(!isset($this->events[$event])) {
			$this->events[$event] = array();
		}
		$this->events[$event][] = $listener;
	}
	
	/**
	 * Unbind a callback function from an event
	 *
	 * @since 0.1.0
	 * @param string $event The event name
	 * @param mixed $listener Optional. A valid php callback
	 */
	public function off($event, $listener = null)
	{
		if(isset($this->events[$event])) {
			if($listener === null) {
				// remove all listeners
				$this->events[$event] = array();
			} else {
				foreach($this->events[$event] as $index => $callback) {
					if($callback === $listener) {
						$this->events[$event] = array_splice($this->events[$event], $index, 1);
						break;
					}
				}
			}
		}
	}
	
	/**
	 * Trigger an event. You can pass as many additional params to trigger
	 * as you like - listeners will receive them.
	 *
	 * @since 0.1.0
	 * @param string $event The event name
	 * @return bool False if the event was cancelled, True otherwise
	 */
	public function trigger($event)
	{
		$params = array();
		if(func_num_args() > 1) {
			$params = array_slice(func_get_args(), 1);
		}
		if(isset($this->events[$event])) {
			return $this->dispatch($this->events[$event], $params);
		}
		return null;
	}
	
	/**
	 * Trigger an event once and then remove all listeners.
	 *
	 * @since 0.1.0
	 * @param string $event The event name
	 * @return mixed
	 */
	public function once($event)
	{
		$params = array();
		if(func_num_args() > 1) {
			$params = array_slice(func_get_args(), 1);
		}
		if(isset($this->events[$event])) {
			$response = $this->dispatch($this->events[$event], $params);
			$this->off($event);
			return $response;
		}
		return null;
	}
	
	/**
	 * Trigger an event until a non-null response is returned by one of its
	 * listeners. If none return a response then the return value of until will
	 * be null.
	 * 
	 * @since 0.1.0
	 * @param string $event The event name
	 * @return mixed
	 */
	public function until($event)
	{
		$params = array();
		if(func_num_args() > 1) {
			$params = array_slice(func_get_args(), 1);
		}
		if(isset($this->events[$event])) {
			return $this->dispatch($this->events[$event], $params, true);
		}
		return null;
	}
	
	/**
	 * Internal function for dispatching events
	 *
	 * @since 0.1.0
	 * @param array $listeners The array of event listeners
	 * @param mixed $params Parameters to pass along with the event
	 * @param bool $halt Whether or not to halt the event after a non null response
	 * @return mixed
	 */
	protected function dispatch($listeners, $params, $halt = false)
	{
	    $responses = array();
	    
		foreach($listeners as $callable) {
			$response = call_user_func_array($callable, $params);
			
			if($halt === true && !is_null($response)) {
			    // halt firing and return the response
			    return $response;    
			}
			
			if($response === false) {
				// stop further propagation
				break;
			}
			
			$responses[] = $response;
		}
		return ($halt ? null : $responses);
	}
};
?>