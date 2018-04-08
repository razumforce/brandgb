<?php

class IndexModel extends Model
{
    public $view = 'index';
    public $title;

    function __construct()
    {	
		  parent::__Construct();
		  $this->title .= "Главная страница";

    }



    public function index($data = NULL, $deep = 0) 
    {			
		  $result['featured_product'] = Product::featuredProduct();
		  return $result;
    }





}