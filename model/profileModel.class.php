<?php

class profileModel extends Model
{
    public $view = 'profile';
    public $title;

    function __construct()
    { 
      parent::__Construct();
      $this->title .= "Личный кабинет";

    }



    public function index($data = NULL, $deep = 0) 
    {     
      $isAuth = Auth::logIn();
      $result['user_details'] = Model::getUserDetails($isAuth);
      $result['orders'] = Model::getOrders($isAuth);
      
      return $result;
    }





}