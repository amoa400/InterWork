<?php
	session_start();
	define('__ROOT__', '../');
	define('APP_NAME', 'Xiaoqs_VerOne');
	define('APP_PATH', '../');
	require("../../ThinkPHP/ThinkPHP.php");
	
	App::run();
?>