<?php
use Ripple\Core\ClassLoader;

require '../src/Ripple/Core/ClassLoader.php';

/**
 * PHPUnit Test suite for ClassLoader
 *
 */
class ClassLoaderTest extends PHPUnit_Framework_TestCase
{
    public function testMethod_getClassPath()
    {
		// simple namespace
		$loader = new ClassLoader('Doctrine', '/path/to/doctrine');
		$this->assertEquals($loader->getClassPath('Doctrine\\Common\\Request'), '/path/to/doctrine/Doctrine/Common/Request.php');
		
		// nested namespace
        $loader = new ClassLoader('Doctrine\\Common', '/path/to/doctrine');
		$this->assertEquals($loader->getClassPath('Doctrine\\Common\\Request'), '/path/to/doctrine/Doctrine/Common/Request.php');
		
		// invalid
		$loader = new ClassLoader('Doctrine\\Common', '/path/to/doctrine');
		$this->assertNull($loader->getClassPath('Doctrine\\Core\\Request'));
    }
}
?>