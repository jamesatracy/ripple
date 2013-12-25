<?php
namespace Ripple\Loader;

/**
 * FileLoader implementation that abstracts the technical interoperability
 * standards for PHP 5.3 namespaces and class names to any file name that
 * needs to be resolved.
 *
 * Based on SplClassLoader:
 * https://gist.github.com/jwage/221634
 *
 * @since 0.1.0
 * @author	James Tracy <james.a.tracy@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 */
class FileLoader
{
    private $_fileExtension = '';
    private $_namespace;
    private $_includePath;
    private $_namespaceSeparator = '\\';

    /**
     * Creates a new FileLoader that loads classes of the
     * specified namespace.
     * 
     * @param string $ns The namespace to use.
     * @param string $includePath The include path.
     * @param string $extension The file extension.
     */
    public function __construct($ns = null, $includePath = null, $extension = '')
    {
        $this->_namespace = $ns;
        $this->_includePath = $includePath;
		$this->_fileExtension = $extension;
    }

    /**
     * Sets the namespace separator used by classes in the namespace of this class loader.
     * 
     * @param string $sep The separator to use.
     */
    public function setNamespaceSeparator($sep)
    {
        $this->_namespaceSeparator = $sep;
    }

    /**
     * Gets the namespace separator used by classes in the namespace of this class loader.
     *
     * @return void
     */
    public function getNamespaceSeparator()
    {
        return $this->_namespaceSeparator;
    }

    /**
     * Sets the base include path for all class files in the namespace of this class loader.
     * 
     * @param string $includePath
     */
    public function setIncludePath($includePath)
    {
        $this->_includePath = $includePath;
    }

    /**
     * Gets the base include path for all class files in the namespace of this class loader.
     *
     * @return string $includePath
     */
    public function getIncludePath()
    {
        return $this->_includePath;
    }

    /**
     * Sets the file extension of class files in the namespace of this class loader.
     * 
     * @param string $fileExtension
     */
    public function setFileExtension($fileExtension)
    {
        $this->_fileExtension = $fileExtension;
    }

    /**
     * Gets the file extension of class files in the namespace of this class loader.
     *
     * @return string $fileExtension
     */
    public function getFileExtension()
    {
        return $this->_fileExtension;
    }

	/**
	 * Get the given file path.
	 *
	 * @param string $identName The identifier name
	 * @return string|null
	 */
	public function getFilePath($identName)
	{
		if (null === $this->_namespace || $this->_namespace.$this->_namespaceSeparator === substr($identName, 0, strlen($this->_namespace.$this->_namespaceSeparator))) {
		    $fileName = '';
            $namespace = '';
            if (false !== ($lastNsPos = strripos($identName, $this->_namespaceSeparator))) {
                $namespace = substr($identName, 0, $lastNsPos);
                $identName = substr($identName, $lastNsPos + 1);
                $fileName = str_replace($this->_namespaceSeparator, DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
            }
            $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $identName) . $this->_fileExtension;

            return ($this->_includePath !== null ? $this->_includePath . DIRECTORY_SEPARATOR : '') . $fileName;
        }
		
		return null;
	}
}
