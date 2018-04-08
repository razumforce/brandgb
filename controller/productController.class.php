<?php

class productController extends Controller
{
    public $view = 'product';



  public function index()
  {
    $this->view .= "/" . __FUNCTION__ . '.php';

    echo $this->controller_view();
      
  }


  public function show()
  {
    $this->view .= "/" . __FUNCTION__ . '.php';

    echo $this->controller_view($_GET);
  }




}