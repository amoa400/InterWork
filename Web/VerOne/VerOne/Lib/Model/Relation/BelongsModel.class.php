<?php

class BelongsModel extends Model {
	
	/*=============================================
	cid : int			所属公司
	uid : int 			用户
	group : string		权限组
	/*=============================================*/
	
	protected $_validate = array(
		array("cid", "require", "公司不能为空", 1),
		array("uid", "require", "用户不能为空", 1),
		array("group", "require", "权限组不能为空", 1)
	);
	
	public function add_belong( $inputArr ){
		//var_dump($inputArr);
		$date = $this->where("cid={$inputArr["cid"]} AND uid={$inputArr["uid"]}")->find();
		if($date){ return false; }
		$addArr['cid'] = $inputArr['cid'];
		$addArr['uid'] = $inputArr['uid'];
		$addArr['group'] = $inputArr['group'];
		
		return $this->add($addArr);
	}
	
	public function del_belong( $inputArr ){
		return $this->where("id={$inputArr["id"]}")->delete();
	}
	
	public function modify_belong( $inputArr ){
		$update = $this->where("id={$inputArr["id"]}")->find();
		if(!$update){ return false; }
		
		$update['cid'] = $inputArr['cid'];
		$update['uid'] = $inputArr['uid'];
		$update['group'] = $inputArr['group'];
		
		return $this->where("id={$inputArr["id"]}")->save($update);
	}
	
}

?>