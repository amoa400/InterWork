<?php
class CompileAction extends Action {
	// 编译运行
    public function compileRun() {
		$post = $_POST;
		file_put_contents('D:\Match\t\1.cpp', $post['code']);
		file_put_contents('D:\Match\t\in.txt', $post['data']);
		unlink('D:\Match\t\1.exe');
		system('D:\Match\t\Bin\g++.exe D:\Match\t\1.cpp -o D:\Match\t\1.exe 2> D:\Match\t\out.txt', $t);
		if ($t == 0)
			system('D:\Match\t\1.exe < D:\Match\t\in.txt > D:\Match\t\out.txt');
		$ret = array();
		$ret['result'] = file_get_contents('D:\Match\t\out.txt');
		if ($t != 0)
			$ret['result'] = "编译错误：\r\n".$ret['result'];
		echo json_encode($ret);
    }
}