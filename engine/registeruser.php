<?php
require_once('../../config/config.php');
require_once('../../engine/db.php');

$email = $_POST['email'];
$login = $_POST['login'];
$password = $_POST['password'];

$result = registerUser($email, $login, $password);


echo json_encode($result);




function registerUser($email, $login, $password) {
	$passwordHash = password_hash($password, PASSWORD_DEFAULT);
	$sql = "insert into users values (default, '$email', '$login', '$passwordHash', '');";

	return executeQuery($sql);	
}

?>