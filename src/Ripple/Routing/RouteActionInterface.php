<?php
namespace Ripple\Routing;

use \Ripple\HTTP\Request;

/**
 * Interface for a RouteAction class.
 *
 * @since 0.1.0
 * @author	James Tracy <james.a.tracy@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 */
interface RouteActionInterface
{
    /**
     * Executes the action and returns the action's response.
     * This should be a valid Response object.
     * @since 0.1.0
     * @param Ripple\HTTP\Request $request The active request object
     * @param array $args Optional parameters to pass along with the action
     * @return Ripple\HTTP\Response
     * @throws \RuntimeException
     */
    public function run(Request $request, $args = array());
};
?>