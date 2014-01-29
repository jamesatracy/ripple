<?php
namespace Ripple\View\Drivers;


/**
 * View Driver Interface.
 *
 * @since 0.1.0
 * @author	James Tracy <james.a.tracy@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 */
interface ViewDriverInterface
{
    /** 
     * Render the view and return the output string.
     * @since 0.1.0
     * @param string $path
     * @param array $params View parameters
     * @return string
     */
    public function render($path, $params = array());
};
?>