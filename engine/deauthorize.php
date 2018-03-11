<?php
session_start();
require_once('../../config/config.php');
require_once('../../engine/db.php');

$isAuth = userLogout();


//
// да, без буферизации похоже не обойтись, если не хотим перезагружать всю страницу, а не только блок логина
//
ob_start();
require '../../templates/header-auth.php';
$str = ob_get_contents();
ob_end_clean();
echo json_encode($str);



/*
Осуществляем удаление всех переменных, отвечающих за авторизацию пользователя.
*/
function userLogout()
{
	//Удаляем запись из БД об авторизации пользователей
	$IdUserSession = $_SESSION['IdUserSession'];
	$sql = "delete from users_auth where hash_cookie = '$IdUserSession'";
	executeQuery($sql);
	
	//Удаляем все переменные сессий
	unset($_SESSION['id_user']);
	unset($_SESSION['IdUserSession']);
	unset($_SESSION['login']);
	
	//Удаляем все переменные cookie
	setcookie('idUserCookie','', time() - 3600 * 24 * 7);

	session_destroy();

	return $isAuth = 0;
}

?>