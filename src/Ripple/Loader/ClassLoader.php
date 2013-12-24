<?php
namespace Ripple\Loader;
require __DIR__.'/FileLoader.php';

/**
 * ClassLoader implementation that implements the technical interoperability
 * standards for PHP 5.3 namespaces and class names.
 *
 * http://groups.google.com/group/php-standards/web/final-proposal
 *
 *     // Example which loads classes for the Doctrine Common package in the
 *     // Doctrine\Common namespace.
 *     $classLoader = new ClassLoader('Doctrine\Common', '/path/to/doctrine');
 *     $classLoader->register();
 *
 * Based on SplClassLoader:
 * https://gist.github.com/jwage/221634
 *
 * @author	James Tracy <james.a.tracy@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 */
class ClassLoader extends FileLoader
{
    /**
     * Creates a new ClassLoader that loads classes of the
     * specified namespace.
     * 
     * @param string $ns The namespace to use.
     */
    public function __construct($ns = null, $includePath = null)
    {
		parent::__construct($ns, $includePath, '.php');
    }

    /**
     * Installs this class loader on the SPL autoload stack.
     */
    public function register()
    {
        spl_autoload_register(array($this, 'loadClass'));
    }

    /**
     * Uninstalls this class loader from the SPL autoloader stack.
     */
    public function unregister()
    {
        spl_autoload_unregister(array($this, 'loadClass'));
    }
	
    /**
     * Loads the given class or interface.
     *
     * @param string $className The name of the class to load.
     * @return void
     */
    public function loadClass($className)
    {
        $path = $this->getFilePath($className);
		if($path !== null) {
            require $path;
        }
    }
}
