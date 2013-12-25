<?php
namespace Ripple\HTTP;

/**
 * Handles sending a HTTP 302 redirect headers and content.
 *
 * @since 0.1.0
 * @author	James Tracy <james.a.tracy@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 */
class RedirectResponse extends Response
{
	/**
	 * Constructor. Optionally set the status.
	 *
	 * @param int $status The response status
	 * @param string $body The response body.
	 */
	public function __construct($body = null)
	{
		$this->_status = HttpStatus::FOUND;
		$this->body($body);
	}
	
	/**
	 * Set the redirect location.
	 * 
	 * @since 0.1.0
	 * @param string $url The full url to redirect to.
	 */
	public function to($url)
	{
		$this->header("Location", $url);
		return $this;
	}
	
	/**
	 * Gets the status code.
	 *
	 * @since 0.1.0
	 * @param int The status code number
	 * @return int Returns the status if $code is set to null
	 * @throws InvalidArgumentException
	 */
	public function status($code = null)
	{
		if($code === null) {
			return $this->_status;
		}
		// do not override the status code here
		return $this;
	}
}
?> 