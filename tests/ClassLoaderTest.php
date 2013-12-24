<?php
use Ripple\Loader\ClassLoader;

require '../src/Ripple/Loader/ClassLoader.php';

/**
 * PHPUnit Test suite for ClassLoader
 *
 */
class ClassLoaderTest extends PHPUnit_Framework_TestCase
{
    public function testMethod_getFilePath()
    {
		// simple namespace
		$loader = new ClassLoader('Doctrine', '/path/to/doctrine');
		$this->assertEquals($loader->getFilePath('Doctrine\\Common\\Request'), '/path/to/doctrine/Doctrine/Common/Request.php');
		
		// nested namespace
        $loader = new ClassLoader('Doctrine\\Common', '/path/to/doctrine');
		$this->assertEquals($loader->getFilePath('Doctrine\\Common\\Request'), '/path/to/doctrine/Doctrine/Common/Request.php');
		
		// invalid
		$loader = new ClassLoader('Doctrine\\Common', '/path/to/doctrine');
		$this->assertNull($loader->getFilePath('Doctrine\\Core\\Request'));
    }
}
?>