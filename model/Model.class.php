<?php

class Model
{
    public $view = 'index';
    public $title;


    function __construct()
    {	
        $this->title = Config::get('sitename');
    }



    public function index($data = NULL, $deep = 0) 
	{

    }


	
	public function __call($methodName, $args) 
	{
    	header("Location: Config::get('domain')/page404/");
	}


  public static function getUserDetails($isAuth) {
  $userDetails = ['login' => '', 'email' => '', 'password' => ''];

  if ($isAuth) {
  $sql['sql'] = "select user_id from users_auth where hash_cookie = :hash_cookie";
  $sql['param'] = 
    [
      'hash_cookie' => $_SESSION['IdUserSession'],
    ];

  $loggedUsers = db::getInstance()->SelectRow($sql['sql'], $sql['param']);
  if ($loggedUsers) {
    $sql['sql'] = "select login, email, password from users where id_user = :user_id";
    $sql['param'] = 
      [
        'user_id' => $loggedUsers['user_id']
      ];
    $userDetails = db::getInstance()->SelectRow($sql['sql'], $sql['param']);
  }
  }

  return $userDetails;
  }

  public static function getBasketDetails($isAuth) {
  $basketDetails = ['quantity_total' => '0', 'amount_total' => '0'];

  if ($isAuth) {
  $sql['sql'] = "select user_id from users_auth where hash_cookie = :hash_cookie";
  $sql['param'] = 
    [
      'hash_cookie' => $_SESSION['IdUserSession']
    ];
  $loggedUsers = db::getInstance()->SelectRow($sql['sql'], $sql['param']);
  if ($loggedUsers) {
    $sql['sql'] = "select sum(quantity) as quantity_total, sum(quantity * items.price) as amount_total from basket
  inner join items on basket.item_id = items.id_item
  where user_id = :user_id and is_in_order = '0'";
    $sql['param'] = 
      [
        'user_id' => $loggedUsers['user_id']
      ];
    $basketDetails = db::getInstance()->SelectRow($sql['sql'], $sql['param']);
    if (is_null($basketDetails['quantity_total'])) {
      $basketDetails = ['quantity_total' => '0', 'amount_total' => '0'];
    }
  }
  }

  return $basketDetails;
  }


  public static function getOrders($isAuth) {
    $orders = [];

    if ($isAuth) {
      $sql['sql'] = "select user_id from users_auth where hash_cookie = :hash_cookie";
      $sql['param'] = 
        [
          'hash_cookie' => $_SESSION['IdUserSession']
        ];
      $loggedUsers = db::getInstance()->SelectRow($sql['sql'], $sql['param']);
      if ($loggedUsers) {
        if ($isAuth[0]['status_id'] == 9) {
          $sql['sql'] = "select orders.id_order, orders.date, orders.quantity, orders.amount, users.login from orders inner join users on orders.user_id = users.id_user where orders.status_id <> '100' order by date desc;";
          $sql['param'] = [];
        } else {
          $sql['sql'] = "select * from orders where user_id = :user_id and orders.status_id <> '100' order by date desc;";
          $sql['param'] = 
            [
              'user_id' => $loggedUsers['user_id']
            ];
        }
        
        $orders = db::getInstance()->Select($sql['sql'], $sql['param']);
      }
    }

    return $orders;
  }



}