<?php

class IndexController extends Controller
{
    public $view = 'index';



public function index()
	{
		$this->view .= "/" . __FUNCTION__ . '.php';

		echo $this->controller_view();
			
	}





}