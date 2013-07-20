<?php

class UserAction extends Action{
	
	public function index(){
		if(!$_SESSION['login']){
			$this->redirect("Home/Index/index", "", 0, "");
		}
		sprintf($uid, "%d", $_SESSION['uid']);
		$uid = "/\b".$uid."\b/";
		$match = array();
		
		$inter = D("Obj/Interview");
		$relation = D("Relation/Belongs");
		$G = D("Permission/Group");
		$C = D("Obj/Company");
		$interviews = array();
		$company_name = array();
		$companys = $relation->where("uid={$_SESSION["uid"]}")->select();
		foreach($companys as $item){
			$interviews[$item['cid']] = array();
			$temp = $C->where("cid={$item["cid"]}")->find();
			$company_name[$item['cid']] = array();
			$company_name[$item['cid']]['name'] = $temp['name'];
			
			$p = $G->where("id={$item["group"]}")->find();
			$company_name[$item['cid']]['group'] = $p['name'];
			if(!$p || $p['code'] == 0){ 
				continue; 
			}
			
			$interviews[$item['cid']] = $inter->where("cid={$item["cid"]} AND finished=0 AND interviewer REGEXP ';{$_SESSION["uid"]};'")->select();
			
		}
		$this->assign("companys", $companys);
		$this->assign("company_name", $company_name);
		$this->assign("interviews", $interviews);
		
		$this->assign("url_logout", U("Home/Index/logout"));
		$this->assign("url_company_profile", U("Profile/Company/index"));
		$this->assign("url_create_company", U("Profile/Company/create"));
		$this->assign("url_join_company", U("Profile/Company/join"));
		$this->assign("content", "User:index");
		$this->display("Public:Public:base");
	}
	
}

?>