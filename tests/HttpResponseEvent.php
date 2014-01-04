<?php
namespace Ripple\HTTP;

use Ripple\HTTP\HttpEngine;
use Ripple\HTTP\Request;
use Ripple\HTTP\Response;

/**
 * Response event object that is passed along with http.response events.
 * Contains the response, request, and the HttpEngine that dispatched it.
 *
 * @since 0.1.0
 * @author	James Tracy <james.a.tracy@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 */
class HttpResponseEvent extends HttpRequestEvent
{
    /** @var \Ripple\HTTP\HttpEngine */
    protected $engine = null;
    
    /** @var \Ripple\HTTP\Request */
    protected $request = null;
    
    /** @var \Ripple\HTTP\Response */
    protected $response = null;
    
    /**
     * @constructor
     * @param \Ripple\HTTP\HttpEngine $engine
     * @param \Ripple\HTTP\Request $request
     */
    public function __construct(HttpEngine $engine, Request $request, Response $response)
    {
        parent::__construct($engine, $request);
        $this->response = $response;
    }
    
    /**
     * Get the active response
     * @since 0.1.0
     * @return \Ripple\HTTP\Response
     */
    public function getResponse()
    {
        return $this->response;
    }
};
?>