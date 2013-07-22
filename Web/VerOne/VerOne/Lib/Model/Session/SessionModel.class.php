<?php

class SessionModel extends Model {
	
	public function add_session( $inputArr ){
		$addArr = array();
		$addArr['user_id'] = $inputArr['uid'];
		$addArr['room_id'] = $inputArr['inid'];
		$addArr['session_id'] = $inputArr['session_id'];
		$addArr['server_id'] = 0;
		//var_dump($addArr);
		
		return $this->add( $addArr );
	}
	
	public function search( $user_id = 0, $room_id = 0 ){
		return $this->where("user_id={$user_id} AND room_id={$room_id}")->find();
	}
	
	public function del( $user_id = 0, $room_id = 0 ){
		return $this->where("user_id={$user_id} AND room_id={$room_id}")->delete();
	}
	
}

?>