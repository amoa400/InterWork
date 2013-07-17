<?php

class GroupModel extends Model {
	
	/*========================================
	name : string			权限组名
	code : int				权限码
				由低至高位分别为：查看面试、进行面试、查看历史、安排面试、面试设置、邀请、账单
	/*========================================*/
	
	protected $_validate = array(
		array("name", "require", "权限组名不能为空", 1),
		array("code", "require", "权限码", 1)
	);
	
	public function add_group( $inputArr ){
		$data = $this->where("name='{$inputArr["name"]}'")->find();
		if($data){ return false; }
		$addArr = array();
		$addArr['name'] = $inputArr['name'];
		$addArr['code'] = $inputArr['code'];
	}
	
	public function del_group( $inputArr ){
		return $this->where("id={$inputArr["id"]}")->delete();
	}
	
	public function modify_company( $inputArr ){
		$update = $this->where("id={$inputArr["id"]}")-find();
		if(!$update){ return false; }
		
		$update['name'] = $inputArr['name'];
		$update['code'] = $inputArr['code'];
		
		return $this->where("id={$inputArr["id"]}")->save($update);
	}
}

?>