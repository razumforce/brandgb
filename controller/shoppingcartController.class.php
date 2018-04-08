<?php

class shoppingcartController extends Controller
{
    public $view = 'shoppingcart';



public function index()
  {
    $this->view .= "/" . __FUNCTION__ . '.php';

    
    echo $this->controller_view();
  }





}