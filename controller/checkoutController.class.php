<?php

class checkoutController extends Controller
{
    public $view = 'checkout';



public function index()
  {
    $this->view .= "/" . __FUNCTION__ . '.php';

    echo $this->controller_view();
      
  }





}