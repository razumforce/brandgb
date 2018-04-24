<?php

class checkoutModel extends Model
{
    public $view = 'checkout';
    public $title;

    function __construct()
    { 
      parent::__Construct();
      $this->title .= "Checkout";

    }



    public function index($data = NULL, $deep = 0) 
    {     
      $isAuth = Auth::logIn();
      $result['user_details'] = Model::getUserDetails($isAuth);
      $result['basket_details'] = Model::getBasketDetails($isAuth);
      
      return $result;
    }





}