<?php
namespace Ripple\HTTP;

use Ripple\Events\Dispatcher;
use Ripple\HTTP\HttpEvents;
use Ripple\HTTP\HttpRequestEvent;
use Ripple\HTTP\HttpRequestExceptionEvent;
use Ripple\HTTP\HttpResponseEvent;
use Ripple\HTTP\HttpStatus;
use Ripple\HTTP\Request;
use Ripple\HTTP\Response;

/**
 * HttpEngine processes a request and attempts to generate a response.
 *
 * @since 0.1.0
 * @author	James Tracy <james.a.tracy@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 */
class HttpEngine
{
    /** @var \Ripple\Events\Dispatcher */
    protected $dispatcher = null;
    
    /**
     * Construct a new HttpEngine object.
     * @constructor
     * @since 0.1.0
     * @param \Ripple\Events\Dispatcher $dispatcher
     */
    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }
    
    /**
     * Get the event dispatcher attached to the HttpEngine.
     * @since 0.1.0
     * @return \Ripple\Events\Dispatcher
     */
    public function getDispatcher()
    {
        return $this->dispatcher;
    }
    
    /**
     * Handles a request by attempting to generate a response.
     * If it cannot generate a response from the application then HttpEngine
     * will send a 404 response.
     * If it encounters an unhandles exception from the application then
     * HttpEngine will send a 500 response.
     * @since 0.1.0
     * @param \Ripple\HTTP\Request $request
     */
    public function handle(Request $request)
    {
        try {
            // trigger a request event and give the application an opportunity
            // to return a response
            $response = $this->dispatcher->until(HttpEvents::REQUEST, new HttpRequestEvent($this, $request));
            if($response && $response instanceof Response) {
                return $this->finishResponse($request, $response);
            }
            
            // the application did not respond to the request so create a
            // 404 response
            $response = Response::create(HttpStatus::NOT_FOUND, '');
            return $this->finishResponse($request, $response);
        } catch(\Exception $e) {
            // uncaught exception
            // give the application a chance to handle it
            $response = $this->dispatcher->until(HttpEvents::EXCEPTION, new HttpRequestExceptionEvent($this, $request, $e));
            if($response && $response instanceof Response) {
                return $this->finishResponse($request, $response);
            }
            
            // create a 500 response
            $response = Response::create(HttpStatus::INTERNAL_SERVER_ERROR, '');
            return $this->finishResponse($request, $response);
        }
    }
    
    /**
     * Perform any last minute operations on the response before it is sent.
     * @since 0.1.0
     * @param \Ripple\HTTP\Response $response
     * @return bool
     */
    protected function finishResponse(Request $request, Response $response)
    {
        // trigger a response event and give the application an opportunity 
        // to modify the response object
        $this->dispatcher->trigger(HttpEvents::RESPONSE, new HttpResponseEvent($this, $request, $response));
        
        return $this->sendResponse($request, $response);
    }
    
    /**
     * Send the response object.
     * @since 0.1.0
     * @param \Ripple\HTTP\Response $response
     * @return bool
     */
    protected function sendResponse(Request $request, Response $response)
    {
        // finally, send the response
        $response->send();
        
        // give the application a chance to perform any shut down operations
        // after the response is sent
        $this->dispatcher->trigger(HttpEvents::FINISHED, new HttpResponseEvent($this, $request, $response));
        
        return true;
    }
};
?>