<?php
namespace Ripple\HTTP;

use Ripple\HTTP\HttpEngine;
use Ripple\HTTP\Request;
use Exception;

/**
 * Request event object that is passed along with http.exception events.
 * Contains the request and the HttpEngine that dispatched it in addition
 * to the Exception.
 *
 * @since 0.1.0
 * @author	James Tracy <james.a.tracy@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 */
class HttpRequestExceptionEvent extends HttpRequestEvent
{
    /** @var \Exception */
    protected $exception = null;
    
    /**
     * @constructor
     * @param \Ripple\HTTP\HttpEngine $engine
     * @param \Ripple\HTTP\Request $request
     * @param \Exception $exception
     */
    public function __construct(HttpEngine $engine, Request $request, Exception $exception)
    {
        parent::__construct($engine, $request);
        $this->exception = $exception;
    }
    
    /**
     * Get the exception
     * @since 0.1.0
     * @return \Exception
     */
    public function getException()
    {
        return $this->exception;
    }
};
?>