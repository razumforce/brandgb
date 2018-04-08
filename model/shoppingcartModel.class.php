<?php

class shoppingcartModel extends Model
{
    public $view = 'shoppingcart';
    public $title;

    function __construct()
    { 
      parent::__Construct();
      $this->title .= "Shopping cart";

    }



    public function index($data = NULL, $deep = 0) 
    {     


    }





}