<?php
	
class CompanyAction extends Action{
	
	public function index(){
	
	}
	
	public function create(){
		if(!$_SESSION['login']){
			$this->redirect("Home/Index/index", "", 0, "");
		}
		
		$this->assign("url_create_action", U("Profile/Company/create_a"));
	
		$this->assign("content", "Company:create");
		$this->display("Public:Public:base");
	}
	
	public function create_a(){
		if(!$_SESSION['login']){
			$this->redirect("Home/Index/index", "", 0, "");
		}
		$inputArr = array();
		$inputArr['name'] = $_POST['name'];
		$inputArr['creator'] = $_SESSION['name'];
		$inputArr['represent'] = $_POST['represent'];
		$inputArr['tele'] = $_POST['phone'];
		$inputArr['email'] = $_POST['email'];
		
		var_dump($inputArr);
		if(D("Obj/Company")->add_company($inputArr)){
			$temp = D("Obj/Company")->where($inputArr)->find();
			if(D("Relation/Belongs")->
						add_belong(array(
							'cid'=>$temp['cid'], 
							'uid'=>$_SESSION['uid'], 
							'group'=>1
						))){
				$this->redirect("Profile/Company/index", "", 1, "创建成功");
			}
			$this->redirect("Profile/User/index", "", 5, "创建失败____");
		}
		else{
			$this->redirect("Profile/User/index", "", 1, "创建失败");
		}
	}
	
	public function join(){
		if($_GET['name']){
			$companys = D("Obj/Company")->where("name REGEXP '.*{$_GET['name']}.*'")->select();
			$this->assign("companys", $companys);
		}
		
		$this->assign("url_self", U("Profile/Company/join"));
		$this->assign("url_company_profile", U("Profile/Company/index"));
		$this->assign("url_join_action", U("Profile/Company/join_a"));
		$this->assign("content", "Company:join");
		$this->display("Public:Public:base");
	}
	
	public function join_a(){
		if(!$_SESSION['login']){
			$this->redirect("Home/Index/index", "", 0, "");
		}
		if(!$_GET['cid']){
			$this->redirect("Profile/User/index", "", 0, "");
		}
		$C = D("Obj/Company");
		$tar = $C->where("cid={$_GET['cid']}")->find();
		if(!$tar){
			$this->redirect("Profile/User/index", "", 1, "所指定的公司不存在");
		}
		$R = D("Relation/Belongs");
		$inputArr = array();
		$inputArr['cid'] = $_GET['cid'];
		$inputArr['uid'] = $_SESSION['uid'];
		$inputArr['group'] = 0;
		if($R->add_belong($inputArr)){
			$this->redirect("Profile/User/index", "", 1, "申请成功");
		}
		else{
			$this->redirect("Profile/User/index", "", 1, "申请失败");
		}
	}
	
}
	
?>