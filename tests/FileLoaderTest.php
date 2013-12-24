<?php
use Ripple\Loader\FileLoader;

require_once __DIR__.'/../src/Ripple/Loader/FileLoader.php';

/**
 * PHPUnit Test suite for FileLoader
 *
 */
class FileLoaderTest extends PHPUnit_Framework_TestCase
{
    public function testMethod_getFilePath()
    {
		// simple namespace
		$loader = new FileLoader('views', '/path/to/app', '.php');
		$loader->setNamespaceSeparator('.');
		$this->assertEquals($loader->getFilePath('views.settings.user.edit'), '/path/to/app/views/settings/user/edit.php');
		
		// nested namespace
        $loader = new FileLoader('views.settings', '/path/to/app', '.php');
        $loader->setNamespaceSeparator('.');
		$this->assertEquals($loader->getFilePath('views.settings.user.edit'), '/path/to/app/views/settings/user/edit.php');
		
		// invalid
		$loader = new FileLoader('views.settings', '/path/to/app', '.php');
		$loader->setNamespaceSeparator('.');
		$this->assertNull($loader->getFilePath('views.profile.user.edit'));
    }
}
?>