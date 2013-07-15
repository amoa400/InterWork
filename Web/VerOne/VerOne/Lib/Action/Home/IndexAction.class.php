<?php

class IndexAction extends Action{
	
	public function index(){
		
		//echo(U("Home/Index/register"));
		$this->assign("url_logout", U("Home/Index/logout"));
		$this->assign("url_login",U("Home/Index/login"));
		$this->assign("url_regsiter", U("Home/Index/register"));
		$this->assign("content", "Index:index");
		$this->display("Public:Public:base");
	}
	
	public function register(){
		$this->assign("url_reg_action", U("Home/Index/reg_action"));
		$this->assign("content", "Index:register");
		$this->display("Public:Public:base");
	}
	
	public function reg_action(){
		$inputArr = array();
		$inputArr['name'] = $_POST['name'];
		$inputArr['email'] = $_POST['email'];
		$inputArr['psw'] = $_POST['psw'];
		
		$user = D("Obj/User");
		if($user->add_user( $inputArr )){
			$_SESSION = $inputArr;
			$_SESSION['login'] = true;
			$this->redirect("Home/Index/index", "", 1, "注册成功");
		}
		else{
			$this->redirect("Home/Index/register", "", 1, "邮箱已被注册");
		}
	}
	
	public function login(){
		if($_SESSION['login']){ 
			$this->redirect("Home/Index/index", "", 0, "");
		}
		$user = D("Obj/User");
		$u = $user->where("email='{$_POST["email"]}'")->find();
		//var_dump($_POST);
		//var_dump($u);
		if($u && $u['psw'] == $_POST['psw']){
			$_SESSION = $u;
			$_SESSION['psw'] = NULL;
			$_SESSION['login'] = true;
			$_SESSION['tip'] = false;
		}
		else{
			$_SESSION['tip'] = "用户名或密码错误";
		}
		//var_dump($_SESSION);
		$this->redirect("Home/Index/index", "", 0, "");
	}
	
	public function logout(){
		if($_SESSION['login']){
			$_SESSION['login'] = false;
		}
		$this->redirect("Home/Index/index", "", 0, "");
	}
	
}

?>