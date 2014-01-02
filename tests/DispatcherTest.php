<?php
use Ripple\Events\Dispatcher;

require_once __DIR__.'/../src/Ripple/Events/Dispatcher.php';

/**
 * PHPUnit Test suite for Dispatcher class
 * 
 */
class DispatcherTest extends PHPUnit_Framework_TestCase
{
    protected $firstCallbackCalled = false;
	protected $secondCallbackCalled = false;
	
	public function setUp()
	{
		$this->firstCallbackCalled = false;
		$this->secondCallbackCalled = false;
	}

	public function testBehavior_singleEventBinding()
	{
	    $dispatcher = new Dispatcher();
		$dispatcher->on("test.single.event", array($this, "onFirstEventTriggered"));
		$dispatcher->trigger("different.event");
		$this->assertFalse($this->firstCallbackCalled);
		$dispatcher->trigger("test.single.event");
		$this->assertTrue($this->firstCallbackCalled);
	}
	
	public function testBehavior_multipleEventBinding()
	{
	    $dispatcher = new Dispatcher();
		$dispatcher->on("test.multiple.event", array($this, "onFirstEventTriggered"));
		$dispatcher->on("test.multiple.event", array($this, "onSecondEventTriggered"));
		$dispatcher->trigger("different.event");
		$this->assertFalse($this->firstCallbackCalled);
		$this->assertFalse($this->secondCallbackCalled);
		$dispatcher->trigger("test.multiple.event");
		$this->assertTrue($this->firstCallbackCalled);
		$this->assertTrue($this->secondCallbackCalled);
	}
	
	public function testBehavior_singleEventUnBinding()
	{
	    $dispatcher = new Dispatcher();
	    $dispatcher->on("test.single.event", array($this, "onFirstEventTriggered"));
		$dispatcher->off("test.single.event");
		$dispatcher->trigger("test.single.event");
		$this->assertFalse($this->firstCallbackCalled);
	}
	
	public function testBehavior_multipleEventUnBinding()
	{
	    $dispatcher = new Dispatcher();
	    $dispatcher->on("test.multiple.event", array($this, "onFirstEventTriggered"));
		$dispatcher->on("test.multiple.event", array($this, "onSecondEventTriggered"));
		$dispatcher->off("test.multiple.event");
		$dispatcher->trigger("test.multiple.event");
		$this->assertFalse($this->firstCallbackCalled);
		$this->assertFalse($this->secondCallbackCalled);
	}
	
	public function testMethod_until()
	{
	    $dispatcher = new Dispatcher();
	    $dispatcher->on("test.until.event", array($this, "onFirstEventTriggered"));
	    $dispatcher->on("test.until.event", array($this, "onSecondEventTriggered"));
	    $this->assertNull($dispatcher->until("test.until.event"));
	    
	    $dispatcher = new Dispatcher();
	    $dispatcher->on("test.until.event", array($this, "onFirstEventTriggered"));
	    $dispatcher->on("test.until.event", array($this, "onUntilEventTriggered"));
	    $dispatcher->on("test.until.event", array($this, "onSecondEventTriggered"));
	    $this->assertEquals($dispatcher->until("test.until.event"), "Hello!");
	}
	
	public function testMethod_once()
	{
	    $dispatcher = new Dispatcher();
	    $dispatcher->on("test.multiple.event", array($this, "onFirstEventTriggered"));
		$dispatcher->on("test.multiple.event", array($this, "onSecondEventTriggered"));
		
		$dispatcher->once("test.multiple.event");
		$this->assertTrue($this->firstCallbackCalled);
		$this->assertTrue($this->secondCallbackCalled);
		
		$this->firstCallbackCalled = false;
		$this->secondCallbackCalled = false;
		
		$dispatcher->once("test.multiple.event");
		$this->assertFalse($this->firstCallbackCalled);
		$this->assertFalse($this->secondCallbackCalled);
	}
	
	public function onFirstEventTriggered()
	{
		$this->firstCallbackCalled = true;
	}
	
	public function onSecondEventTriggered()
	{
		$this->secondCallbackCalled = true;
	}
	
	public function onUntilEventTriggered()
	{
	    return "Hello!";
	}
};
?>