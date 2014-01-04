<?php
namespace Ripple\HTTP;

use Ripple\HTTP\HttpEngine;
use Ripple\HTTP\Request;

/**
 * Request event object that is passed along with http.request events.
 * Contains the request and the HttpEngine that dispatched it.
 *
 * @since 0.1.0
 * @author	James Tracy <james.a.tracy@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 */
class HttpRequestEvent
{
    /** @var \Ripple\HTTP\HttpEngine */
    protected $engine = null;
    
    /** @var \Ripple\HTTP\Request */
    protected $request = null;
    
    /**
     * @constructor
     * @param \Ripple\HTTP\HttpEngine $engine
     * @param \Ripple\HTTP\Request $request
     */
    public function __construct(HttpEngine $engine, Request $request)
    {
        $this->engine = $engine;
        $this->request = $request;
    }
    
    /**
     * Get the active http engine
     * @since 0.1.0
     * @return \Ripple\HTTP\HttpEngine
     */
    public function getHttpEngine()
    {
        return $this->engine;
    }
    
    /**
     * Get the active request
     * @since 0.1.0
     * @return \Ripple\HTTP\Request
     */
    public function getRequest()
    {
        return $this->request;
    }
};
?>