<?php
return array(

	// 数据库
	'DB_HOST'	=> 	'localhost',// 数据库地址
	'DB_NAME'	=>	'interview', 	// 数据库名称
	'DB_USER'	=>	'root',		// 数据库用户名
	'DB_PWD'	=>	'',			// 数据库密码
	'DB_PORT'	=>	'3306',		// 数据库端口
	'DB_PREFIX' => 	'it_',	// 数据库前缀
	
	// 模版
	//'TMPL_L_DELIM'	=>	'<{',	// 模版变量前缀
	//'TMPL_R_DELIM'	=>	'}>',	// 模版变量后缀
	
	'APP_GROUP_LIST' => 'Home',
	
	'TMPL_PARSE_STRING' => array(
		
		'__ROOT__' => 'http://xiaoqs.com',		// 网站地址
		'__ROOT0__' => 'http://t0.xiaoqs.com',		// 备用网站地址
		'__ROOT1__' => 'http://t1.xiaoqs.com',		// 备用网站地址
		'__ROOT2__' => 'http://t2.xiaoqs.com',		// 备用网站地址
		'__ROOT3__' => 'http://t3.xiaoqs.com',		// 备用网站地址
		'__ROOT4__' => 'http://t4.xiaoqs.com',		// 备用网站地址
		'__ROOT5__' => 'http://t5.xiaoqs.com',		// 备用网站地址
		'__ROOTIP__' => 'xiaoqs.com',
		/*
		'__ROOT__' => 'http://111.186.54.241:88',		// 网站地址
		'__ROOT0__' => 'http://111.186.54.241:88',		// 备用网站地址
		'__ROOT1__' => 'http://111.186.54.241:88',		// 备用网站地址
		'__ROOT2__' => 'http://111.186.54.241:88',		// 备用网站地址
		'__ROOT3__' => 'http://111.186.54.241:88',		// 备用网站地址
		'__ROOT4__' => 'http://111.186.54.241:88',		// 备用网站地址
		'__ROOT5__' => 'http://111.186.54.241:88',		// 备用网站地址
		'__ROOTIP__' => '111.186.54.241',
		*/
		'__NAME__' => '小轻松',						// 网站名字
	),
	
	'URL_MODEL' => '0',	// 路由模式
	
	//'SHOW_PAGE_TRACE' => true,	// 显示调试信息
	
	//'TMPL_ACTION_ERROR' => 'Page:dispatch', 	// 错误页面
	//'TMPL_ACTION_SUCCESS' => 'Page:dispatch', 	// 成功页面
	
	// 静态缓存
	//'PAGE_CACHE' => false,
	
	// INCLUDE文件分割
	//'TAGLIB_BEGIN' => '<',
	//'TAGLIB_END'   => '>',
);
?>