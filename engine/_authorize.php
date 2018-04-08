<?php

//
// авторизацию по логину/паролю (через форму на сайте) - и также Logout
// вынес в JS - там будет обработка, общение с сервером, и смена формы
// (в зависимости от результата - прошла авторизация или прошел логаут. также корзина будет refresh делаться)
// здесь просто при начальной загрузке страницы сервер определяет авторизован ли пользователь
// и выводит соответствующую форму в myaccount (ну и кстати корзину тоже соответствующую - КАК ЭТО РЕШИТЬ???)
// корзина то JS - ом рендериться. по идее при отсылке запроса по корзине - сервер проверяет залогинен ли я
// просто эту же функцию auth вызываем и проверяем статус данного пользователя при выдаче данных по корзине
//

function auth()
{
	$isAuth = false;

	
	// var_dump($_SESSION['login']);
	// echo '<br>';

	// var_dump($_SESSION['id_user']);
	// echo '<br>';

	// var_dump($_SESSION['IdUserSession']);
	// echo '<br>';
	// var_dump($_COOKIE);
	// echo '<br>';
	
	if ($_SESSION['IdUserSession'])    //пытаемся авторизоваться через сессии
	{
		$isAuth = checkAuthWithSession($_SESSION['IdUserSession']);
	//	echo "Авторизация по сессии";
	}
	else // иначе пытаемся авторизоваться через cookie
	{
		$isAuth = checkAuthWithCookie();
	//	echo "авторизация по cookie";
	}
	
	// var_dump(password_hash('aaaaaa', PASSWORD_DEFAULT));
	// echo '<br>';

	return $isAuth;
}


/* Авторизация при помощи сессий
При переходе между страницами происходит автоматическая авторизация
*/
function checkAuthWithSession($IdUserSession)
{

	$isAuth = false;

	$link = getConnection();
	$hash_cookie = mysqli_real_escape_string($link, $IdUserSession);
	$sql = "select users.login, users_auth.* from users_auth INNER JOIN users on users_auth.user_id = users.id_user where users_auth.hash_cookie = '$hash_cookie'";
	
	$user_date = getRowResult($sql, $link);
	
	if ($user_date)
	{
		$_SESSION['login'] = $user_date['login'];
		$_SESSION['IdUserSession'] = $IdUserSession;
		$isAuth = true;
	}
	else
	{
		$isAuth = false;
		// UserExit(); // не совсем понятно зачем делать UserExit() ??? мы же вроде не делаем Logout???
	}
	
	return $isAuth;
}

function checkAuthWithCookie()
{
	$isAuth = false;

	$link = getConnection();
	$idUserCookie = $_COOKIE['idUserCookie'];
	$hash_cookie = mysqli_real_escape_string($link, $idUserCookie);
	$sql = "select * from users_auth where hash_cookie = '$hash_cookie'";
	$user_date = getRowResult($sql, $link);
	
	if ($user_date)
	{
		$isAuth = checkAuthWithSession($idUserCookie);
		$isAuth = true;
	}
	else
	{
		$isAuth = false;
		// UserExit(); // не совсем понятно зачем делать UserExit() ??? мы же вроде не делаем Logout???
	}

	return $isAuth;
}


?>