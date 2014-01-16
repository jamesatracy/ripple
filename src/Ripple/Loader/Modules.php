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
class Module
{
    /** @var array Holds instantiated loaders */
    protected $loaders = array();
    
    public function add($path)
    {
        $index = strrpos($path, '/');
        $namespace = substr($index + 1);
        $path = substr($path, $index);
        echo $namespace;
        echo '<br/>';
        echo $path;
    }
}