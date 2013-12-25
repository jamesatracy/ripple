<?php
use Ripple\HTTP\Response;
use Ripple\HTTP\HttpStatus;

require_once __DIR__.'/../src/Ripple/HTTP/HttpStatus.php';
require_once __DIR__.'/../src/Ripple/HTTP/Response.php';

/**
 * PHPUnit Test suite for Response class
 *
 */
class ResponseTest extends PHPUnit_Framework_TestCase
{
	public function testMethod_status()
	{
		$resp = new Response();
		
		// default status code
		$this->assertEquals($resp->status(), 200);
		// valid status code
		$resp->status(404);
		$this->assertEquals($resp->status(), 404);
		// invalid status code
		$this->setExpectedException("InvalidArgumentException", "Response: Invalid status code 700");
		$this->assertFalse($resp->status(700));
		$this->assertEquals($resp->status(), 404);
	}
	
	public function testMethod_contentType()
	{
		$resp = new Response();
		
		// default is text/html
		$this->assertEquals($resp->contentType(), "text/html");
		// set content type
		$resp->contentType("application/json");
		$this->assertEquals($resp->contentType(), "application/json");
	}
	
	public function testMethod_header()
	{
		$resp = new Response();
		
		// default is empty
		$this->assertEmpty($resp->header());
		// single header
		$resp->header("Location", "http://example.com");
		$this->assertEquals($resp->header(), array("Location" => "http://example.com"));
		// multiple headers
		$resp->header(array(
			"WWW-Authenticate" => "Negotiate",
			"X-Extra" => "Extra"
		));
		$this->assertEquals($resp->header(), array(
			"Location" => "http://example.com",
			"WWW-Authenticate" => "Negotiate",
			"X-Extra" => "Extra"
		));
	}
	
	public function testMethod_body()
	{
		$resp = new Response();
		
		// default body is null
		$this->assertNull($resp->body());
		// set body
		$resp->body("Body Content");
		$this->assertEquals($resp->body(), "Body Content");
	}
	
	public function testMethod_send()
	{
		$resp = new Response();
		$this->expectOutputString("body content goes here");
		$resp->body("body content goes here");
		$resp->send();
        $this->assertEquals($resp->status(), 200);
	}
	
	public function testMethod_send404()
	{
		$resp = new Response();
		$this->expectOutputString("body content goes here");
		$resp->body("body content goes here");
		$resp->send(404);
	}
	
	public function testBehavior_send500()
	{
		$resp = new Response();
		$this->expectOutputString("body content goes here");
		$resp->body("body content goes here");
		$resp->send(500);
	}
}
?>