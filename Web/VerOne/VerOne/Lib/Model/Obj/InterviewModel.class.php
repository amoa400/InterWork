<?php
	
class InterviewModel extends Model {
	
	/*=============================================
	interviewer : string				面试官（以分号分隔）
	interviewee : string				面试者
	plantime : string					计划时间
	finished : boolean					是否已完成
	start_time : time					开始时间
	end_time : time						结束时间
	cid : int 							所属公司id
	interview_group : int				面试组(id)
	info : string						面试备注
	/*=============================================*/
	
	protected $_validate = array(
		array("interviewer", "require", "面试官不能为空", 1),
		array("interviewee", "require", "面试者不能为空", 1),
		array("interview_group", "require", "", 1)
	);
	
	public function add_interview( $inputArr ){
		$addArr = array();
		$addArr['interviewer'] = $inputArr['interviewer'];
		$addArr['interviewee'] = $inputArr['interviewee'];
		$addArr['plantime'] = $inputArr['plantime'];
		$addArr['start_time'] = $inputArr['start_time'];
		$addArr['end_time'] = $inputArr['end_time'];
		$addArr['cid'] = $inputArr['cid'];
		$addArr['interview_group'] = $inputArr['interview_group'];
		$addArr['info'] = $inputArr['info'];
		$addArr['finished'] = 0;
		
		return $this->add($addArr);
	}
	
	public function del_interview( $inputArr ){
		return $this->where("id={$inputArr["id"]}")->delete();
	}
	
	public function modify_interview( $inputArr ){
		$update = $this->where("id={$inputArr["id"]}")->find();
		if(!$update){ return false; }
		
		$update['interviewer'] = $inputArr['interviewer'];
		$update['interviewee'] = $inputArr['interviewee'];
		$update['plantime'] = $inputArr['plantime'];
		$update['start_time'] = $inputArr['start_time'];
		$update['end_time'] = $inputArr['end_time'];
		$update['cid'] = $inputArr['cid'];
		$update['interview_group'] = $inputArr['interview_group'];
		$update['info'] = $inputArr['info'];
		$update['finished'] = $inputArr['finished'];
		
		return $this->where("id={$inputArr["id"]}")->save($update);
	}
	
}
	
?>