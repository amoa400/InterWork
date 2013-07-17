<?php
class RoomAction extends Action {
	// 显示房间
    public function show(){
		$info['room_id'] = $_GET['room_id'];
		$info['user_id'] = $_GET['user_id'];
		$info['session_id'] = '';
		for ($i = 0; $i < 10; $i ++) 
			$info['session_id'] .= rand() % 10;
		if ($info['user_id'] == 1) $info['officer'] = 1;
		
		// 开启新的会话，使用不同的服务器响应
		$data = array();
		$data['room_id'] = $info['room_id'];
		$data['user_id'] = $info['user_id'];
		$data['session_id'] = $info['session_id'];
		$session = D('Session')->r($info['room_id'], $info['user_id']);
		if (empty($session)) {
			$data['server_id'] = rand() % 5 + 1;
			D('Session')->c($data);
		} else {
			$data['server_id'] = $session['server_id'] + 1;
			if ($data['server_id'] > 5) $data['server_id'] = 1; 
			D('Session')->u($data);
		}
		$info['lConUrl'] = 'http://t'.$data['server_id'].'.xiaoqs.com';
		//$info['lConUrl'] = 'http://111.186.54.241:88';
		
		$this->assign('info', $info);
		$this->display();
    }
	
	// 获取实时信息
	public function getInfo() {
		set_time_limit(3);

		/*
		$_GET['room_id'] = 1;
		$_GET['user_id'] = 1;
		$_GET['session_id'] = '5074387616';
		$_GET['plugin'] = 'message';
		$_GET['identifier'] = '0';
		*/
		
		$roomId = $this->_get('room_id');
		$userId = $this->_get('user_id');
		$sessionId = $this->_get('session_id');
		$pluginList = split(',', $this->_get('plugin'));
		$identifierList = split(',', $this->_get('identifier'));
		while (1) {
			// 检查当前会话是否有效
			$session = D('Session')->r($roomId, $userId);
			if ($session['session_id'] != $sessionId) {
				$data = array();
				$data['error'] = '无效会话';
				echo $this->_get('jsonp_callback').'('.json_encode($data).')';
				die();
			}
			// 获取每个插件的最新内容
			$flag = false;
			$content = array();
			foreach($pluginList as $key => $item) {
				// 消息插件
				if ($item == 'message') {
					$content['message'] = array();
					$content['message']['content'] = D('Plugin')->rList($roomId, 'message', $identifierList[$key], 0);
					$content['message']['identifier'] = 0;
					foreach($content['message']['content'] as $key2 => $item2) {
						if ($item2['id'] > $content['message']['identifier'])
							$content['message']['identifier'] = $item2['id'];
						if ($item2['user_id'] == 0)
							$content['message']['content'][$key2]['type'] = '0';
						else
						if ($item2['user_id'] == 1) {
							$content['message']['content'][$key2]['type'] = '1';
							$content['message']['content'][$key2]['author'] = '面试官';
						}
						else {
							$content['message']['content'][$key2]['type'] = '2';
							$content['message']['content'][$key2]['author'] = '求职者';
						}
					}
					if (!empty($content['message']['content'])) $flag = true;
					else unset($content['message']);
				}
				// 代码插件
				if ($item == 'code') {
					$content['code'] = D('Plugin')->r($roomId, 'code', $identifierList[$key]);
					$content['code'] = $content['code'][0];
					if (!empty($content['code'])) $flag = true;
					else unset($content['code']);
				}
				// 黑板插件
				if ($item == 'blackboard') {
					$content['ttt'] .= '[';
					$content['blackboard'] = array();
					$content['blackboard']['content'] = D('Plugin')->rList($roomId, 'blackboard', $identifierList[$key], $userId);
					$content['blackboard']['identifier'] = 0;
					foreach($content['blackboard']['content'] as $item2) {
						if ($item2['id'] > $content['blackboard']['identifier'])
							$content['blackboard']['identifier'] = $item2['id'];
					}
					if (!empty($content['blackboard']['content'])) $flag = true;
					else unset($content['blackboard']);
				}
				// 网页插件
				if ($item == 'webpage') {
					$content['webpage'] = array();
					$content['webpage']['content'] = D('Plugin')->rList($roomId, 'webpage', $identifierList[$key], $userId);
					$content['webpage']['identifier'] = 0;
					foreach($content['webpage']['content'] as $item2) {
						if ($item2['id'] > $content['webpage']['identifier'])
							$content['webpage']['identifier'] = $item2['id'];
					}
					if (!empty($content['webpage']['content'])) $flag = true;
					else unset($content['webpage']);
				}
			}
			// 检查是否有更新
			if ($flag) {
				// 获取面试时间
				$content['time'] = array();
				$content['time']['start_time'] = D('Variable')->r($roomId, 'start_time');
				$content['time']['cnt_time'] = getTime();
				// 存在更新，返回数据
				echo $this->_get('jsonp_callback').'('.json_encode($content).')';
				die();
			}
			usleep(100000);
		}
	}
	
	// 更新实时信息
	public function updateInfo() {
		$post = $_POST;
		//$post = array();
		//$post['room_id'] = 1;
		//$post['user_id'] = 1;
		//$post['message']['content'] = array('1','2');
		//$post['webpage']['content'] = array();
		//$post['webpage']['content'][] = array('type' => 'create', 'name' => '4445', 'url' => 'http://');
		//$post['blackboard']['content'] = 1;
		//$post['code']['content'] = 1;
		//$post['code']['identifier'] = 21;
		//dump($post);

		foreach($post as $key => $item) {
			// 消息插件
			if ($key == 'message') {
				foreach($post['message']['content'] as $item2) {
					$data = array();
					$data['room_id'] = $post['room_id'];
					$data['user_id'] = $post['user_id'];
					$data['content'] = $item2['content'];
					$data['time'] = getTime();
					D('Plugin')->c('message', $data);
				}
			}
			// 代码插件
			if ($key == 'code') {
				$data = array();
				$data['code'] = $post['code']['content'];
				$data['identifier'] = $post['code']['identifier']+1;
				D('Plugin')->u($post['room_id'], 'code', $post['code']['identifier'], $data);
			}
			// 黑板插件
			if ($key == 'blackboard') {
				if (strstr($post['blackboard']['content'], 'clear')) {
					$data = array();
					$data['room_id'] = $post['room_id'];
					$data['user_id'] = 0;
					D('Plugin')->c('blackboard', $data);
					$sql = array();
					$sql['room_id'] = $post['room_id'];
					$sql['user_id'] = array('NEQ', 0);
					D('Plugin')->d('blackboard', $sql);
				}
				$data = array();
				$data['room_id'] = $post['room_id'];
				$data['content'] = $post['blackboard']['content'];
				$data['user_id'] = $post['user_id'];
				D('Plugin')->c('blackboard', $data);
			}
			// 网页插件
			if ($key == 'webpage') {
				$tot = count($post['webpage']['content']);
				for ($i = 0; $i < $tot; $i++) {
					$type = $post['webpage']['content'][$i]['type'];
					$name = $post['webpage']['content'][$i]['name'];
					$url = $post['webpage']['content'][$i]['url'];
					if ($type == 'create' || $type == 'redirect') {
						$data = array();
						$data['room_id'] = $post['room_id'];
						$data['user_id'] = $post['user_id'];
						$data['name'] = $name;
						$data['url'] = $url;
						D('Plugin')->c('webpage', $data);
					}
					if ($type == 'close') {
						$data = array();
						$data['room_id'] = $post['room_id'];
						$data['user_id'] = $post['user_id'];
						$data['name'] = $name;
						$data['url'] = 'close';
						D('Plugin')->c('webpage', $data);
					}
				}
			}
		}
		
	}
}