<?php
namespace Ripple\View\Drivers;


/**
 * A simple php view driver. The view is a valid php file.
 *
 * @since 0.1.0
 * @author	James Tracy <james.a.tracy@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 */
class SimpleDriver implements ViewDriverInterface
{
    /** 
     * Render the view and return the output string.
     * @since 0.1.0
     * @param string $path
     * @param array $params View parameters
     * @return string
     */
    public function render($path, $params = array())
    {
        extract($params);
        
        ob_start();
        
        try {
            include $path;
        } catch(\Exception $e) {
            // throw away the output
            ob_get_clean();
            throw $e;
        }
        
        return ob_get_clean();
    }
};
?>