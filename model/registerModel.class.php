<?php

class registerModel extends Model
{
    public $view = 'profile';
    public $title;

    function __construct()
    { 
      parent::__Construct();
      $this->title .= "Регистрация нового пользователя";

    }



    public function index($data = NULL, $deep = 0) 
    {     


    }





}