<?php
class CompanyModel extends Model {
	
	/*=========================================
	cid : int 			id
	name : string 		名字
	creator : string	账户创建者
	represent : string	法人代表
	tele : string		电话
	email : string		电子邮件
	/*=========================================*/
	
	protected $_validate = array(
		array("name", "require", "公司名字不能为空", 1),
		array("creator", "require", "账户创建者不能为空", 1),
		array("represent", "require", "法人代表不能为空", 1),
		array("tele", "require", "电话不能为空", 1)
	);
	
	public function add_company( $inputArr ){
		$data = $this->where("name='{$inputArr["name"]}'")->find();
		if($data){ return false; }
		$addArr = array();
		$addArr['name'] = $inputArr['name'];
		$addArr['creator'] = $inputArr['creator'];
		$addArr['represent'] = $inputArr['represent'];
		$addArr['tele'] = $inputArr['tele'];
		$addArr['email'] = $inputArr['email'];
		var_dump($addArr);
		return $this->add($addArr);
	}
	
	public function del_company( $inputArr ){
		return $this->where("cid={$inputArr["cid"]}")->delete();
	}
	
	public function modify_company( $inputArr ){
		$update = $this->where("cid={$inputArr["cid"]}")->find();
		if(!$update){ return false; }
		
		$update['name'] = $inputArr['name'];
		$update['creator'] = $inputArr['creator'];
		$update['represent'] = $inputArr['represent'];
		$update['tele'] = $inputArr['tele'];
		$update['email'] = $inputArr['email'];
		
		return $this->where("cid={$inputArr["cid"]}")->save($update);
	}
	
}
	
?>