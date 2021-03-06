<?php

class IndexAction extends Action{
	
	public function index(){
		/*$reg = "/\b12\b/";
		$match = array();
		$str = "1234;312;3123;12;123;";
		var_dump(preg_match($reg, $str, $match));
		var_dump($match);
		$arr = array("a"=>1, "b"=>2);
		foreach($arr as $i){
			$i = 0;
		}
		var_dump($arr);*/
		if($_SESSION['login']){
			$this->redirect("Profile/User/index", "", 0, "");
		}
		
		$this->assign("url_logout", U("Home/Index/logout"));
		$this->assign("url_login",U("Home/Index/login"));
		$this->assign("url_regsiter", U("Home/Index/register"));
		$this->assign("url_user_profile", U("Profile/User/index"));
		$this->assign("url_interviewee", U("Home/Index/interviewee"));
		$this->assign("content", "Index:index");
		$this->display("Public:Public:base");
	}
	
	public function interviewee(){
		$this->assign("url_enter", U("Interview/Interview/enter_room_ee"));
		$this->assign("url_return", U("Home/Index/index"));
		$this->assign("content", "Index:interviewee");
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
			$_SESSION = $user->where("email='{$inputArr["email"]}'")->find();
			$_SESSION['login'] = true;
			$_SESSION['psw'] = NULL;
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
		$this->redirect("Profile/User/index", "", 0, "");
	}
	
	public function logout(){
		if($_SESSION['login']){
			$_SESSION['login'] = false;
		}
		$this->redirect("Home/Index/index", "", 0, "");
	}
	
}

?>