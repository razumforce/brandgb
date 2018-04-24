<?php

class profileController extends Controller
{
    public $view = 'profile';



public function index()
  {
    $this->view .= "/" . __FUNCTION__ . '.php';

    echo $this->controller_view();
      
  }





}