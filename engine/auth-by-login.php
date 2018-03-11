<?php
session_start();
require_once('../../config/config.php');
require_once('../../engine/db.php');

$login = $_POST['login'];
$password = $_POST['password'];
$rememberme = $_POST['rememberme'];

$isAuth = authWithCredential($login, $password, $rememberme);


//
// да, без буферизации похоже не обойтись, если не хотим перезагружать всю страницу, а не только блок логина
//
ob_start();
require '../../templates/header-auth.php';
$str = ob_get_contents();
ob_end_clean();
echo json_encode(['result' => $isAuth, 'html' => $str]);



/*Авторизация пользователя
при использования технологии хэширования паролей
$username - имя пользователя
$password - введенный пользователем пароль
*/
function authWithCredential($username, $password, $rememberme = false) {
	$isAuth = false;
	
	$link = getConnection();
	$login = mysqli_real_escape_string($link, $username);

//	$passHash = password_hash($password, PASSWORD_DEFAULT);
	$sql = "select id_user, login, password from users where login = '$login'";
	$user_data = getRowResult($sql, $link);
	

	if ($user_data) {
		$passHash = $user_data['password'];
		$id_user = $user_data['id_user'];
		$idUserCookie = microtime(true) . rand(100,1000000000000);
		$idUserCookieHash = hash("sha256", $idUserCookie);
		
		if (password_verify($password, $passHash)) {
			$_SESSION['login'] = $username;
			$_SESSION['id_user'] = $id_user;
			$_SESSION['IdUserSession'] = $idUserCookieHash;
			
			$sql = "insert into users_auth (user_id, hash_cookie, date, comment) values ('$id_user', '$idUserCookieHash', now(), $idUserCookie)";
			executeQuery($sql);
	
			if ($rememberme == true) {
				setcookie('idUserCookie', $idUserCookieHash, time() + 3600 * 24 * 7, '/');
			}

			$isAuth = true;
		}	
	}
	
	return $isAuth;	
}

?>