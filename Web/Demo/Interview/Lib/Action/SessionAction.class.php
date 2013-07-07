<?php
class SessionAction extends Action {
	// 修改session
    public function update(){
		$data = array();
		$data['room_id'] = $this->_get('room_id');
		$data['user_id'] = $this->_get('user_id');
		$data['session_id'] = 'xxxxxxxxxx';
		D('Session')->u($data);
    }
}