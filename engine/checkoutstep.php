<?php
session_start();
require_once('../../config/config.php');
require_once('../../engine/db.php');
require_once('../../engine/authorize.php');


$isAuth = auth();

if ($isAuth) {
	// set user details, to show in checkout-first.php true part
}

ob_start();
require '../../templates/checkout-first.php';
$str = ob_get_contents();
ob_end_clean();
echo json_encode($str);


?>