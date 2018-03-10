<?php

require_once('../../config/config.php');
require_once('../../engine/db.php');

function getBasketContent()
{
  $sql = 'select
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
left join (select * from photos where type = 0) as ph on ph.item_id = basket.item_id;';
  return getAssocResult($sql);
}

function readBasket($basket) {
  $basketContent = getBasketContent();
  $quantity = 0;
  $total = 0;

  foreach ($basketContent as $row) {
    $item = [
      "id" => $row['item_id'],
      "name" => $row['items_name'],
      "color" => $row['colors_name'],
      "size" => $row['sizes_name'],
      "price" => '$' . $row['price'],
      "quantity" => $row['quantity'],
      "shipping" => $row['shipping_name'],
      "amount" => '$' . $row['price'] * $row['quantity'],
      "pic" => $row['url'],
      "rating" => $row['rating'] / 2
    ];
    $basket['basket'][] = $item;
    $quantity += $row['quantity'];
    $total += $row['items.price'] * $row['quantity'];
  }

  $basket['subtotal'] = '$' . $total;
  $basket['total'] = '$' . $total;
  $basket['quantity'] = $quantity;

  echo json_encode($basket);
}




$basket = [
    "result" => true,
    "message" => "OK",
    "subtotal" => "0",
    "total" => "0",
    "quantity" => 0,
    "basket" => []
  ];

$operation = $_GET['request'];

switch ($operation) {
  case 'read':
    readBasket($basket);
  break;

  case 'add':
    $item = [
      "id" => $_GET['id'],
      "color" => $_GET['color'],
      "size" => $_GET['size'],
      "quantity" => $_GET['quantity']
    ];
    addToBasket($basket, $item);
  break;

  case 'delete':
    $itemId = $_GET['id'];
    deleteFromBasket($basket, $itemId);
  break;

  default:
    $basket['result'] = false;
    $basket['message'] = 'Unknown request code';
    echo json_encode($basket);
  break;
}


?>