<?php
namespace Ripple\HTTP;

/**
 * Handles sending HTTP response headers and content.
 *
 * @since 0.1.0
 * @author	James Tracy <james.a.tracy@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 */
class Response
{
	/** @var int The status code for the response */
	protected $_status = HttpStatus::OK;
	
	/** @var string The response HTTP prototcol */
	protected $_protocol = 'HTTP/1.1';
	
	/** @var string The response content mime type */
	protected $_content_type = "text/html";
	
	/** @var array The response headers */
	protected $_headers = array();
	
	/** @var string The response body */
	protected $_body = null; 
	
	/**
	 * Constructor. Optionally set the status.
	 *
	 * @param int $status The response status
	 * @param string $body The response body.
	 */
	public function __construct($status = HttpStatus::OK, $body = null)
	{
		$this->status($status);
		$this->body($body);
	}
	
	/**
	 * Factory method. Create a new response.
	 *
	 * @since 0.1.0
	 * @param int $status The response status
	 * @param string $body The response body.
	 * @return Ripple\HTTP\Response
	 */
	public static function create($status = 200, $body = null)
	{
		return new Response($status, $body);
	}
	
	/** 
	 * Sends the complete response, including headers and content.
	 *
	 * @since 0.1.0
	 * @param int $status Optional status as a shortcut to calling status()
	 */
	public function send($status = null)
	{
		if($status !== null) {
			$this->status($status);
		}

		// send protocol and status
		$code_message = HttpStatus::toMessage($this->_status);
		$this->sendHeader($this->_protocol." ".$this->_status." ".$code_message);
		
		// set content type header
		$this->header("Content-Type", $this->_content_type);
		
		// send all headers
		foreach($this->_headers as $key => $value) {
			$this->sendHeader($key, $value);
		}
		
		// send body
		if($this->_body !== null) {
			echo $this->_body;
		}
	}
	
	/**
	 * Gets or sets the status code. Must be a valid code.
	 *
	 * @since 0.1.0
	 * @param int The status code number
	 * @return int|Ripple\HTTP\Response
	 * @throws InvalidArgumentException
	 */
	public function status($code = null)
	{
		if($code === null) {
			return $this->_status;
		}
		if(!HttpStatus::isValid($code)) {
			throw new \InvalidArgumentException("Response: Invalid status code ".$code);
		}
		$this->_status = $code;
		return $this;
	}

	/**
	 * Gets or sets the content mime type
	 *
	 * @since 0.1.0
	 * @param string The content mime type
	 * @return string|Ripple\HTTP\Response
	 */
	public function contentType($type = null)
	{
		if($type === null) {
			return $this->_content_type;
		}
		$this->_content_type = $type;
		return $this;
	}
	
	/** Gets or sets header(s)
	 * 
	 * @since 0.1.0
	 * @param string|array $header The header name or an array of headers
	 * @param string $value The header value, if $header is a string
	 * @return null|array|Ripple\HTTP\Response
	 */
	public function header($header = null, $value = null)
	{
		if($header === null) {
			return $this->_headers;
		}
		if(is_array($header)) {
			foreach($header as $key => $value) {
				$this->header($key, $value);
			}
			return $this;
		}
		if($value !== null) {
			$this->_headers[$header] = $value;
		} else if($header !== null) {
		    return $this->_headers[$header];
		}
		return $this;
	}
	
	/**
	 * Gets or sets the body content.
	 *
	 * @since 0.1.0
	 * @param string The body content
	 * @return int|Ripple\HTTP\Response
	 */
	public function body($body = null)
	{
		if($body === null) {
			return $this->_body;
		}
		$this->_body = $body;
		return $this;
	}
	
	/**
	 * Sends a header
	 *
	 * @since 0.1.0
	 * @protected
	 * @param string $header The header
	 * @param string $value Optional value, if not included in $header
	 */
	protected function sendHeader($header, $value = null)
	{
		if(!headers_sent()) {
			if($value === null) {
				header($header);
			} else {
				header($header.": ".$value);
			}
		}
	}
}
?> 