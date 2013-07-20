<?php
	
class InterGroupAction extends Action{
	
	public function index(){
		if(!$_SESSION['login'] || !$_GET['cid']){
			$this->redirect("Home/Index/index", "", 0, "");
		}
		$relation = D("Relation/Belongs")->where("uid={$_SESSION["uid"]} AND cid={$_GET["cid"]}")->find();
		if(!$relation){
			$this->redirect("Profile/User/index", "", 0, "");
		}
		$p = D("Permission/Group")->where("id={$relation["group"]}")->find();
		$company = D("Obj/Company")->where("cid={$_GET["cid"]}")->find();
		
		if($p['code'] & 1){
			if(!$_GET['gid']){
				$_GET['gid'] = 0;
			}
			
			$this->assign("url_create", U("Interview/InterGroup/create"));
			$this->assign("url_return", U("Interview/Interview/index"));
			$this->assign("url_del", U("Interview/InterGroup/del"));
			$this->assign("url_modify", U("Interview/InterGroup/modify"));
			$this->assign("url_showdir", U("Interview/InterGroup/showdir"));
			
			$this->assign("company", $company);
			
			$this->assign("content", "InterGroup:index");
			$this->display("Public:Public:base");
		}
		else{
			$this->redirect("Profile/Company/index", "cid={$_GET['cid']}", 0, "");
		}
	}
	
	public function create(){
		//var_dump($_POST);
		if(!$_SESSION['login'] || !$_POST['cid']){
			$this->redirect("Home/Index/index", "", 0, "");
		}
		$relation = D("Relation/Belongs")->where("uid={$_SESSION["uid"]} AND cid={$_POST["cid"]}")->find();
		if(!$relation){
			$this->redirect("Profile/User/index", "", 0, "");
		}
		$p = D("Permission/Group")->where("id={$relation["group"]}")->find();
		
		if($p['code'] & 8){
			$inter_group = D("Relation/InterviewGroup");
			if((int)$_POST['gid'] != 0){
				$parent = $inter_group->where("cid={$_POST["cid"]} AND id={$_POST["gid"]}")->find();
			}
			else{
				$parent = 1;
			}
			
			if($parent){
				$inputArr = array();
				if($parent == 1){
					$inputArr['parent'] = 0;
				}
				else{
					$inputArr['parent'] = (int)$_POST['gid'];
				}
				$inputArr['cid'] = (int)$_POST['cid'];
				$inputArr['name'] = $_POST['name'];
				
				if( $inter_group->add_interview_group( $inputArr ) ){
					echo "创建成功";
				}
				else{
					echo "创建失败";
				}
			}
			else{
				echo "创建失败";
			}
		}
		else{
			echo "权限不足";
		}
	}
	
	public function del(){
		var_dump($_GET);
		if(!$_SESSION['login'] || !$_GET['cid']){
			$this->redirect("Home/Index/index", "", 0, "");
		}
		$relation = D("Relation/Belongs")->where("uid={$_SESSION["uid"]} AND cid={$_GET["cid"]}")->find();
		if(!$relation){
			$this->redirect("Profile/User/index", "", 0, "");
		}
		$p = D("Permission/Group")->where("id={$relation["group"]}")->find();
		
		
		if($p['code'] & 8){
			$inter_group = D("Relation/InterviewGroup");
			$interview = D("Obj/Interview");
			$self = $inter_group->where("cid={$_GET["cid"]} AND id={$_GET["gid"]}")->find();
			if($self){
				$subdir = $inter_group->where("cid={$self["cid"]} AND parent={$self["id"]}")->select();
				$interviews = $interview->where("cid={$self["cid"]} AND interview_group={$self["id"]}")->select();
				foreach($subdir as $item){
					$item['parent'] = (int)$self['parent'];
					$inter_group->modify_interview_group( $item );
				}
				foreach($interviews as $item){
					$item['interview_group'] = (int)$self['parent'];
					$interview->modify_interview( $item );
				}
				
				$inter_group->del_interview_group($self);
			}
		}
		
		
		$this->redirect("Interview/InterGroup/index", "cid={$_GET['cid']}&gid={$_GET['r']}", 0, "");
	}
	
	public function modify(){
		//var_dump($_POST);
		if(!$_SESSION['login'] || !$_POST['cid']){
			$this->redirect("Home/Index/index", "", 0, "");
		}
		$relation = D("Relation/Belongs")->where("uid={$_SESSION["uid"]} AND cid={$_POST["cid"]}")->find();
		if(!$relation){
			$this->redirect("Profile/User/index", "", 0, "");
		}
		$p = D("Permission/Group")->where("id={$relation["group"]}")->find();
		
		if($p['code'] & 8){
			$inter_group = D("Relation/InterviewGroup");
			$update = $inter_group->where("cid={$_POST["cid"]} AND id={$_POST["gid"]}")->find();
			if(!$update){ echo "fail"; return; }
			$update['name'] = $_POST['name'];
			if($inter_group->modify_interview_group($update)){
				echo "success";
			}
			else {
				echo "fail2";
			}
		}
		else{
			echo "权限不足";
		}
	}
	
	public function showdir(){
		//var_dump($_POST);
		if(!$_SESSION['login'] || !$_POST['cid']){
			$this->redirect("Home/Index/index", "", 0, "");
		}
		$relation = D("Relation/Belongs")->where("uid={$_SESSION["uid"]} AND cid={$_POST["cid"]}")->find();
		if(!$relation){
			$this->redirect("Profile/User/index", "", 0, "");
		}
		$p = D("Permission/Group")->where("id={$relation["group"]}")->find();
		
		if($p['code'] & 1){
			$inter_group = D("Relation/InterviewGroup");
			$self = false;
			if((int)$_POST['gid'] == 0){
				$self = array();
				$self['id'] = 0;
			}
			else{
				$self = $inter_group->where("cid={$_POST["cid"]} AND id={$_POST["gid"]}")->find();
			}
			
			if(!$self){
				echo "不存在该组，请刷新";
				return;
			}
			
			$subdir = $inter_group->where("cid={$_POST["cid"]} AND parent={$self["id"]}")->select();
			$interviews = D("Obj/Interview")->where("cid={$_POST["cid"]} AND interview_group={$self["id"]}")->select();
			
			$this->assign("url_del", U("Interview/InterGroup/del"));
			$this->assign("url_modify", U("Interview/InterGroup/modify"));
			$this->assign("url_create_interview", U("Interview/Interview/create"));
			$this->assign("url_modify_interview", U("Interview/Interview/modify"));
			$this->assign("url_del_interview", U("Interview/Interview/del_a"));
			$this->assign("subdir", $subdir);
			$this->assign("interviews", $interviews);
			$this->assign("self", $self);
			
			$this->display("InterGroup:showdir");
		}
		else{
			echo "请重新登录";
		}
	}
	

	
}
	
?>