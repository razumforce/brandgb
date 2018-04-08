<?php
/*
Класс авторизации пользователей
*/
class Auth
{


public static function logIn($login = null, $pass = null, $rememberme = false)
{

	$isAuth = 0;
	
	if ($rememberme == "true")
	{
		$rememberme = true;
	}
	else
	{
		$rememberme = false;
	}

	if (!empty($login))   //Если попытка авторизации через форму, то пытаемся авторизоваться
	{
		$isAuth = self::authWithCredential($login, $pass, $rememberme);
	}
	elseif ($_SESSION['IdUserSession'])    //иначе пытаемся авторизоваться через сессии
	{
		$isAuth = self::checkAuthWithSession($_SESSION['IdUserSession']);
	}
	else // В последнем случае пытаемся авторизоваться через cookie
	{
		$isAuth = self::checkAuthWithCookie();
	}
	
	if (isset($_POST['ExitLogin']))
	{
		$isAuth = self::UserExit();	
	}

	if ($isAuth)
	{
		/*
		$id_user = $_SESSION['IdUserSession'];
		$sql = "select * from users where id_user = (select id_user from users_auth where hash_cookie = '$id_user')";
		$isAuth =  db::getInstance()->Select($sql);
		*/
		
		$sql['sql'] = "select * from users where id_user = (select user_id from users_auth where hash_cookie = :hash_cookie)";
		$sql['param'] = 
			[
				'hash_cookie' => $_SESSION['IdUserSession'],
			];
		$isAuth = db::getInstance()->Select($sql['sql'], $sql['param']);
	}

	return $isAuth;
	
}




/*
Осуществляем удаление всех переменных, отвечающих за авторизацию пользователя.
*/
protected static function UserExit()
{
	//Удаляем запись из БД об авторизации пользователей
	$IdUserSession = $_SESSION['IdUserSession'];
	
	$sql['sql'] = "delete from users_auth where hash_cookie = :IdUserSession";
	$sql['param'] = 
		[
			'IdUserSession' => $IdUserSession,	
		];
	$user_date = db::getInstance()->Query($sql['sql'], $sql['param']);		


	//Удаляем все переменные сессий
	unset($_SESSION['id_user']);
	unset($_SESSION['IdUserSession']);
	unset($_SESSION['login']);
	
	//Удаляем все переменные cookie
	setcookie('idUserCookie','', time() - 3600 * 24 * 7);

	return $isAuth = 0;
}


/*Авторизация пользователя
при использования технологии хэширования паролей
$username - имя пользователя
$password - введенный пользователем пароль
*/
protected static function authWithCredential($username, $password, $rememberme = false)
{
	$isAuth = 0;
	
	$login = $username;
	
	
	$sql['sql'] = "select id_user, login, password from users where login = :login";
	$sql['param'] = 
		[
			'login' => $login,
		];
	$user_date = db::getInstance()->Select($sql['sql'], $sql['param']);	
	

	if ($user_date)
	{
		$passHash = $user_date[0]['password'];
		$id_user = $user_date[0]['id_user'];
		$idUserCookie = microtime(true) . random_int(100, PHP_INT_MAX); //Используется более сложная функция генерации случайных чисел
		$idUserCookieHash = hash("sha256", $idUserCookie);
		if (password_verify($password, $passHash))
		{
		
			$_SESSION['login'] = $username;
			$_SESSION['id_user'] = $id_user;
			$_SESSION['IdUserSession'] = $idUserCookieHash;

			$sql['sql'] = "insert into users_auth (user_id, hash_cookie, date, comment) values (:id_user, :idUserCookieHash, now(), :idUserCookie)";
			$sql['param'] = 
				[
					'id_user' => $id_user,
					'idUserCookieHash' => $idUserCookieHash,
					'idUserCookie' => $idUserCookie
					
				];
			$user_date = db::getInstance()->Query($sql['sql'], $sql['param']);				
			
			
			if ($rememberme == true)
			{
				setcookie('idUserCookie', $idUserCookieHash, time() + 3600 * 24 * 7, '/');
			}
			$isAuth = 1;
		}
		else
		{
			self::UserExit();
		}
	}
	else
	{
		self::UserExit();
	}
	
	return $isAuth;	
}

/* Авторизация при помощи сессий
При переходе между страницами происходит автоматическая авторизация
*/
protected static function checkAuthWithSession($IdUserSession)
{

	$isAuth = 0;

	$hash_cookie = $IdUserSession;

	
	$sql['sql'] = "select users.login, users_auth.* from users_auth INNER JOIN Users on users_auth.user_id = users.id_user where users_auth.hash_cookie = :hash_cookie";
	$sql['param'] = 
		[
			'hash_cookie' => $hash_cookie,
		];
	$user_date = db::getInstance()->Select($sql['sql'], $sql['param']);			
	
	
	
	if ($user_date)
	{
		$isAuth = 1;
		$_SESSION['IdUserSession'] = $IdUserSession;

	}
	else
	{
		$isAuth = 0;
		self::UserExit();
	}
	return $isAuth;
}

protected static function checkAuthWithCookie()
{
	$isAuth = 0;

	$hash_cookie = $_COOKIE['idUserCookie'];

	
	$sql['sql'] = "select * from users_auth where hash_cookie = :hash_cookie";
	$sql['param'] = 
		[
			'hash_cookie' => $hash_cookie,
		];
	$user_date = db::getInstance()->Select($sql['sql'], $sql['param']);		
	
	
	if ($user_date)
	{
		self::checkAuthWithSession($hash_cookie);
		$isAuth = 1;
	}
	else
	{
		$isAuth = 0;
		self::UserExit();
	}

	return $isAuth;
}

	public static function registerUser()
	{
		$email = $_POST['email'];
    $login = $_POST['login'];
    $password = $_POST['password'];

		$passwordHash = password_hash($password, PASSWORD_DEFAULT);

		$sql = "insert into users values (default, ?, ?, ?, '');";

		return db::getInstance()->Query($sql, [$email, $login, $passwordHash]);
	}
	
}
?>
