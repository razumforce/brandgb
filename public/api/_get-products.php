<?php

require_once('../../config/config.php');
require_once('../../engine/db.php');

function getItemsFromDb($page, $itemsPerPage, $sortBy)
{
  $result = [];

  $limitStart = ($page - 1) * ($itemsPerPage);

  $sqlCount = "select count(*) from items";
  $sqlItems = "select distinct
id_item as id, name, price, ph.url as pic
from items 
left join (select * from photos where type = 0) as ph on ph.item_id = items.id_item
group by id_item order by $sortBy
limit $limitStart,$itemsPerPage;";

  $result['count'] = getAssocResult($sqlCount)[0]['count(*)'];
  $result['items'] = getAssocResult($sqlItems);

  return $result;
}

function sendItems($products, $page, $itemsPerPage, $sortBy) {
  $result = getItemsFromDb($page, $itemsPerPage, $sortBy);

  $products['total'] = $result['count'];
  $products['items'] = $result['items'];

  echo json_encode($products);
}


$products = [
    "result" => true,
    "message" => "OK",
    "total" => "0",
    "items" => []
  ];

$page = $_GET['page'];
$itemsPerPage = $_GET['items'];
$sortBy = $_GET['sort'];

sendItems($products, $page, $itemsPerPage, $sortBy);
?>