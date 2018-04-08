<?php

class registerController extends Controller
{
    public $view = 'register';



public function index()
  {
    $this->view .= "/" . __FUNCTION__ . '.php';

    echo $this->controller_view();
      
  }





}