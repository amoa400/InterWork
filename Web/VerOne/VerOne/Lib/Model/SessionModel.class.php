<?php

class SessionModel extends Model {
	// 创建
	public function c($data = 0) {
		if (empty($data)) $data = $_POST;
		if ($this->create($data)) {
			$ret = $this->add();
			return $ret;
		} else {
			return $this->getError();
		}
	}
	
	// 更新
	public function u($data = 0) {
		if (empty($data)) $data = $_POST;
		$ret = $this->save($data);
		return $ret;
	}
	
	// 查询
	public function r($room_id = 0, $user_id = 0) {
		$sql = array();
		$sql['room_id'] = (int)($room_id);
		$sql['user_id'] = (int)($user_id);
		$ret = $this->where($sql)->find();
		return $ret;
	}
}