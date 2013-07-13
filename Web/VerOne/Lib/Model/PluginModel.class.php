<?php

class PluginModel extends Model {

	// ����
	public function c($pluginName = '', $data = '') {
		if ($this->db(1)->table('it_plugin_'.$pluginName)->create($data)) {
			$ret = $this->db(1)->table('it_plugin_'.$pluginName)->add();
			return $ret;
		} else {
			
			return $this->getError();
		}
	}

	// ����
	public function u($roomId = 0, $pluginName = '', $identifier = 0, $data = '') {
		$sql = array();
		$sql['room_id'] = (int)($roomId);
		$sql['identifier'] = (int)($identifier);
		$ret = $this->db(1)->table('it_plugin_'.$pluginName)->where($sql)->save($data);
	}
	
	// ����
	public function u2($pluginName = '', $sql = '', $data = '') {
		$ret = $this->db(1)->table('it_plugin_'.$pluginName)->where($sql)->save($data);
	}

	// ��ѯ
    public function r($roomId = 0, $pluginName = '', $identifier = 0) {
		$sql = array();
		$sql['room_id'] = (int)($roomId);
		$sql['identifier'] = array('GT', (int)($identifier));
		$content = $this->db(1)->table('it_plugin_'.$pluginName)->where($sql)->select();
		return $content;
    }
	
	// ��ѯ�б�
	public function rList($roomId = 0, $pluginName = '', $identifier = 0, $userId = 0) {
		$sql = array();
		$sql['room_id'] = (int)($roomId);
		$sql['id'] = array('GT', (int)($identifier));
		if (!empty($identifier)) $sql['user_id'] = array('NEQ', (int)($userId));
		$content = $this->db(1)->table('it_plugin_'.$pluginName)->where($sql)->select();
		return $content;
	}
	
	// ɾ��
	public function d($pluginName = '', $sql = '') {
		$ret = $this->db(1)->table('it_plugin_'.$pluginName)->where($sql)->delete();
	}

/*********************************************************/

	// ��ȡ����ͨ�����룩
    public function rByCode($code = 0){
		$sql = array('code' => $code);
		$agent = $this->where($sql)->find();
		return $agent;
    }
	
	// ��ȡ��������
	public function rCount($father_id = 0) {
		$sql = array('father_id' => (int)$father_id);
		$count = $this->field('COUNT(1) AS `count`')->where($sql)->find();
		return $count['count'];
	}
	
	// ����������ֵ
	public function incMoney($user_id = 0, $money = 0, $fatherMoney = 0) {
		$user_id = (int)$user_id;
		$res = $this->query("UPDATE `tour_agent` SET `earned_money`=`earned_money`+'$money', `history_money`=`history_money`+'$money', `father_money`=`father_money`+'$fatherMoney' WHERE `user_id`='$user_id';");
	}
}