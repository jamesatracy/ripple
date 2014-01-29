<?php
require_once __DIR__.'/../src/Ripple/View/Drivers/SimpleDriver.php';

/**
 * PHPUnit Test suite for SimpleDriver class
 * 
 */
class SimpleDriverTest extends PHPUnit_Framework_TestCase
{
	public function testMethod_render()
	{
		$driver = new \Ripple\View\Drivers\SimpleDriver();
		$ob = $driver->render(__DIR__.'/fixtures/views/simple_view.php', array(
		    'name' => 'John'
		));
		$this->assertEquals($ob, '<p>Hello, John</p>');
	}
};
?>