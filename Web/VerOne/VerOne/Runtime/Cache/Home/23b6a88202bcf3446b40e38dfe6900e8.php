<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="description" content="____NAME____国内首家互动式在线面试平台" />
	<title>____NAME____国内首家互动式在线面试平台</title>

	<link href="__ROOT__/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="__ROOT__/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css">
	<link href="__ROOT__/css/jquery-ui-1.10.3.custom.min.css" rel="stylesheet" type="text/css">
	<link href="__ROOT__/css/global.css" rel="stylesheet" type="text/css">

	<script src="__ROOT__/js/jquery.min.js" type="text/javascript" ></script>
	<script src="__ROOT__/js/jquery.json-2.4.min.js" type="text/javascript" ></script>
	<script src="__ROOT__/js/jquery.lazyload.min.js" type="text/javascript" ></script>
	<script src="__ROOT__/js/bootstrap.min.js" type="text/javascript" ></script>
	<script src="__ROOT__/js/jquery-ui-1.10.3.custom.min.js" type="text/javascript" ></script>
	<script src="__ROOT__/js/bootstrap-tooltip.js" type="text/javascript" ></script>	
	<script src="__ROOT__/js/bootstrap-dropdown.js" type="text/javascript" ></script>
	<script src="__ROOT__/js/global.js" type="text/javascript" ></script>

	<script src="__ROOT__/js/ace/ace.js" type="text/javascript" charset="utf-8"></script>
</head>

<body>


<div>
	<?php
 if($_SESSION['login']){ ?>
	<p>欢迎！<b><?php echo ($_SESSION['name']); ?></b><a href="<?php echo ($url_logout); ?>">登出</a></p>
	<?php  } else{ ?>
	<form action="<?php echo ($url_login); ?>" method="post">
	<table>
		<tr><td>Email：</td><td><input type="text" name="email"></td></tr>
		<tr><td>密码：</td><td><input type="password" name="psw"></td></tr>
	</table>
		<input type="submit" value="登陆">
		<?php
 if($_SESSION['tip']){ ?>
			<div><?php echo ($_SESSION['tip']); ?></div>
		<?php  } ?>
	</form>
	<a href="<?php echo ($url_regsiter); ?>">点击注册</a>
	<?php  } ?>
</div>

	

<p>xiaoqs.com</p>
</body>
</html>