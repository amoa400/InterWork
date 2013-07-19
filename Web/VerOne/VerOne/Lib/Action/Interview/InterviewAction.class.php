<?php

class InterviewAction extends Action{
	
	public function index(){
		//list
		if(!$_SESSION['login'] || !$_GET['cid']){
			$this->redirect("Home/Index/index", "", 0, "");
		}
		$relation = D("Relation/Belongs")->where("uid={$_SESSION["uid"]} AND cid={$_GET["cid"]}")->find();
		if(!$relation){
			$this->redirect("Profile/User/index", "", 0, "");
		}
		$p = D("Permission/Group")->where("id={$relation["group"]}")->find();
		$company = D("Obj/Company")->where("cid={$_GET["cid"]}")->find();
		//var_dump($company);
		if($p['code'] & 1){
			$inter = D("Obj/Interview");
			$interviews = $inter->where("cid={$_GET["cid"]} AND finished=0")->select();
			
			$this->assign("interviews", $interviews);
			$this->assign("company", $company);
			
			$this->assign("url_history", U("Interview/Interview/history"));
			$this->assign("url_del", U("Interview/Interview/del_a"));
			$this->assign("url_create", U("Interview/Interview/create"));
			$this->assign("url_modify", U("Interview/Interview/modify"));
			$this->assign("url_return", U("Profile/Company/index"));
			$this->assign("content", "Interview:index");
			$this->display("Public:Public:base");
		}
		else{
			redirect("Profile/Company/index", "cid={$_GET['cid']}", 0, "");
		}
	}
	
	public function history(){
		if(!$_SESSION['login'] || !$_GET['cid']){
			$this->redirect("Home/Index/index", "", 0, "");
		}
		$relation = D("Relation/Belongs")->where("uid={$_SESSION["uid"]} AND cid={$_GET["cid"]}")->find();
		if(!$relation){
			$this->redirect("Profile/User/index", "", 0, "");
		}
		$p = D("Permission/Group")->where("id={$relation["group"]}")->find();
		$company = D("Obj/Company")->where("cid={$_GET["cid"]}")->find();
		//var_dump($company);
		if($p['code'] & 1){
			$inter = D("Obj/Interview");
			$interviews = $inter->where("cid={$_GET["cid"]} AND finished=0")->select();
			$finished = $inter->where("cid={$_GET["cid"]} AND finished=1")->select();
			
			$this->assign("interviews", $interviews);
			$this->assign("finished", $finished);
			$this->assign("company", $company);
			
			$this->assign("url_history", U("Interview/Interview/history"));
			$this->assign("url_del", U("Interview/Interview/del_a"));
			$this->assign("url_create", U("Interview/Interview/create"));
			$this->assign("url_modify", U("Interview/Interview/modify"));
			$this->assign("url_return", U("Profile/Company/index"));
			$this->assign("content", "Interview:history");
			$this->display("Public:Public:base");
		}
		else{
			redirect("Profile/Company/index", "cid={$_GET['cid']}", 0, "");
		}
	}
	
	public function create(){
		if(!$_SESSION['login'] || !$_GET['cid']){
			$this->redirect("Home/Index/index", "", 0, "");
		}
		$relation = D("Relation/Belongs")->where("uid={$_SESSION["uid"]} AND cid={$_GET["cid"]}")->find();
		if(!$relation){
			$this->redirect("Profile/User/index", "", 0, "");
		}
		$p = D("Permission/Group")->where("id={$relation["group"]}")->find();
		$company = D("Obj/Company")->where("cid={$_GET["cid"]}")->find();
		
		if($p['code'] & 8){
			$permissions = array();
			$temp = D("Permission/Group")->where("id!=0")->select();
			foreach($temp as $i){
				$permissions[$i['id']] = $i;
			}
			$temp = D("Relation/Belongs")->where("cid={$_GET["cid"]}")->select();
			$interviewers = array();
			$member = D("Obj/User");
			foreach($temp as $i){
				if($permissions[$i['group']]['code'] & 2){
					$interviewers[$i['uid']] = $member->where("uid={$i["uid"]}")->find();
				}
			}
			$this->assign("interviewers", $interviewers);
			
			$this->assign("url_create_a", U("Interview/Interview/create_a"));
			$this->assign("url_return", U("Interview/Interview/index"));
			$this->assign("company", $company);
			
			$this->assign("content", "Interview:create");
			$this->display("Public:Public:base");
		}
		else{
			redirect("Profile/Company/index", "cid={$_GET['cid']}", 0, "");
		}
	}
	
	public function create_a(){
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
			$interview = D("Obj/Interview");
			foreach(array_keys($_POST["interviewee"]) as $i){
				$inputArr = array();
				$inputArr['interviewee'] = $_POST['interviewee'][$i];
				$inputArr['plantime'] = $_POST['plantime'][$i];
				$inputArr['interviewer'] = ";";
				foreach($_POST['interviewers'] as $item){
					$inputArr['interviewer'] = $inputArr['interviewer'].$item.";";
				}
				$inputArr['cid'] = (int)$_POST['cid'];
				$inputArr['start_time'] = time();
				$inputArr['end_time'] = time();
				$inputArr['finished'] = 0;
				$inputArr['interview_group'] = (int)$_POST['interview_group'];
				$inputArr['info'] = $_POST['info'];
				
				$interview->add_interview( $inputArr );
			}
			$this->redirect("Interview/Interview/index", "cid={$_POST["cid"]}", 0, " ");
		}
		else{
			$this->redirect("Profile/Company/index", "cid={$_POST["cid"]}", 0, " ");
		}
		
	}
	
	public function modify(){
		
		if(!$_SESSION['login'] || !$_GET['cid'] || !$_GET['inid']){
			$this->redirect("Home/Index/index", "", 0, "");
		}
		$relation = D("Relation/Belongs")->where("uid={$_SESSION["uid"]} AND cid={$_GET["cid"]}")->find();
		if(!$relation){
			$this->redirect("Profile/User/index", "", 0, "");
		}
		$p = D("Permission/Group")->where("id={$relation["group"]}")->find();
		$company = D("Obj/Company")->where("cid={$_GET["cid"]}")->find();
		
		if($p['code'] & 8){
			$interview = D("Obj/Interview")->where("cid={$_GET["cid"]} AND id={$_GET["inid"]}")->find();
			if(!$interview){
				$this->redirect("Interview/Interview/index", "cid={$_GET["cid"]}", 0, "");
			}
			
			$permissions = array();
			$temp = D("Permission/Group")->where("id!=0")->select();
			foreach($temp as $i){
				$permissions[$i['id']] = $i;
			}
			$temp = D("Relation/Belongs")->where("cid={$_GET["cid"]}")->select();
			$interviewers = array();
			$member = D("Obj/User");
			foreach($temp as $i){
				if($permissions[$i['group']]['code'] & 2){
					$interviewers[$i['uid']] = $member->where("uid={$i["uid"]}")->find();
				}
			}
		
			$this->assign("interview", $interview);
			$this->assign("interviewers", $interviewers);
			
			$this->assign("url_modify_a", U("Interview/Interview/modify_a"));
			$this->assign("url_return", U("Interview/Interview/index"));
			$this->assign("company", $company);
			
			$this->assign("content", "Interview:modify");
			$this->display("Public:Public:base");
		}
		else{
			$this->redirect("Interview/Interview/index", "cid={$_GET["cid"]}", 0, "");
		}
	}
	
	public function modify_a(){
		//var_dump($_POST);
		if(!$_SESSION['login'] || !$_POST['cid'] || !$_POST['id']){
			$this->redirect("Home/Index/index", "", 0, "");
		}
		$relation = D("Relation/Belongs")->where("uid={$_SESSION["uid"]} AND cid={$_POST["cid"]}")->find();
		if(!$relation){
			$this->redirect("Profile/User/index", "", 0, "");
		}
		$p = D("Permission/Group")->where("id={$relation["group"]}")->find();
		
		if($p['code'] & 8){
			$update = D("Obj/Interview")->where("id={$_POST["id"]} AND cid={$_POST["cid"]}")->find();
			var_dump((int)$update['finished']);
			if(!$update || (int)$update['finished'] == 1){
				$this->redirect("Interview/Interview/index", "cid={$_POST["cid"]}", 0, " ");
			}
			$update['interviewee'] = $_POST['interviewee'];
			$update['plantime'] = $_POST['plantime'];
			$update['info'] = $_POST['info'];
			$update['interviewer'] = ";";
			foreach($_POST['interviewers'] as $item){
				$update['interviewer'] = $update['interviewer'].$item.";";
			}
			
			D("Obj/Interview")->modify_interview( $update );
			
			$this->redirect("Interview/Interview/index", "cid={$_POST["cid"]}", 0, " ");
			//var_dump($update);
		}
		else{
			$this->redirect("Profile/Company/index", "cid={$_POST["cid"]}", 0, " ");
		}
	}
	
	public function del_a(){
		if(!$_SESSION['login'] || !$_GET['cid'] || !$_GET['inid']){
			$this->redirect("Home/Index/index", "", 0, "");
		}
		$relation = D("Relation/Belongs")->where("uid={$_SESSION["uid"]} AND cid={$_GET["cid"]}")->find();
		if(!$relation){
			$this->redirect("Profile/User/index", "", 0, "");
		}
		$p = D("Permission/Group")->where("id={$relation["group"]}")->find();
		
		if($p['code'] & 8){
			$interview = D("Obj/Interview")->where("id={$_GET["inid"]} AND cid={$_GET["cid"]}")->find();
			if($interview && (int)$interview['finished'] == 0){
				D("Obj/Interview")->del_interview( $interview );
			}
			$this->redirect("Interview/Interview/index", "cid={$_GET["cid"]}", 0, " ");
		}
		else{
			$this->redirect("Profile/Company/index", "cid={$_GET["cid"]}", 0, " ");
		}
	} 
	
}

?>