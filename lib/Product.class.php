<?php

class Product 
{
	public static function featuredProduct($quantity = 8, $sort = 'desc')
	{
		return db::getInstance()->Select("SELECT * FROM photos RIGHT JOIN items ON item_id = id_item WHERE type = 0 LIMIT $quantity;");
	}

	// public static function NewProduct($quantity = 3, $sort = 'desc')
	// {
	// 	return db::getInstance()->Select("select * from goods order by date $sort limit $quantity;");
	// }
	
	// public static function StatusProduct($quantity = 3, $status = 2, $sort = 'desc')
	// {
	// 	return db::getInstance()->Select("select * from goods where status = '$status' order by view $sort limit $quantity;");
	// }

	public static function catalog()
	{
		$products = [
	    "result" => true,
	    "message" => "OK",
	    "total" => "0",
	    "items" => []
	  ];

		$page = $_POST['page'];
		$itemsPerPage = $_POST['items'];
		$sortBy = $_POST['sort'];

		$result = self::getItemsFromDb($page, $itemsPerPage, $sortBy);

	  $products['total'] = $result['count'];
	  $products['items'] = $result['items'];


	  return $products;

	}


	public static function maylikeProduct($quantity = 4, $categoryId = 2, $sort = 'desc')
	{
		$sql = "SELECT * FROM photos RIGHT JOIN items on item_id = id_item WHERE type = 0 and category_id = '$categoryId' LIMIT $quantity;";
		return db::getInstance()->Select($sql);
	}


	public static function singleItemLoad($id) {
		$sqlDetails = "select
	items.id_item, items.name as items_name, items.description, items.price,
	categories.name as categories_name,
	materials.name as materials_name,
	designers.name as designers_name
	from items inner join categories on items.category_id = categories.id_category
	inner join materials on items.material_id = materials.id_material
	inner join designers on items.designer_id = designers.id_designer
	where items.id_item = ?;";

		$sqlColors = "select colors.id_color as id_color, colors.code as color_code, colors.name as color_name
	from items_colors inner join colors on items_colors.color_id = colors.id_color where items_colors.item_id = ?;";

		$sqlSizes = "select sizes.id_size as id_size, sizes.name
	from items_sizes inner join sizes on items_sizes.size_id = sizes.id_size where items_sizes.item_id = ?;";

		$sqlPics = "select url, type from photos where type <> 0 and item_id = ?;";

		$details = db::getInstance()->Select($sqlDetails, [$id]);
		$colors = db::getInstance()->Select($sqlColors, [$id]);
		$sizes = db::getInstance()->Select($sqlSizes, [$id]);
		$pics = db::getInstance()->Select($sqlPics, [$id]);

		

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


	private static function getItemsFromDb($page, $itemsPerPage, $sortBy)
	{
	  $result = [];

	  $limitStart = ($page - 1) * ($itemsPerPage);

	  $sqlCount = "select count(*) from items";
	  $sqlItems = "select distinct id_item as id, name, price, ph.url as pic from items left join (select * from photos where type = 0) as ph on ph.item_id = items.id_item group by id_item order by $sortBy limit $limitStart, $itemsPerPage";


	  $result['count'] = db::getInstance()->Select($sqlCount)[0]['count(*)'];
	  $result['items'] = db::getInstance()->Select($sqlItems);

	  return $result;
	}

}