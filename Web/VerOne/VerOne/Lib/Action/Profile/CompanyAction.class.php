<?php
	
class CompanyAction extends Action{
	
	public function index(){
		if(!$_SESSION['login'] || !$_GET['cid']){
			$this->redirect("Home/Index/index", "", 0, "");
		}
		$relation = D("Relation/Belongs")->where("uid={$_SESSION["uid"]} AND cid={$_GET["cid"]}")->find();
		if(!$relation){
			$this->redirect("Profile/User/index", "", 0, "");
		}
		$p = D("Permission/Group")->where("id={$relation["group"]}")->find();
		$company = D("Obj/Company")->where("cid={$relation["cid"]}")->find();
		
		$appcode = D("Permission/Group")->where("code=0")->find();
		/*
		$temp = D("Permission/Group")->where("id!=0")->select();
		$permissions = array();
		foreach($temp as $i){
			$permissions[$i['id']] = $i['name'];
		}
		*/
		if($p['code'] & 32){
			//$members = D("Relation/Belongs")->where("cid={$_GET["cid"]} AND group!={$appcode["id"]}")->select();
			$apps = D("Relation/Belongs")->where("`cid`={$_GET["cid"]} AND `group`={$appcode["id"]}")->select();
			//var_dump($relation);
			$app_names = array();
			$user = D("Obj/User");
			foreach($apps as $i){
				$app_names[$i['uid']] = $user->where("uid={$i["uid"]}")->find();
			}
	
			//$this->assign("members", $members);
			$this->assign("apps", $apps);
			$this->assign("app_names", $app_names);
		}
		/*
		if($p['code'] & 1){
			$interviews = D("Obj/Interview")->where("cid={$_GET["cid"]}")->select();
		}
		*/
		$this->assign("relation", $relation);
		$this->assign("permission", $p);
		//$this->assign("permissions", $permissions);
		$this->assign("company", $company);
		
		$this->assign("url_show_members", U("Profile/Company/show_members"));
		$this->assign("url_pass_app", U("Profile/Company/pass_app"));
		$this->assign("url_company_member", U("Profile/Company/member"));
		$this->assign("url_return", U("Profile/User/index"));
		$this->assign("content", "Company:index");
		$this->display("Public:Public:base");
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
		$admin = D("Permission/Group")->where("code=2147483647")->find();
		//var_dump($inputArr);
		if(D("Obj/Company")->add_company($inputArr)){
			$temp = D("Obj/Company")->where($inputArr)->find();
			if(D("Relation/Belongs")->
						add_belong(array(
							'cid'=>$temp['cid'], 
							'uid'=>$_SESSION['uid'], 
							'group'=>$admin['id']
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
		
		$this->assign("value", $_GET['name']);
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
		$app = D("Permission/Group")->where("code=0")->find();
		$inputArr = array();
		$inputArr['cid'] = $_GET['cid'];
		$inputArr['uid'] = $_SESSION['uid'];
		$inputArr['group'] = $app['id'];
		if($R->add_belong($inputArr)){
			$this->redirect("Profile/User/index", "", 1, "申请成功");
		}
		else{
			$this->redirect("Profile/User/index", "", 1, "申请失败");
		}
	}
	
	public function pass_app(){
		if(!$_SESSION['login']){
			$this->redirect("Home/Index/index", "", 0, "");
		}
		$relation = D("Relation/Belongs")->where("uid={$_SESSION["uid"]} AND cid={$_POST["cid"]}")->find();
		$p = D("Permission/Group")->where("id={$relation["group"]}")->find();
		
		if($p['code'] & 32){
			$R = D("Relation/Belongs");
			$update = $R->where("uid={$_POST["uid"]} AND cid={$_POST["cid"]}")->find();
			$member = D("Permission/Group")->where("code=1")->find();
			$update['group'] = $member['id'];
			if($R->modify_belong($update)){
				$this->redirect("Profile/Company/index", "cid={$_POST['cid']}", 1, "修改成功");
			}
			else{
				$this->redirect("Profile/Company/index", "cid={$_POST['cid']}", 1, "修改失败");
			}
		}
		else{
			$this->redirect("Profile/Company/index", "cid={$_POST['cid']}", 1, "权限不足");
		}
		
	}
	
	public function show_members(){
		if(!$_SESSION['login']){
			$this->redirect("Home/Index/index", "", 0, "");
		}
		$relation = D("Relation/Belongs")->where("uid={$_SESSION["uid"]} AND cid={$_GET["cid"]}")->find();
		if(!$relation){
			$this->redirect("Profile/User/index", "", 0, "");
		}
		$p = D("Permission/Group")->where("id={$relation["group"]}")->find();
		
		if($p['code'] & 32){
				
			$temp = D("Permission/Group")->where("id!=0")->select();
			$permissions = array();
			foreach($temp as $i){
				$permissions[$i['id']] = $i;
			}	
			
			$members = D("Relation/Belongs")->where("cid={$_GET["cid"]}")->select();
			$member_details = array();
			$user = D("Obj/User");
			foreach($members as $one){
				$member_details[$one['uid']] = $user->where("uid={$one["uid"]}")->find();
			}
			
			//$this->assign("url_ajax", U("Profile/Company/ajax"));
			$this->assign("url_modify_pm", U("Profile/Company/modify_pm"));
			
			$this->assign("permissions", $permissions);
			$this->assign("members", $members);
			$this->assign("member_details", $member_details);
			$this->assign("content", "Company:show_members");
			$this->assign("url_return", U("Profile/Company/index"));
			$this->display("Public:Public:base");
			//var_dump($member_details);
		}
		else{
			$this->redirect("Profile/Company/index", "cid={$_GET['cid']}", 1, "权限不足");
		}
	}
	
	public function modify_pm(){
		//var_dump($_POST);
		if(!$_SESSION['login']){
			$this->redirect("Home/Index/index", "", 0, "1");
		}
		$relation = D("Relation/Belongs")->where("uid={$_SESSION["uid"]} AND cid={$_POST["cid"]}")->find();
		if(!$relation){
			$this->redirect("Profile/User/index", "", 0, "2");
		}
		$p = D("Permission/Group")->where("id={$relation["group"]}")->find();
		
		if($p['code'] & 32){
			$group = D("Permission/Group")->where("id={$_POST["group"]}")->find();
			if($group){
				$belongs = D("Relation/Belongs");
				foreach($_POST["who"] as $one){
					$update = $belongs->where("uid={$one} AND cid={$_POST["cid"]}")->find();
					if($update){
						$update['group'] = (int)$_POST['group'];
						$belongs->modify_belong($update);
					}
				}
			}
		}
		$this->redirect("Profile/Company/show_members", "cid={$_POST['cid']}", 0, " ");
	}
	
}
	
?>