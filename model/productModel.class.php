<?php

class productModel extends Model
{
    public $view = 'product';
    public $title;

    function __construct()
    { 
      parent::__Construct();
      $this->title .= "Products";

    }



    public function index($data = NULL, $deep = 0) 
    {     


    }


    public function show($data)
    {
        // $this->view .= "/" . __FUNCTION__ . '.php';
        // db::getInstance()->Query('UPDATE `goods` SET `view` = `view` + 1 where id_good = "'. $data['id'] .'"');
        $result['single_item'] = Product::singleItemLoad($data['id']);
        $result['maylike_product'] = Product::maylikeProduct();
        
        
        
        return $result;
         
    }   



}