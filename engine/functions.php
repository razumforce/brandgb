<?php

//Константы ошибок
define('ERROR_NOT_FOUND', 1);
define('ERROR_TEMPLATE_EMPTY', 2);


//Функция получает переменные в зависимости от выбранной страницы. news или newspage или feedback

function prepareVariables($page_name) 
{
	switch ($page_name){
	
		case "index":
			$vars['content'] = '../templates/index.php';
			$vars['featured_product'] = featuredProduct();
		break;
		
		case "single":
			$vars['content'] = '../templates/single.php';
			$vars['maylike_product'] = maylikeProduct();
			$vars['single_item'] = singleItemLoad();
		break;
		
		case "product":
			$vars['content'] = '../templates/product.php';
		break;

		case "checkout":
			$vars['content'] = '../templates/checkout.php';
		break;
		
		case "shoppingcart":
			$vars['content'] = '../templates/shoppingcart.php';
		break;

	}
	
	
	return $vars;
}


function featuredProduct()
{
	$sql = 'SELECT * FROM photos RIGHT JOIN items on item_id = id_item WHERE small_size = true LIMIT 8;';
	return getAssocResult($sql);
}

function maylikeProduct()
{
	$sql = "SELECT * FROM photos RIGHT JOIN items on item_id = id_item WHERE small_size = true and category_id = '2' LIMIT 4;";
	return getAssocResult($sql);
}

function singleItemLoad() {
	$result = [];

	$result['id'] = 100;
	$result['collection'] = "WOMEN COLLECTION";
	$result['name'] = "NEW ITEM 100";
	$result['material'] = "SILK";
	$result['designer'] = "BINBURHAN";
	$result['description'] = "Compellingly actual ourcing. Progressively syndicate collaborative  before cuttin-edge services. Comple";
	$result['color'] = [
		'color_code' => ["#000000", "#000088"],
		'color_name' => ["Black", "Blue"]
	];
	$result['size'] = ["XL", "M", "S"];
	$result['price'] = "125.77";
	$result['pic'] = [['url' => "./img/single/product-big-photo.png", 'status' => "active"],
										['url' => "./img/single/product-big-photo.png", 'status' => ""]];

	return $result;
}