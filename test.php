<?php
require 'src/Ripple/Core/ClassLoader.php';

$loader = new Ripple\Core\ClassLoader('Doctrine', '/path/to/doctrine');
$loader->setNamespaceSeparator('.');
echo $loader->getClassPath('Doctrine.Common.Request');
?>