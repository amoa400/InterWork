<?php

class UserAction extends Action{
	
	public function index(){
		if(!$_SESSION['login']){
			$this->redirect("Home/Index/index", "", 0, "");
		}
		
	}
	
}

?>