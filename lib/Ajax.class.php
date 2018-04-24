<?php

class Ajax
{

public static $views;


public static function authenticate()
{
	self::$views = 'header-auth.tmpl';
	
	return ['isAuth' => Auth::logIn($_POST['login'], $_POST['password'], $_POST['rememberme'])];
}

public static function logout()
{
  self::$views = 'header-auth.tmpl';
  
  return ['isAuth' => Auth::logIn()];
}

public static function getCheckoutStep()
{
  self::$views = 'checkout-first.tmpl';

  $isAuth = Auth::logIn();

  $content['user_details'] = Model::getUserDetails($isAuth);
  $content['basket_details'] = Model::getBasketDetails($isAuth);
  
  return ['isAuth' => $isAuth, 'content_data' => $content];
}


// public static function see_additional_goods()
// {
// 	self::$views = 'catalog/product_catalog.php';
// 	$model = new catalogModel();
// 	$nStart = $_POST['current_record'];
// 	$count = $_POST['count'];
// 	$data = $_POST['category'];
// 	return ['content_data' => $model->sub_catalog($data, $nStart, $count)];
// }




}