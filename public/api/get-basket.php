<?php
session_start();

require_once('../../config/config.php');
require_once('../../engine/db.php');
require_once('../../engine/authorize.php');


$basket = [
    "result" => true,
    "message" => "OK",
    "subtotal" => "0",
    "total" => "0",
    "quantity" => 0,
    "basket" => []
  ];

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
    $basket['message'] = $user_id;
  } else {
    $isAuth = false;
  }
}

if (!$isAuth) {
  $user_id = null;
}

switch ($operation) {
  case 'read':
    readBasket($basket, $user_id);
  break;

  case 'add':
    $item = [
      "id" => $_POST['id'],
      "color" => $_POST['color'],
      "size" => $_POST['size'],
      "quantity" => $_POST['quantity'],
      "shipping" => $_POST['shipping']
    ];
    addToBasket($basket, $item, $user_id);
  break;

  case 'merge':
    mergeBaskets($basket, $user_id);
  break;

  case 'delete':
    $itemId = $_POST['id'];
    deleteFromBasket($basket, $itemId, $user_id);
  break;

  default:
    $basket['result'] = false;
    $basket['message'] = 'Unknown request code';
    echo json_encode($basket);
  break;
}




function getBasketContentDB($user_id)
{
  $sql = "select
basket.user_id,
basket.item_id,
basket.quantity,
items.name as items_name,
items.price,
items.rating,
colors.name as colors_name,
sizes.name as sizes_name,
shipping.name as shipping_name,
ph.url
from basket inner join items on basket.item_id = items.id_item
inner join colors on basket.color_id = colors.id_color
inner join sizes on basket.size_id = sizes.id_size
inner join shipping on basket.shipping_id = shipping.id_shipping
left join (select * from photos where type = 0) as ph on ph.item_id = basket.item_id where basket.user_id = '$user_id';";
  return getAssocResult($sql);
}

function getItemDetailsFromDB($id)
{
  $sql = "select
items.name as items_name,
items.price,
items.rating,
ph.url
from items 
left join (select * from photos where type = 0) as ph on ph.item_id = items.id_item where items.id_item = '$id';";
  return getAssocResult($sql);
}

function getIdValues($color, $size, $shipping) {
  $sqlColor = "select colors.id_color as color from colors where colors.code = '$color';";
  $sqlSize = "select sizes.id_size as size from sizes where sizes.name = '$size';";
  $sqlShipping = "select shipping.id_shipping as shipping from shipping where shipping.name = '$shipping';";

  $result = [ 'color' => getAssocResult($sqlColor)[0]['color'],
              'size' => getAssocResult($sqlSize)[0]['size'],
              'shipping' => getAssocResult($sqlShipping)[0]['shipping']];

  return $result;
}

function insertIntoBasketDB($item, $user_id) {
  $idValues = getIdValues($item['color'], $item['size'], $item['shipping']);
  $itemId = $item['id'];
  $itemColorId = $idValues['color'];
  $itemSizeId = $idValues['size'];
  $itemShippingId = $idValues['shipping'];
  $itemQuantity = $item['quantity'];
  $sql = "insert into basket values ('$itemId', '$itemColorId', '$itemSizeId', '$itemQuantity', '$itemShippingId', '$user_id');";
  if(!executeQuery($sql)) {
    $sql = "update basket set quantity = quantity + '$itemQuantity' where user_id = '$user_id' and item_id = '$itemId';";
    executeQuery($sql);
  }
  return true;
}

function insertIntoBasket($currentBasket, $item) {
  $idKey = null;
  foreach($currentBasket as $key => $row) {
    if ($row['id'] == $item['id'] && $row['color'] == $item['color'] && $row['size'] == $item['size'] && $row['shipping'] == $item['shipping']) {
      $idKey = $key;
      break;
    }
  }
  
  if (!is_null($idKey)) {
    $currentBasket[$idKey]['quantity'] += $item['quantity'];
  } else {
    $currentBasket[] = $item;
  }

  return $currentBasket;
}

function getBasketFromCookies() {
  $currentBasket = json_decode($_COOKIE['basket'], true);
  $basketFullData = [];
  foreach ($currentBasket as $row) {
    $itemDetails = getItemDetailsFromDB($row['id']);
    $item = [
      "item_id" => $row['id'], //
      "colors_name" => $row['color'], //
      "sizes_name" => $row['size'], //
      "quantity" => $row['quantity'], //
      "shipping_name" => $row['shipping'], //
      "items_name" => $itemDetails[0]['items_name'],
      "price" => $itemDetails[0]['price'],
      "url" => $itemDetails[0]['url'],
      "rating" => $itemDetails[0]['rating'] / 2
    ];
    $basketFullData[] = $item;
  }
  return $basketFullData;
}

function readBasket($basket, $user_id) {
  if (is_null($user_id)) {
    $basketContent = getBasketFromCookies();
  } else {
    $basketContent = getBasketContentDB($user_id);
  }

  $quantity = 0;
  $total = 0;

  foreach ($basketContent as $row) {
    $item = [
      "id" => $row['item_id'], //
      "name" => $row['items_name'],
      "color" => $row['colors_name'], //
      "size" => $row['sizes_name'], //
      "price" => '$' . $row['price'],
      "quantity" => $row['quantity'], //
      "shipping" => $row['shipping_name'],
      "amount" => '$' . $row['price'] * $row['quantity'],
      "pic" => $row['url'],
      "rating" => $row['rating'] / 2
    ];
    $basket['basket'][] = $item;
    $quantity += $row['quantity'];
    $total += $row['price'] * $row['quantity'];
  }

  $basket['subtotal'] = '$' . $total;
  $basket['total'] = '$' . $total;
  $basket['quantity'] = $quantity;

  echo json_encode($basket);
  // echo json_encode($basketContent);
}

function addToBasket($basket, $item, $user_id) {
  if (is_null($user_id)) {
    $currentBasket = json_decode($_COOKIE['basket'], true);
    $currentBasket = insertIntoBasket($currentBasket, $item);
    setcookie('basket', json_encode($currentBasket), time() + 3600 * 24 * 30, '/');
  } else {
    $res = insertIntoBasketDB($item, $user_id);
  }
  echo json_encode($res);
}

function mergeBaskets($basket, $user_id) {
  if (!is_null($user_id)) {
    $currentBasket = json_decode($_COOKIE['basket'], true);
    foreach ($currentBasket as $row) {
      insertIntoBasketDB($row, $user_id);
    }
    setcookie('basket', "", time() - 3600, '/');
  }
}

?>