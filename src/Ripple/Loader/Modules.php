<?php
namespace Ripple\Loader;
require_once __DIR__.'/ClassLoader.php';

/**
 * Module is a utility class for autoloading php modules. Essentially it is a
 * wrapper around the ClassLoader object.
 *
 * @since 0.1.0
 * @author	James Tracy <james.a.tracy@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 */
class Modules
{
    /** @var array Holds instantiated loaders */
    protected $loaders = array();
    
	/**
	 * Adds a module to the autoloader.
	 *
	 * Example:
	 * 	$modules->add(__DIR__.'/lib/MyModule');
	 *
	 * 	You can now create classes that have a namespace
	 *  that begins with MyModule:
	 *
	 *  $mine = new MyModule\MyClass();
	 *
	 * @since 0.1.0
	 * @param {string} $path The path to the module
	 */
    public function add($path)
    {
        $index = strrpos($path, '/');
        $namespace = substr($path, $index + 1);
        $path = substr($path, 0, $index);
        $loader = new ClassLoader($namespace, $path);
		$loader->register();
		$loaders[] = $loader;
    }
}