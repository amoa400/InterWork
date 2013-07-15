<?php

class UserModel extends Model {

	/*========================================
	name : string			名字
	email : string			电子邮件（登录名）
	psw : string			密码
	/*========================================*/

	protected $_validate = array(
		array("name", "require", "名字不能为空", 1),
		array("email", "require", "电子邮件不能为空", 1),
		array("psw", "require", "密码不能为空", 1)
	);
	
	public function add_user( $inputArr ){
		$data = $this->where("email='{$inputArr["email"]}'")->find();
		if($data){ return false; }
		
		$addArr = array();
		$addArr['name'] = $inputArr['name'];
		$addArr['email'] = $inputArr['email'];
		$addArr['psw'] = $inputArr['psw'];
		
		return $this->add($addArr);
	}
	
	public function del_user( $inputArr ){
		return $this->where("uid={$inputArr["uid"]}")->delete();
	}
	
	public function modify_user( $inputArr ){
		$update = $this->where("uid={$inputArr["uid"]}")->find();
		if(!$update){ return false; }
		
		$update['name'] = $inputArr['name'];
		$update['email'] = $inputArr['email'];
		$update['psw'] = $inputArr['psw'];
		
		return $this->where("uid={$inputArr["cid"]}")->save{$update};
	}
	
}
	
?>