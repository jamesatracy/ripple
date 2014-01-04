<?php
namespace Ripple\HTTP;

/**
 * Http Event constants.
 * 
 * @since 0.1.0
 * @author	James Tracy <james.a.tracy@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 */
class HttpEvents
{
    /** @const string Sent when a request is ready to be processed. */
    const REQUEST = 'http.request';
    
    /** @const string Sent when the http engine encounters an exception. */
    const EXCEPTION = 'http.exception';
    
    /** @const string Sent before the http response is completed. */
    const RESPONSE = 'http.response';
    
    /** @const string Sent after the http response is completed. */
    const FINISHED = 'http.finished';
};
?>