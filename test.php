<?php
require 'src/Ripple/Loader/ClassLoader.php';

$loader = new Ripple\Loader\ClassLoader('Doctrine', '/path/to/doctrine');
echo $loader->getFilePath('Doctrine\\Common\\Request');

echo '<br/><br/>';

$loader = new Ripple\Loader\FileLoader('views', '/path/to/app', '.php');
$loader->setNamespaceSeparator('.');
echo $loader->getFilePath('views.settings.user.edit');
?>