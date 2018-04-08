<?php
// session_start();

// require_once('../../config/config.php');
// require_once('../../engine/db.php');
// require_once('../../engine/authorize.php');


// $basket = [
//     "result" => true,
//     "message" => "OK",
//     "subtotal" => "0",
//     "total" => "0",
//     "quantity" => 0,
//     "basket" => []
//   ];

$operation = $_POST['request'];

$isAuth = auth();

if ($isAuth) {
  $link = getConnection();
  $IdUserSession = $_SESSION['IdUserSession'];
  $hash_cookie = mysqli_real_escape_string($link, $IdUserSession);
  $sql = "select user_id from users_auth where hash_cookie = '$hash_cookie'";
  $loggedUsers = getRowResult($sql, $link);
  if ($loggedUsers) {
    $user_id = $loggedUsers['user_id'];
  } else {
    $isAuth = false;
  }
}

if (!$isAuth) {
  $user_id = null;
}

switch ($operation) {
  // case 'read':
  //   readBasket($basket, $user_id);
  // break;

  // case 'add':
  //   $item = [
  //     "id" => $_POST['id'],
  //     "color" => $_POST['color'],
  //     "size" => $_POST['size'],
  //     "quantity" => $_POST['quantity'],
  //     "shipping" => $_POST['shipping']
  //   ];
  //   addToBasket($item, $user_id);
  // break;

  // case 'merge':
  //   mergeBaskets($user_id);
  //   echo json_encode(true);
  // break;

  // case 'replace':
  //   clearBasket($user_id);
  //   mergeBaskets($user_id);
  //   echo json_encode(true);
  // break;

  // case 'delete':
  //   $item = [
  //     "id" => $_POST['id'],
  //     "color" => $_POST['cid'],
  //     "size" => $_POST['sid'],
  //     "shipping" => $_POST['shid']
  //   ];
  //   deleteFromBasket($item, $user_id);
  // break;

  // case 'clearbasket':
  //   clearBasket($user_id);
  //   echo json_encode($res);
  // break;

  // case 'createorder':
  //   $orderCreated = createOrder($user_id);
  //   echo json_encode($orderCreated);
  // break;

  default:
    $basket['result'] = false;
    $basket['message'] = 'Unknown request code';
    echo json_encode($basket);
  break;
}


// MAIN FUNCTIONS for CRUD

// function readBasket($basket, $user_id) {
//   if (is_null($user_id)) {
//     $basketContent = getBasketFromCookies();
//   } else {
//     $basketContent = getBasketContentDB($user_id);
//   }

//   $quantity = 0;
//   $total = 0;

//   foreach ($basketContent as $row) {
//     $item = [
//       "id" => $row['item_id'], //
//       "color_id" => $row['id_color'],
//       "name" => $row['items_name'],
//       "color" => $row['colors_name'], //
//       "size" => $row['sizes_name'], //
//       "size_id" => $row['id_size'],
//       "price" => '$' . $row['price'],
//       "quantity" => $row['quantity'], //
//       "shipping" => $row['shipping_name'],
//       "shipping_id" => $row['id_shipping'],
//       "amount" => '$' . $row['price'] * $row['quantity'],
//       "pic" => $row['url'],
//       "rating" => $row['rating'] / 2
//     ];
//     $basket['basket'][] = $item;
//     $quantity += $row['quantity'];
//     $total += $row['price'] * $row['quantity'];
//   }

//   $basket['subtotal'] = '$' . $total;
//   $basket['total'] = '$' . $total;
//   $basket['quantity'] = $quantity;

//   echo json_encode($basket);
//   // echo json_encode($basketContent);
// }

// function addToBasket($item, $user_id) {
//   if (is_null($user_id)) {
//     $currentBasket = json_decode($_COOKIE['basket'], true);
//     $currentBasket = insertIntoBasketCK($currentBasket, $item);
//     setcookie('basket', json_encode($currentBasket), time() + 3600 * 24 * 30, '/');
//   } else {
//     $res = insertIntoBasketDB($item, $user_id);
//   }
//   echo json_encode($res);
// }

// function deleteFromBasket($item, $user_id) {
//   if (is_null($user_id)) {
//     $currentBasket = json_decode($_COOKIE['basket'], true);
//     $currentBasket = deleteFromBasketCK($currentBasket, $item);
//     setcookie('basket', json_encode($currentBasket), time() + 3600 * 24 * 30, '/');
//   } else {
//     $res = deleteFromBasketDB($item, $user_id);
//   }
//   echo json_encode($res);
// }

// function mergeBaskets($user_id) {
//   if (!is_null($user_id)) {
//     $currentBasket = json_decode($_COOKIE['basket'], true);
//     foreach ($currentBasket as $row) {
//       insertIntoBasketDB($row, $user_id);
//     }
//     setcookie('basket', "", time() - 3600, '/');
//   }
// }

// function clearBasket($user_id) {
//   if (is_null($user_id)) {
//     setcookie('basket', "", time() - 3600, '/');
//   } else {
//     $res = clearBasketDB($user_id);
//   }
//   return $res;
// }

// function createOrder($user_id) {
//   if (is_null($user_id)) {
//     $res = false;
//   } else {
//     $res = createOrderDB($user_id);
//   }
//   return $res;
// }


// helper functions

// function createOrderDB($user_id) {
//   $sql = "insert into orders (quantity, amount, user_id)
// select sum(quantity), sum((quantity * price)) as amount, user_id from basket
// inner join items on id_item = item_id where user_id = '$user_id' and basket.is_in_order = '0';";
//   if($newOrder = insertAndGetId($sql)) {
//     $sql = "update basket set is_in_order = '$newOrder' where user_id = '$user_id' and basket.is_in_order = '0'";
//     return executeQuery($sql);
//   } else {
//     return false;
//   }
// }


// function getBasketContentDB($user_id)
// {
//   $sql = "select
// basket.user_id,
// basket.item_id,
// basket.quantity,
// basket.is_in_order,
// items.name as items_name,
// items.price,
// items.rating,
// colors.name as colors_name,
// colors.id_color,
// sizes.name as sizes_name,
// sizes.id_size,
// shipping.name as shipping_name,
// shipping.id_shipping,
// ph.url
// from basket inner join items on basket.item_id = items.id_item
// inner join colors on basket.color_id = colors.id_color
// inner join sizes on basket.size_id = sizes.id_size
// inner join shipping on basket.shipping_id = shipping.id_shipping
// left join (select * from photos where type = 0) as ph on ph.item_id = basket.item_id where basket.user_id = '$user_id' and basket.is_in_order = '0';";
//   return getAssocResult($sql);
// }

// function getBasketFromCookies() {
//   $currentBasket = json_decode($_COOKIE['basket'], true);
//   $basketFullData = [];
//   foreach ($currentBasket as $row) {
//     $itemDetails = getItemDetailsFromDB($row['id']);
//     $detailsByName = getDetailsByName($row['color'], $row['size'], $row['shipping']);
//     $item = [
//       "item_id" => $row['id'], //
//       "colors_name" => $detailsByName['colors_name'], //
//       "id_color" => $row['color'],
//       "sizes_name" => $detailsByName['sizes_name'], //
//       "id_size" => $row['size'],
//       "quantity" => $row['quantity'], //
//       "shipping_name" => $detailsByName['shipping_name'], //
//       "id_shipping" => $row['shipping'],
//       "items_name" => $itemDetails[0]['items_name'],
//       "price" => $itemDetails[0]['price'],
//       "url" => $itemDetails[0]['url'],
//       "rating" => $itemDetails[0]['rating'] / 2
//     ];
//     $basketFullData[] = $item;
//   }
//   return $basketFullData;
// }

// function getItemDetailsFromDB($id)
// {
//   $sql = "select
// items.name as items_name,
// items.price,
// items.rating,
// ph.url
// from items 
// left join (select * from photos where type = 0) as ph on ph.item_id = items.id_item where items.id_item = '$id';";
//   return getAssocResult($sql);
// }

// function getDetailsByName($colorId, $sizeId, $shippingId) {
//   $sql = "select colors.name as colors_name, sizes.name as sizes_name, shipping.name as shipping_name
// from colors, sizes, shipping where id_color = '$colorId' and id_size = '$sizeId' and id_shipping = '$shippingId';";
  
//   $result = getAssocResult($sql)[0];

//   return $result;
// }

// function deleteFromBasketCK($currentBasket, $item) {
//   $idKey = null;
//   foreach($currentBasket as $key => $row) {
//     if ($row['id'] == $item['id'] && $row['color'] == $item['color'] && $row['size'] == $item['size'] && $row['shipping'] == $item['shipping']) {
//       $idKey = $key;
//       break;
//     }
//   }

//   if (!is_null($idKey) && $currentBasket[$idKey]['quantity'] > 1) {
//     $currentBasket[$idKey]['quantity']--;
//   } else {
//     unset($currentBasket[$idKey]);
//   }

//   return $currentBasket;
// }

// function deleteFromBasketDB($item, $user_id) {
//   $itemId = $item['id'];
//   $itemColorId = $item['color'];
//   $itemSizeId = $item['size'];
//   $itemShippingId = $item['shipping'];
//   $sqlCheckQuantity = "select quantity from basket where user_id = '$user_id' and item_id = '$itemId' and color_id = '$itemColorId' and size_id = '$itemSizeId' and shipping_id = '$itemShippingId' and basket.is_in_order = '0';";

//   $currentQuantity = getAssocResult($sqlCheckQuantity)[0]['quantity'];

//   if (is_null($currentQuantity) || $currentQuantity == 1) {
//     $sql = "delete from basket where user_id = '$user_id' and item_id = '$itemId' and color_id = '$itemColorId' and size_id = '$itemSizeId' and shipping_id = '$itemShippingId' and basket.is_in_order = '0';";
//   } else {
//     $sql = "update basket set quantity = quantity - 1 where user_id = '$user_id' and item_id = '$itemId' and color_id = '$itemColorId' and size_id = '$itemSizeId' and shipping_id = '$itemShippingId' and basket.is_in_order = '0';";
//   }
  
//   return executeQuery($sql);
// }

// function clearBasketDB($user_id) {
//   $sql = "delete from basket where user_id = '$user_id' and basket.is_in_order = '0';";
//   return executeQuery($sql);
// }

// function insertIntoBasketDB($item, $user_id) {
//   $itemId = $item['id'];
//   $itemColorId = $item['color'];
//   $itemSizeId = $item['size'];
//   $itemShippingId = $item['shipping'];
//   $itemQuantity = $item['quantity'];
//   $sql = "insert into basket values ('$itemId', '$itemColorId', '$itemSizeId', '$itemQuantity', '$itemShippingId', '$user_id', '0');";
//   if(!executeQuery($sql)) {
//     $sql = "update basket set quantity = quantity + '$itemQuantity' where user_id = '$user_id' and item_id = '$itemId' and color_id = '$itemColorId' and size_id = '$itemSizeId' and shipping_id = '$itemShippingId' and basket.is_in_order = '0';";
//     executeQuery($sql);
//   }
//   return $sql;
// }

// function insertIntoBasketCK($currentBasket, $item) {
//   $idKey = null;
//   foreach($currentBasket as $key => $row) {
//     if ($row['id'] == $item['id'] && $row['color'] == $item['color'] && $row['size'] == $item['size'] && $row['shipping'] == $item['shipping']) {
//       $idKey = $key;
//       break;
//     }
//   }
  
//   if (!is_null($idKey)) {
//     $currentBasket[$idKey]['quantity'] += $item['quantity'];
//   } else {
//     $currentBasket[] = $item;
//   }

//   return $currentBasket;
// }



?>