<?php
class Basket
{
    private static $_instance = null;

    /*
     * Получаем объект для работы с БД
	 Объект создается один раз, в независимости от количества попыток создания
     */
    public static function getInstance()
    {
        if (self::$_instance == null) {
            self::$_instance = new Basket(); //создается объект класса db, файл db.class.php
        }
        return self::$_instance;
    }

    /*
     * Запрещаем копировать объект
     */
    private function __construct() {}
    private function __sleep() {}
    private function __wakeup() {}
    private function __clone() {}

    
    // ПУБЛИНЫЕ методы работы с корзиной

    public static function read($user_id)
    {
        // return "OK";
        return self::readBasket($user_id);

    }


    public static function clear($user_id)
    {
        return self::clearBasket($user_id);
        
    }


    public static function merge($user_id)
    {
        return self::mergeBaskets($user_id);
        
    }


    public static function replace($user_id)
    {
        self::clearBasket($user_id);
        self::mergeBaskets($user_id);
        return true;
        
    }
	
   
    public static function add($user_id)
    {
        $item = [
          "id" => $_POST['id'],
          "color" => $_POST['color'],
          "size" => $_POST['size'],
          "quantity" => $_POST['quantity'],
          "shipping" => $_POST['shipping']
        ];
        return self::addToBasket($item, $user_id);

    }


    public static function delete($user_id)
    {
        $item = [
          "id" => $_POST['id'],
          "color" => $_POST['cid'],
          "size" => $_POST['sid'],
          "shipping" => $_POST['shid']
        ];
        return self::deleteFromBasket($item, $user_id);
        
    }


    public static function createorder($user_id)
    {
        if (is_null($user_id)) {
          $res = false;
        } else {
          $res = self::createOrderDB($user_id);
        }
        return $res;
        
    }

    public static function deleteorder($isAuth)
    {
        if (is_null($isAuth['id_user']) or $isAuth['status_id'] != 9 ) {
          $res = false;
        } else {
          $res = self::deleteOrderDB($_POST['orderId']);
        }
        if ($res) {
          return true;
        } else {
          return false;
        }
        
        
    }


    // PROTECTED методы

    protected static function readBasket($user_id)
    {

    if (is_null($user_id)) {
        $basketContent = self::getBasketFromCookies();
    } else {
        $basketContent = self::getBasketContentDB($user_id);
    }

    $quantity = 0;
    $total = 0;
    $basket = [
        "result" => true,
        "message" => "OK",
        "subtotal" => "0",
        "total" => "0",
        "quantity" => 0,
        "basket" => []
      ]; // Шаблон для генерации корзины


    foreach ($basketContent as $row) {
        $item = [
          "id" => $row['item_id'], //
          "color_id" => $row['id_color'],
          "name" => $row['items_name'],
          "color" => $row['colors_name'], //
          "size" => $row['sizes_name'], //
          "size_id" => $row['id_size'],
          "price" => '$' . $row['price'],
          "quantity" => $row['quantity'], //
          "shipping" => $row['shipping_name'],
          "shipping_id" => $row['id_shipping'],
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

    return $basket;
    }


    protected static function clearBasket($user_id)
    {
      if (is_null($user_id)) {
        setcookie('basket', "", time() - 3600, '/');
      } else {
        $res = self::clearBasketDB($user_id);
      }
      return $res;
    }


    protected static function mergeBaskets($user_id) {
      if (!is_null($user_id)) {
        $currentBasket = json_decode($_COOKIE['basket'], true);
        foreach ($currentBasket as $row) {
          self::insertIntoBasketDB($row, $user_id);
        }
        setcookie('basket', "", time() - 3600, '/');
      }
    }


    protected static function addToBasket($item, $user_id) {
      if (is_null($user_id)) {
        $currentBasket = json_decode($_COOKIE['basket'], true);
        $currentBasket = self::insertIntoBasketCK($currentBasket, $item);
        setcookie('basket', json_encode($currentBasket), time() + 3600 * 24 * 30, '/');
      } else {
        $res = self::insertIntoBasketDB($item, $user_id);
      }
      return $res;
    }


    protected static function deleteFromBasket($item, $user_id) {
      if (is_null($user_id)) {
        $currentBasket = json_decode($_COOKIE['basket'], true);
        $currentBasket = self::deleteFromBasketCK($currentBasket, $item);
        setcookie('basket', json_encode($currentBasket), time() + 3600 * 24 * 30, '/');
      } else {
        $res = self::deleteFromBasketDB($item, $user_id);
      }
      return $res;
    }


    // ********************************************************
    // PRIVATE методы!!!
    // ********************************************************

    private static function getBasketContentDB($user_id)
    {
      $sql = "select
    basket.user_id,
    basket.item_id,
    basket.quantity,
    basket.is_in_order,
    items.name as items_name,
    items.price,
    items.rating,
    colors.name as colors_name,
    colors.id_color,
    sizes.name as sizes_name,
    sizes.id_size,
    shipping.name as shipping_name,
    shipping.id_shipping,
    ph.url
    from basket inner join items on basket.item_id = items.id_item
    inner join colors on basket.color_id = colors.id_color
    inner join sizes on basket.size_id = sizes.id_size
    inner join shipping on basket.shipping_id = shipping.id_shipping
    left join (select * from photos where type = 0) as ph on ph.item_id = basket.item_id where basket.user_id = ? and basket.is_in_order = '0';";
      return db::getInstance()->Select($sql, [$user_id]);
    }

    private static function getBasketFromCookies() {
      $currentBasket = json_decode($_COOKIE['basket'], true);
      $basketFullData = [];

      foreach ($currentBasket as $row) {
        $itemDetails = self::getItemDetailsFromDB($row['id']);
        $detailsByName = self::getDetailsByName($row['color'], $row['size'], $row['shipping']);

        $item = [
          "item_id" => $row['id'], //
          "colors_name" => $detailsByName['colors_name'], //
          "id_color" => $row['color'],
          "sizes_name" => $detailsByName['sizes_name'], //
          "id_size" => $row['size'],
          "quantity" => $row['quantity'], //
          "shipping_name" => $detailsByName['shipping_name'], //
          "id_shipping" => $row['shipping'],
          "items_name" => $itemDetails[0]['items_name'],
          "price" => $itemDetails[0]['price'],
          "url" => $itemDetails[0]['url'],
          "rating" => $itemDetails[0]['rating'] / 2
        ];
        $basketFullData[] = $item;
      }
      return $basketFullData;
    }

    private static function getItemDetailsFromDB($id)
    {
      $sql = "select
    items.name as items_name,
    items.price,
    items.rating,
    ph.url
    from items 
    left join (select * from photos where type = 0) as ph on ph.item_id = items.id_item where items.id_item = ?;";
      return db::getInstance()->Select($sql, [$id]);
    }

    private static function getDetailsByName($colorId, $sizeId, $shippingId) {
      $sql = "select colors.name as colors_name, sizes.name as sizes_name, shipping.name as shipping_name
    from colors, sizes, shipping where id_color = ? and id_size = ? and id_shipping = ?";
      
      $result = db::getInstance()->Select($sql, [$colorId, $sizeId, $shippingId])[0];

      return $result;
    }

    private static function deleteFromBasketCK($currentBasket, $item) {
      $idKey = null;
      foreach($currentBasket as $key => $row) {
        if ($row['id'] == $item['id'] && $row['color'] == $item['color'] && $row['size'] == $item['size'] && $row['shipping'] == $item['shipping']) {
          $idKey = $key;
          break;
        }
      }

      if (!is_null($idKey) && $currentBasket[$idKey]['quantity'] > 1) {
        $currentBasket[$idKey]['quantity']--;
      } else {
        unset($currentBasket[$idKey]);
      }

      return $currentBasket;
    }

    private static function deleteFromBasketDB($item, $user_id) {
      $itemId = $item['id'];
      $itemColorId = $item['color'];
      $itemSizeId = $item['size'];
      $itemShippingId = $item['shipping'];
      $sqlCheckQuantity = "select quantity from basket where user_id = ? and item_id = ? and color_id = ? and size_id = ? and shipping_id = ? and basket.is_in_order = '0';";

      $currentQuantity = db::getInstance()->Select($sqlCheckQuantity, [$user_id, $itemId, $itemColorId, $itemSizeId, $itemShippingId])[0]['quantity'];

      if (is_null($currentQuantity) || $currentQuantity == 1) {
        $sql = "delete from basket where user_id = ? and item_id = ? and color_id = ? and size_id = ? and shipping_id = ? and basket.is_in_order = '0';";
      } else {
        $sql = "update basket set quantity = quantity - 1 where user_id = ? and item_id = ? and color_id = ? and size_id = ? and shipping_id = ? and basket.is_in_order = '0';";
      }
      
      return db::getInstance()->Query($sql, [$user_id, $itemId, $itemColorId, $itemSizeId, $itemShippingId]);
    }

    private static function clearBasketDB($user_id) {
      $sql = "delete from basket where user_id = ? and basket.is_in_order = '0';";
      return db::getInstance()->Query($sql, [$user_id]);
    }

    private static function insertIntoBasketDB($item, $user_id) {
      $itemId = $item['id'];
      $itemColorId = $item['color'];
      $itemSizeId = $item['size'];
      $itemShippingId = $item['shipping'];
      $itemQuantity = $item['quantity'];
      $sql = "insert into basket values (?, ?, ?, ?, ?, ?, '0');";
      if(!db::getInstance()->Query($sql, [$itemId, $itemColorId, $itemSizeId, $itemQuantity, $itemShippingId, $user_id])) {
        $sql = "update basket set quantity = quantity + ? where user_id = ? and item_id = ? and color_id = ? and size_id = ? and shipping_id = ? and basket.is_in_order = '0';";
        db::getInstance()->Query($sql, [$itemQuantity, $user_id, $itemId, $itemColorId, $itemSizeId, $itemShippingId]);
      }
      return $sql;
    }

    private static function insertIntoBasketCK($currentBasket, $item) {
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


    private static function createOrderDB($user_id) {
      $sql = "insert into orders (quantity, amount, user_id)
    select sum(quantity), sum((quantity * price)) as amount, user_id from basket
    inner join items on id_item = item_id where user_id = ? and basket.is_in_order = '0';";
      if($newOrder = db::getInstance()->InsertAndGetId($sql, [$user_id])) {
        $sql = "update basket set is_in_order = ? where user_id = ? and basket.is_in_order = '0'";
        return db::getInstance()->Query($sql, [$newOrder, $user_id]);
      } else {
        return false;
      }
    }


    private static function deleteOrderDB($orderId) {
      $sql = "update orders set status_id = '100' where id_order = ?";
      return db::getInstance()->Query($sql, [$orderId]);
    }
		
}
?>
