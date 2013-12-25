<?php
use Ripple\HTTP\RedirectResponse;
use Ripple\HTTP\HttpStatus;

require_once __DIR__.'/../src/Ripple/HTTP/HttpStatus.php';
require_once __DIR__.'/../src/Ripple/HTTP/Response.php';
require_once __DIR__.'/../src/Ripple/HTTP/RedirectResponse.php';

/**
 * PHPUnit Test suite for Response class
 *
 */
class RedirectResponseTest extends PHPUnit_Framework_TestCase
{
	public function testMethod_send()
	{
		$resp = new RedirectResponse();
		$this->expectOutputString("body content goes here");
		$resp->body("body content goes here");
		$resp->send();
        $this->assertEquals($resp->status(), 302);
	}
	
	public function testBehavior_statusOverride()
	{
		$resp = new RedirectResponse();
		// cannot override status code
		$resp->status(200);
        $this->assertEquals($resp->status(), 302);
	}
}
?>