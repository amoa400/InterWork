<?php
	
class InterviewGroupModel extends Model {
	
	/*=============================================
	name : string 			组名
	cid : int				所属公司id
	parent : int            父对象id（0表示在根）
	/*=============================================*/
	
	protected $_validate = array(
		array("name", "require", "组名不能为空", 1),
		array("cid", "require", "所属公司不能为空", 1),
		array("parent", "require", "父对象不能为空", 1)
	);
	
	public function add_interview_group( $inputArr ){
		$data = $this->where("name='{$inputArr["name"]}' AND cid={$inputArr["cid"]}")->find();
		if($data){ return false; }
		$parent = $this->where("id={$inputArr["parent"]} AND cid={$inputArr["cid"]}")->find();
		if(!$parent && $inputArr['parent'] != 0){ return false; }
		$addArr = array();
		$addArr['name'] = $inputArr['name'];
		$addArr['cid'] = $inputArr['cid'];
		$addArr['parent'] = $inputArr['parent'];
		
		return $this->add($addArr);
	}
	
	public function del_interview_group( $inputArr ){
		/*$interview = D('Obj.Interview');
		$interviews = $interview->where("interview_group={$inputArr["id"]}")->select();
		foreach($interviews as $i){
			$i['interview_group'] = 0;
			$interview->where("id={$i["id"]}")->save($i);
		}*/
		
		return $this->where("id={$inputArr["id"]}")->delete();
	}
	
	public function modify_interview_group( $inputArr ){
		$update = $this->where("id={$inputArr["id"]}")->find();
		if(!$update){ return false; }
		$parent = $this->where("id={$inputArr["parent"]} AND cid={$inputArr["cid"]}")->find();
		if(!$parent && $inputArr['parent'] != 0){ return false; }
		$update['name'] = $inputArr['name'];
		$update['cid'] = $inputArr['cid'];
		$update['parent'] = $inputArr['parent'];
		
		return $this->where("id={$inputArr["id"]}")->save($update);
	}
	
}
	
?>