<?php

class IndexAction extends Action{
	
	public function index(){
		//$this->redirect("Home/Home/index", 1);
		echo('<a href="'.U('Home/Home/index').'">aaa</a>');
	}
}

?>