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
			$this->assign("url_intergroup", U("Interview/InterGroup/index"));
			$this->assign("url_enter", U("Interview/Interview/enter_room_er"));
			
			$this->assign("content", "Interview:index");
			$this->display("Public:Public:base");
		}
		else{
			$this->redirect("Profile/Company/index", "cid={$_GET['cid']}", 0, "");
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
			$this->assign("url_return", U("Interview/Interview/index"));
			$this->assign("url_enter", U("Interview/Interview/enter_room_er"));
			
			$this->assign("content", "Interview:history");
			$this->display("Public:Public:base");
		}
		else{
			$this->redirect("Profile/Company/index", "cid={$_GET['cid']}", 0, "");
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
			//var_dump($_GET);
			if($_GET['ing'] == NULL){
				$_GET['ing'] = 0;
				$this->assign("url_return", U("Interview/Interview/index"));
			}
			else if(!D("Relation/InterviewGroup")->where("cid={$_GET["cid"]} AND id={$_GET["ing"]}")->find()){
				$_GET['ing'] = 0;
				$this->assign("url_return", U("Interview/InterGroup/index"));
			}
			else{
				$this->assign("url_return", U("Interview/InterGroup/index"));
			}
			
			$this->assign("interviewers", $interviewers);
			
			$this->assign("url_create_a", U("Interview/Interview/create_a"));
			
			$this->assign("company", $company);
			
			$this->assign("content", "Interview:create");
			$this->display("Public:Public:base");
		}
		else{
			$this->redirect("Interview/Interview/index", "cid={$_GET['cid']}", 0, "");
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
			//TODO: judge interview_group
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
			$this->redirect("Interview/InterGroup/index", "cid={$_POST["cid"]}&gid={$_POST["interview_group"]}", 0, " ");
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
			//TODO: judge interview_group
			$update['interviewee'] = $_POST['interviewee'];
			$update['plantime'] = $_POST['plantime'];
			$update['info'] = $_POST['info'];
			$update['interviewer'] = ";";
			foreach($_POST['interviewers'] as $item){
				$update['interviewer'] = $update['interviewer'].$item.";";
			}
			
			D("Obj/Interview")->modify_interview( $update );
			
			if((int)$_POST['rg'] == 0 || D("Relation/InterviewGroup")->where("cid={$_POST["cid"]} AND id={$_POST["rg"]}")->find()){
				$this->redirect("Interview/InterGroup/index", "cid={$_POST["cid"]}&gid={$_POST["rg"]}", 0, " ");
			}
			else{
				$this->redirect("Interview/Interview/index", "cid={$_POST["cid"]}", 0, " ");
			}
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
			$this->redirect("Interview/Interview/index", "cid={$_GET["cid"]}", 0, " ");
		}
	} 
	
	public function enter_room_er(){
		if(!$_SESSION['login'] || !$_GET['cid'] || !$_GET['inid']){
			$this->redirect("Home/Index/index", "", 0, "");
		}
		$relation = D("Relation/Belongs")->where("uid={$_SESSION["uid"]} AND cid={$_GET["cid"]}")->find();
		if(!$relation){
			$this->redirect("Profile/User/index", "", 0, "");
		}
		$p = D("Permission/Group")->where("id={$relation["group"]}")->find();
		
		if($p['code'] & 2){
			$interview = D("Obj/Interview")->where("id={$_GET["inid"]} AND cid={$_GET["cid"]} AND finished=0")->find();
			if(!$interview){
				$this->redirect("Interview/Interview/index", "", 0, "");
			}
			
			//var_dump($_SESSION);
			$in_session = array();
			$in_session['uid'] = $_SESSION['uid'];
			$in_session['inid'] = $interview['id'];
			$in_session['session_id'] = sha1($_SESSION['name'].uniqid());
			
			if(!(D("Session/Session")->add_session( $in_session ))){
				$this->redirect("Interview/Interview/index", "", 0, "");//如果无法添加session_id则自动跳转返回
			}
			
			$this->assign("session_id", $in_session['session_id']);
			$this->assign("url_finish", U("Interview/Interview/finish"));
			
			$this->assign("content", "Interview:enter_room_er");
			$this->display("Public:Public:base");
			//var_dump($in_session);
			//tpl 里面记得把cid存下来($_GET['cid']), 结束时放表单里
			//echo $in_session['session_id'];
		}
	}
	
	//5c24 70aa55dae14622184987f1ea7ffbf48783ac5e1c
	
	public function enter_room_ee(){
		$_SESSION['tip'] = NULL;
		//账号生成规则：{cid}c{interview_id}
		if(!$_POST['account'] || !$_POST['psw']){
			$_SESSION['tip'] = "请输入面试号和密码";
			$this->redirect("Home/Index/interviewee", "", 0, "");
		}
		$match = array();
		if(!preg_match("/^[0-9]+c[0-9]+$/", $_POST['account'], $match)){
			$_SESSION['tip'] = "面试号或密码不正确";
			$this->redirect("Home/Index/interviewee", "", 0, "");
		}
		
		
		$in_session = array();
		$in_session['uid'] = 0;
		$cid = "";
		sscanf($_POST['account'], "%dc%d", $cid, $in_session['inid']);
		//$in_session['inid'] = (int)$in_session['inid'];
		//var_dump($cid, $in_session);
		//var_dump($match);
		$interview = D("Obj/Interview")->where("id={$in_session['inid']} AND cid={$cid} AND finished=0")->find();
		if(!$interview  || $interview['access_code'] != $_POST['psw']){
			$_SESSION['tip'] = "面试号或密码不正确";
			$this->redirect("Home/Index/interviewee", "", 0, "");
		}
		$in_session['session_id'] = sha1($_POST['psw'].uniqid());
		
		if(!(D("Session/Session")->add_session( $in_session ))){
			$this->redirect("Home/Index/interviewee", "", 0, "");//如果无法添加session_id则自动跳转返回
		}
		
		var_dump($in_session);
		$this->assign("session_id", $in_session['session_id']);
	
	}
	
	public function finish(){
		/****************************************************
		POST表单需要参数
		cid : 公司id
		inid : 即room_id
		start_time : 开始时间
		end_time : 结束时间	
		/****************************************************/
		if(!$_SESSION['login'] || !$_POST['cid'] || !$_POST['inid']){
			$this->redirect("Home/Index/index", "", 0, "");
		}
		$relation = D("Relation/Belongs")->where("uid={$_SESSION["uid"]} AND cid={$_POST["cid"]}")->find();
		if(!$relation){
			$this->redirect("Profile/User/index", "", 0, "");
		}
		$p = D("Permission/Group")->where("id={$relation["group"]}")->find();
		
		if($p['code'] & 2){
			$interview = D("Obj/Interview")->where("id={$_POST["inid"]} AND cid={$_POST["cid"]} AND finished=0")->find();
			if($interview){
				$interview['start_time'] = (int)$_POST['start_time'];
				$interview['end_time'] = (int)$_POST['end_time'];
				$interview['finished'] = 1;
				D("Obj/Interview")->modify_interview( $interview );
			}
		}
		
		$this->redirect("Interview/Interview/index", "cid={$_POST["cid"]}", 0, "");
		
	}
	
}

?>