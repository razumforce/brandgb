<?php
session_start();
require_once('../../config/config.php');
require_once('../../engine/functions.php');
require_once('../../engine/db.php');
require_once('../../engine/authorize.php');


$isAuth = auth();

if ($isAuth) {
	$content['user_details'] = getUserDetails($isAuth); 
  $content['basket_details'] = getBasketDetails($isAuth);
}

ob_start();
require '../../templates/checkout-first.php';
$str = ob_get_contents();
ob_end_clean();
echo json_encode($str);


?>