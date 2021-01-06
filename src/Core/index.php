<?php
require('CouponController.php'); //example api route file
require('SourceFunction.php'); // source file 



$route = new CouponController();
$methods['className'] = getClassName($route);
$methods['apiRoute'] = getMethodInformationFromClass($route);
$route = setRouteStyle($methods);

$d = writeRouteToFile($route, 'web.php');
$myFile = fopen("web.php", "r");
$content = fread($myFile, filesize("web.php"));
fclose($myFile);
echo $myFile;
?>
