<?php
class IndexAction extends Action {
	// 编译运行
    public function index() {
		$url1 = U('Room/show?room_id=1&user_id=1');
		$url2 = U('Room/show?room_id=1&user_id=2');
		$url3 = U('Room/show?room_id=1&user_id=3');
		$url4 = U('Room/show?room_id=1&user_id=4');
		$this->assign('url1', $url1);
		$this->assign('url2', $url2);
		$this->assign('url3', $url3);
		$this->assign('url4', $url4);
		$this->display();
    }
}