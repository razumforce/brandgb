<?php

//Константы ошибок
define('ERROR_NOT_FOUND', 1);
define('ERROR_TEMPLATE_EMPTY', 2);


//Функция получает переменные в зависимости от выбранной страницы. news или newspage или feedback

function prepareVariables($page_name, $isAuth) 
{
	switch ($page_name){
	
		case "index":
			$vars['content'] = '../templates/index.php';
			$vars['featured_product'] = featuredProduct();
		break;
		
		case "single":
			$vars['content'] = '../templates/single.php';
			$vars['maylike_product'] = maylikeProduct();
			$vars['single_item'] = singleItemLoad($_GET['id']);
		break;
		
		case "product":
			$vars['content'] = '../templates/product.php';
		break;

		case "checkout":
			$vars['content'] = '../templates/checkout.php';
			$vars['user_details'] = getUserDetails($isAuth); 
			$vars['basket_details'] = getBasketDetails($isAuth);
		break;
		
		case "shoppingcart":
			$vars['content'] = '../templates/shoppingcart.php';
		break;

		case "profile":
			$vars['content'] = '../templates/profile.php';
			$vars['user_details'] = getUserDetails($isAuth);
			$vars['orders'] = getOrders($isAuth);
		break;

		case "register":
			$vars['content'] = '../templates/register.php';
		break;

	}
	
	
	return $vars;
}


function featuredProduct()
{
	$sql = 'SELECT * FROM photos RIGHT JOIN items on item_id = id_item WHERE type = 0 LIMIT 8;';
	return getAssocResult($sql);
}

function maylikeProduct()
{
	$sql = "SELECT * FROM photos RIGHT JOIN items on item_id = id_item WHERE type = 0 and category_id = '2' LIMIT 4;";
	return getAssocResult($sql);
}

function singleItemLoad($id) {
	$sqlDetails = "select
items.id_item, items.name as items_name, items.description, items.price,
categories.name as categories_name,
materials.name as materials_name,
designers.name as designers_name
from items inner join categories on items.category_id = categories.id_category
inner join materials on items.material_id = materials.id_material
inner join designers on items.designer_id = designers.id_designer
where items.id_item = $id;";

	$sqlColors = "select colors.id_color as id_color, colors.code as color_code, colors.name as color_name
from items_colors inner join colors on items_colors.color_id = colors.id_color where items_colors.item_id = $id;";

	$sqlSizes = "select sizes.id_size as id_size, sizes.name
from items_sizes inner join sizes on items_sizes.size_id = sizes.id_size where items_sizes.item_id = $id;";

	$sqlPics = "select url, type from photos where type <> 0 and item_id = $id;";

	$details = getAssocResult($sqlDetails);
	$colors = getAssocResult($sqlColors);
	$sizes = getAssocResult($sqlSizes);
	$pics = getAssocResult($sqlPics);

	

	$result = [];

	$result['id'] = $id;
	$result['collection'] = $details[0]['categories_name'];
	$result['name'] = $details[0]['items_name'];
	$result['material'] = $details[0]['materials_name'];
	$result['designer'] = $details[0]['designers_name'];
	$result['description'] = $details[0]['description'];
	$result['price'] = $details[0]['price'];

	$result['size'] = $sizes;
	$result['color'] = $colors;

	$activePicSet = false;
	foreach ($pics as $key => $pic) {
		if ($pic['type'] == 2 && !$activePicSet) {
			$pics[$key]['type'] = 'active';
			$activePicSet = true;
		} else {
			$pics[$key]['type'] = '';
		}
	}

	$result['pic'] = $pics;

	return $result;
}

function getUserDetails($isAuth) {
	$userDetails = ['login' => '', 'email' => '', 'password' => ''];

	if ($isAuth) {
	  $link = getConnection();
	  $IdUserSession = $_SESSION['IdUserSession'];
	  $hash_cookie = mysqli_real_escape_string($link, $IdUserSession);
	  $sql = "select user_id from users_auth where hash_cookie = '$hash_cookie'";
	  $loggedUsers = getRowResult($sql, $link);
	  if ($loggedUsers) {
	    $user_id = $loggedUsers['user_id'];
	    $sql = "select login, email, password from users where id_user = '$user_id';";
	    $userDetails = getRowResult($sql, $link);
	  }
	}

	return $userDetails;
}

function getBasketDetails($isAuth) {
	$basketDetails = ['quantity_total' => '0', 'amount_total' => '0'];

	if ($isAuth) {
	  $link = getConnection();
	  $IdUserSession = $_SESSION['IdUserSession'];
	  $hash_cookie = mysqli_real_escape_string($link, $IdUserSession);
	  $sql = "select user_id from users_auth where hash_cookie = '$hash_cookie'";
	  $loggedUsers = getRowResult($sql, $link);
	  if ($loggedUsers) {
	    $user_id = $loggedUsers['user_id'];
	    $sql = "select sum(quantity) as quantity_total, sum(quantity * items.price) as amount_total from basket
inner join items on basket.item_id = items.id_item
where user_id = '$user_id' and is_in_order = '0';";
	    $basketDetails = getRowResult($sql, $link);
	    if (is_null($basketDetails['quantity_total'])) {
	    	$basketDetails = ['quantity_total' => '0', 'amount_total' => '0'];
	    }
	  }
	}

	return $basketDetails;
}

function getOrders($isAuth) {
	$orders = [];

	if ($isAuth) {
	  $link = getConnection();
	  $IdUserSession = $_SESSION['IdUserSession'];
	  $hash_cookie = mysqli_real_escape_string($link, $IdUserSession);
	  $sql = "select user_id from users_auth where hash_cookie = '$hash_cookie'";
	  $loggedUsers = getRowResult($sql, $link);
	  if ($loggedUsers) {
	    $user_id = $loggedUsers['user_id'];
	    $sql = "select * from orders where user_id = '$user_id' order by date desc;";
	    $orders = getAssocResult($sql);
	  }
	}

	return $orders;
}