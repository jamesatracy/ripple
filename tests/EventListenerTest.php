<?php
use Ripple\Events\Dispatcher;
use Ripple\Events\EventListener;

require_once __DIR__.'/../src/Ripple/Events/Dispatcher.php';
require_once __DIR__.'/../src/Ripple/Events/EventListener.php';

class Tester extends EventListener
{
    protected $event_map = array(
        'test.event1' => 'onTestEventOne',
        'test.event2' => 'onTestEventTwo'
    );
    
    public function onTestEventOne()
    {
        return true;
    }
    
    public function onTestEventTwo()
    {
        return true;
    }
};


/**
 * PHPUnit Test suite for EventListener class
 * 
 */
class EventListenerTest extends PHPUnit_Framework_TestCase
{
    public function testMethod_subscribe()
    {
        $dispatcher = new Dispatcher();
        $tester = new Tester();
        $tester->subscribe($dispatcher);
        
        $this->assertTrue($dispatcher->until('test.event1'));
        $this->assertTrue($dispatcher->until('test.event2'));
        $this->assertNull($dispatcher->until('test.event3'));
    }
};
?>