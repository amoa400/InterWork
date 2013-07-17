/*
	实时通信
*/
// 定义变量
var errorConnect = false;
var plugin =  new Array('message', 'code', 'blackboard', 'webpage');
var identifier = new Array();
var content = new Array();

var blackboard_last_x = 0;
var blackboard_last_y = 0;

// 连接服务器
$(document).ready(function(){
	for (var i = 0; i < plugin.length; i++)
		identifier[plugin[i]] = 0;
	connect();
	update();

	// 退出页面时
	$(window).bind('beforeunload', function (e) {
		$.ajax({
			data : {'room_id' : room_id, 'user_id' : user_id},
			url : sessionUrl,
			type : 'get',
			async : false,
		});
	});
});

// 连接服务器获取信息
function connect(){
	if (errorConnect) return;
	var plugin_list = '';
	var identifier_list = '';
	for (var i = 0; i < plugin.length; i++) {
		plugin_list += plugin[i]+',';
		identifier_list += identifier[plugin[i]]+',';
	}
	$.ajax({
		data : {'room_id' : room_id, 'user_id' : user_id, 'session_id' : session_id, 'plugin' : plugin_list, 'identifier' : identifier_list},
		url : url,
		type : 'get',
		dataType : 'jsonp',
		jsonp: 'jsonp_callback',
		timeout : 0,
		success : function(data) {
			error = false;
			process(data);
        },
        error : function(){
			error = true;
        },
        complete:function(){
			if (error)
				setTimeout('connect()', 1000);
			else
				setTimeout('connect()', 100);
        }
	});
}

// 处理信息
function process(data) {
	// 错误处理
	if (data.error != null) {
		alert(data.error);
		errorConnect = true;
		return;
	}
	// 时间插件
	if (data.time != null) {
		start_time = data['time'].start_time;
		tot_time = data['time'].cnt_time - data['time'].start_time;
	}
	// 消息插件
	if (data.message != null && identifier['message'] < data.message.identifier)  {
		identifier['message'] = data.message.identifier;
		content['message'] = data.message.content;
		for (var i = 0; i < content['message'].length; i++ ) {
			if (content['message'][i].type == 0)
				$('#plugin_message .content').append("<div class='it'><span class='system'>"+content['message'][i].content+"</span></div>");
			else
			if (content['message'][i].type == 1)
				$('#plugin_message .content').append("<div class='it'><span class='interviewer'>"+content['message'][i].author+"：</span>"+content['message'][i].content+"</div>");
			else {
				$('#plugin_message .content').append("<div class='it'><span class='candidate'>"+content['message'][i].author+"：</span>"+content['message'][i].content+"</div>");
			}
		}
		$('#plugin_message .content').scrollTop($('#plugin_message .content')[0].scrollHeight);
	}
	// 代码插件
	if (data.code != null && identifier['code'] < data.code.identifier) {
		identifier['code'] = data.code.identifier;
		content['code'] = data.code.code;
		var cursor = editor.getCursorPosition();
		editor.getSession().setValue(data.code.code);
		editor.moveCursorTo(cursor.row, cursor.column);
	}
	// 黑板插件
	if (data.blackboard != null) {
		identifier['blackboard'] = data.blackboard.identifier;
		content['blackboard'] = data.blackboard.content;
		for (var i = 0; i < content['blackboard'].length; i++ ) {
			var cont_list = content['blackboard'][i].content.split(';');
			for (var j = 0; j < cont_list.length; j++) {
				if (cont_list[j] == '') continue;
				var cont = cont_list[j].split(',');
				// 画板大小
				if (cont[2] == 'widthHeight') {
					blackboard_resetWidthHeight(cont[0], cont[1]);
				}
				// 起点
				else
				if (cont[2] == 'start') {
					blackboard_last_x = cont[0];
					blackboard_last_y = cont[1];
				}
				// 终点
				else
				if (cont[2] == 'end') {
					blackboard_last_x = 0;
					blackboard_last_y = 0;
				}
				// 橡皮
				else
				if (cont[2] == 'rubber') {
					reRubber(cont[0], cont[1]);
				}
				// 清除
				else
				if (cont[2] == 'clear') {
					reClear();
				}
				// 作画中
				else {
					reDraw(blackboard_last_x, blackboard_last_y, cont[0], cont[1], cont[2]);
					blackboard_last_x = cont[0];
					blackboard_last_y = cont[1];
				}
			}
		}
	}
	// 网页插件
	if (data.webpage != null) {
		identifier['webpage'] = data.webpage.identifier;
		content['webpage'] = data.webpage.content;
		var t = new Object();
		for (var i = 0; i < content['webpage'].length; i++ ) {
			t[content['webpage'][i].name] = i;
			var flag = false;
			for (var j = 0; j < webpage_name_container.length; j++) {
				if (webpage_name_container[j] == content['webpage'][i].name) {
					flag = true;
					break;
				}
			}
			if (!flag) {
				create_webpage('', content['webpage'][i].name , true);
			}
		}
		for (var i = 0; i < content['webpage'].length; i++ ) {
			if (i != t[content['webpage'][i].name]) continue;
			var flag = false;
			for (var j = 0; j < webpage_name_container.length; j++) {
				if (webpage_name_container[j] == content['webpage'][i].name) {
					if (content['webpage'][i].url != 'close') redirect_webpage(content['webpage'][i].name, content['webpage'][i].url, true);
					else close_webpage(content['webpage'][i].name, true);
					flag = true;
					break;
				}
			}
			if (!flag && content['webpage'][i].url != 'close') {
				create_webpage(content['webpage'][i].url, content['webpage'][i].name , true);
			}
		}
	}
}

// 内容更新
function update() {
	var post = new Object();
	post['room_id'] = room_id;
	post['user_id'] = user_id;
	// 查询每个插件是否有内容更新
	var flag = false;
	for (var i = 0; i < plugin.length; i++) {
		// 消息插件
		if (plugin[i] == 'message') {
			var id = cnt_message_container;
			cnt_message_container++;
			if (cnt_message_container >= tot_message_container)
				cnt_message_container = 0;
			var cont = message_container[id];
			message_container[id] = new Array();
			if (cont.length > 0) {
				post['message'] = new Object();
				var data = new Object();
				for(var key in cont) {
					data[key] = new Object();
					data[key]['content'] = cont[key];
				}
				post['message']['content'] = data;
				flag = true;
			}
		}
		// 代码插件
		if (plugin[i] == 'code') {
			var cont = editor.getSession().getValue();
			if (content['code'] != cont) {
				content['code'] = cont;
				post['code']  = new Object();
				post['code']['content'] = cont;
				post['code']['identifier'] = identifier['code'];
				identifier['code']++;
				flag = true;
			}
		}
		// 黑板插件
		if (plugin[i] == 'blackboard') {
			var id = cnt_board_container;
			cnt_board_container++;
			if (cnt_board_container >= tot_board_container)
				cnt_board_container = 0;
			var cont = board_container[id];
			board_container[id] = '';
			if (cont != '') {
				post['blackboard'] = new Object();
				post['blackboard']['content'] = cont;
				flag = true;
			}
		}
		// 网页插件
		if (plugin[i] == 'webpage') {
			var id = cnt_webpage_container;
			cnt_webpage_container++;
			if (cnt_webpage_container >= tot_webpage_container)
				cnt_webpage_container = 0;
			var cont = webpage_container[id];
			webpage_container[id] = new Array();
			if (cont.length > 0) {
				post['webpage'] = new Object();
				var data = new Object();
				for(var key in cont) {
					data[key] = new Object();
					data[key]['type'] = cont[key]['type'];
					data[key]['name'] = cont[key]['name'];
					data[key]['url'] = cont[key]['url'];
				}
				post['webpage']['content'] = data;
				flag = true;
			}
		}
	}

	
	// 更新内容
	if (flag) {
		$.ajax({
			data : post,
			url : updateUrl,
			type : 'post',
			dataType : 'json',
			success : function(data){
				//alert(data);
				setTimeout('update()', 100);
        	},
		});
		
	} else {
		setTimeout('update()', 100);
	}
}

/*
	消息插件
*/

var cnt_message_container = 0;
var tot_message_container = 5;
var message_container = new Array();
for (var i = 0; i < tot_message_container; i++)
	message_container[i] = new Array();
	
// 发送消息
function submit_message() {
	var s = $('#plugin_message .input input').val();
	message_container[cnt_message_container].push(s);
	$('#plugin_message .input input').val('');
}

// 绑定回车
$('#plugin_message .input input').bind('keydown', function (e) {
	var key = e.which;
	if (key == 13) {
		e.preventDefault();
		submit_message();
	}
});

/*
	代码编辑器插件
*/

// 编辑器初始化
var editor = ace.edit("editor");
//editor.setTheme("ace/theme/tomorrow_night");
//editor.setTheme("ace/theme/chrome");
//editor.setTheme("ace/theme/crimson_editor");
editor.setTheme("ace/theme/textmate");
//editor.setTheme("ace/theme/xcode");
editor.getSession().setMode("ace/mode/c_cpp");
editor.getSession().setUseWrapMode(true);
editor.setShowPrintMargin(false);

// 输入数据
function inputData() {
	if ($('#input_data').css('display') == 'none') {
		$('#plugin_code .data').css('display', 'block');
		$('#input_data').css('display', 'block');
		$('#output_data').css('display', 'none');
		$('#input_data').focus();
	}
	else {
		$('#plugin_code .data').css('display', 'none');
		$('#input_data').css('display', 'none');
	}
}

// 编译运行
var compiling = false;
function compileRun() {
	if (compiling) return;
	compiling = true;
	var post = new Object;
	post.room_id = room_id;
	post.code = editor.getSession().getValue();
	post.data = $('#input_data').val();
	$('#output_data').val('正在编译运行...');
	showResult(true);
	$.ajax({
		data : post,
		url : compileUrl,
		type : 'post',
		dataType : 'json',
		success : function(data){
			$('#output_data').val(data.result);
			showResult(true);
			compiling = false;
			$('#plugin_code .tool .compile').html('<i class="icon-play-circle icon-white"></i>&nbsp;编译运行');
       	},
	});
}

// 查看运行结果
function showResult(flag) {
	if (flag != null || $('#output_data').css('display') == 'none') {
		$('#plugin_code .data').css('display', 'block');
		$('#output_data').css('display', 'block');
		$('#input_data').css('display', 'none');
	}
	else {
		$('#plugin_code .data').css('display', 'none');
		$('#output_data').css('display', 'none');
	}
}

/*
	网页插件
*/
var webpage_name_container = new Array();
var webpage_url_container = new Array();
var cnt_webpage_name;
var cnt_webpage_container = 0;
var tot_webpage_container = 5;
var webpage_container = new Array();
for (var i = 0; i < tot_webpage_container; i++)
	webpage_container[i] = new Array();

// 创建新标签
function create_webpage(url, name, notRecord) {
	url = auto_insert_http(url);
	// 随机一个名称
	if (name == null)
		name = parseInt(Math.random()*10000000+1);
	webpage_name_container.push(name);
	webpage_url_container.push(url);
	// 添加新标签
	var tab = $("<div id='tab_"+name+"' class='item' onclick='switch_webpage("+name+")'><span>浏览网页</span><i class='icon icon-remove' onclick='close_webpage("+name+")'></i></div>");
	var tot_child = $('#plugin_webpage .tab').children().length;
	var new_tab = $('#plugin_webpage .tab').children().eq(tot_child-2);
	var clear = $('#plugin_webpage .tab').children().eq(tot_child-1);
	new_tab.remove();
	clear.remove();
	$('#plugin_webpage .tab').append(tab);
	$('#plugin_webpage .tab').append(new_tab);
	$('#plugin_webpage .tab').append(clear);
	// 添加新iframe
	var iframe = $("<iframe id='iframe_"+name+"' src='"+url+"'></iframe>");
	$('#plugin_webpage .page').append(iframe);
	// 切换到新标签
	switch_webpage(name);
	// 记录
	if (notRecord == null) {
		var data = new Array();
		data['type'] = 'create';
		data['name'] = name;
		data['url'] = url;
		webpage_container[cnt_webpage_container].push(data);
	}
}

// 切换到标签
function switch_webpage(name) {
	for (var i = 0; i < webpage_name_container.length; i++) {
		if (webpage_name_container[i] == name) {
			$('#plugin_webpage .tool input').val(webpage_url_container[i]);
			$('#plugin_webpage .tab .item').removeClass('active');
			$('#plugin_webpage iframe').css('display', 'none');
			$('#tab_'+name).addClass('active');
			$('#iframe_'+name).css('display', 'block');
			cnt_webpage_name = name;
			break;
		}
	}
}

// 关闭标签
function close_webpage(name, notRecord) {
	if ($('#iframe_'+name).css('display') != 'none') {
		var index = 0;
		for (var i = 0; i < webpage_name_container.length; i++) {
			if (webpage_name_container[i] == name) {
				index = i;
				break;
			}
		}
		var flag = false;
		for (var i = index + 1; i < webpage_name_container.length; i++) {
			if (webpage_name_container[i] != null ) {
				switch_webpage(webpage_name_container[i]);
				flag = true;
				break;
			}
		}
		if (!flag) {
			for (var i = index - 1; i >= 0; i--) {
				if (webpage_name_container[i] != null ) {
					switch_webpage(webpage_name_container[i]);
					flag = true;
					break;
				}
			}
		}
		if (!flag) {
			$('#plugin_webpage .tool input').val('');
			cnt_webpage_name = null;
		}
	}
	$('#tab_'+name).remove();
	$('#iframe_'+name).remove();
	for (var i = 0; i < webpage_name_container.length; i++) {
		if (webpage_name_container[i] == name) {
			webpage_name_container[i] = null;
			webpage_url_container[i] = null;
			break;
		}
	}
	// 记录
	if (notRecord == null) {
		var data = new Array();
		data['type'] = 'close';
		data['name'] = name;
		webpage_container[cnt_webpage_container].push(data);
	}
}

// 重定向网页
function redirect_webpage(name, url, notRecord) {
	url = auto_insert_http(url);
	if (name == null) {
		create_webpage(url);
		return false;
	}
	var index = 0;
	for (var i = 0; i < webpage_name_container.length; i++) {
		if (webpage_name_container[i] == name) {
			index = i;
			break;
		}
	}
	if (url != 'http://')
		webpage_url_container[index] = url;
	else
		url = webpage_url_container[index];
	$('#iframe_'+name).remove();
	var iframe = $("<iframe id='iframe_"+name+"' src='"+webpage_url_container[index]+"'></iframe>");
	$('#plugin_webpage .page').append(iframe);
	switch_webpage(name);
	// 记录
	if (notRecord == null) {
		var data = new Array();
		data['type'] = 'redirect';
		data['name'] = name;
		data['url'] = url;
		webpage_container[cnt_webpage_container].push(data);
	}
	return false;
}

// 自动添加HTTP
function auto_insert_http(url) {
	if (url.indexOf('://') == -1) return 'http://'+url;
	else return url;
}

/*
	计时器
*/
var start_time = 0;
var tot_time = 0;
function set_timer() {
	var time_obj = new Date(start_time * 1000);
	var YY = 1900 + time_obj.getYear();
	var MM = time_obj.getMonth();
	if (MM < 10) MM = '0' + MM;
	var DD = time_obj.getDate();
	if (DD < 10) DD = '0' + DD;
	var hh = time_obj.getHours();
	if (hh < 10) hh = '0' + hh;
	var mm = time_obj.getMinutes();
	if (mm < 10) mm = '0' + mm;
	var ss = time_obj.getSeconds();
	if (ss < 10) ss = '0' + ss;
	$('#start_time').html(YY+'-'+MM+'-'+DD+' '+hh+':'+mm+':'+ss);
	var hour = Math.floor(tot_time / 3600);
	var minute = Math.floor((tot_time - hour * 3600) / 60);
	var second = tot_time - hour * 3600 - minute * 60;
	var s = '';
	if (hour != 0) s += hour + '小时';
	if (minute < 10) minute = '0' + minute;
	if (hour != 0 || minute != 0) s += minute + '分';
	if (second < 10) second = '0' + second;
	s += second + '秒';
	$('#timer').html(s);
	tot_time++;
	setTimeout('set_timer()', 1000);
}
set_timer();

/*
	页面元素设置
*/
var headerHeight = 70;
var topHeight = 31;				// 顶部高度
var toolbarHeight = 0;			// 左部工具栏高度
var activeVideoWidth = 320;		// 活动视频宽度
var activeVideoHeight = 240;	// 活动视频高度
var videoHeight = 320;			// 视频宽度
var videoWidth = 240;			// 视频高度

// 重新设定长宽
function resetWidthHeight(type) {
	var pageHeight = parseInt($('#room').css('height'));
	var pageWidth = parseInt($('#room').css('width'));
	var mainHeight = pageHeight - headerHeight - toolbarHeight;
	$('.main').css('height', pageHeight - headerHeight - toolbarHeight);
	
	// 获取视频高度宽度
	if (type == null) {
		var rightHeight = mainHeight - topHeight;
		var marginTop = 0;
		for (var i = 4; i < 10; i++) {
			videoHeight = (rightHeight - 2 * i) / 3;
			var re = /^\+?[1-9][0-9]*$/;
			if (re.test(videoHeight)) {
				videoWidth = parseInt(640 * videoHeight / 480);
				marginTop = i;
				break;
			}
		}
		$('.video').css('height', videoHeight);
		$('.video').css('width', videoWidth);
		$('.video_obj').css('height', videoHeight);
		$('.video_obj').css('width', videoWidth);
		$('.video').css('border-top', marginTop+'px solid #666666');
		$('.first_video').css('border-top', '0');
		$('.header').css('width', videoWidth + 5);
	}
		
	// 左部区域
	if (type == null) {
		$('.left_area').css('width', videoWidth);
		$('.left_area .message .content').css('height', mainHeight - videoHeight - 2 * topHeight - 30 - 1 - 20);
		$('.left_area .message .content2').css('height', mainHeight - videoHeight - 2 * topHeight - 30 - 1 - 20);
	}
	
	// 右部区域
	if (type == null) {
		$('.right_area').css('width', videoWidth);
	}

	// 互动区
	if (type==null) {
		$('.interactive').css('width', pageWidth - 2 * videoWidth - 8 * 2);
		$('.interactive .ct').css('height', mainHeight - topHeight + 'px');
	}
	
	// 信息版
	if (type == null || type == 'info') {
	}

	// 代码插件
	if (type == null || type == 'code') {
		$('#editor').css('width', parseInt($('#plugin_code').css('width')) + 'px');
		$('#editor').css('height', mainHeight - topHeight - 30 + 'px');
		editor.resize();
	}
	
	// 黑板插件
	if (type == null || type == 'blackboard') {
		$('#canvas').attr('width', $('.interactive').css('width'));
		$('#canvas').attr('height', mainHeight - topHeight - 30);
		identifier['blackboard'] = 0;
		config.width = parseInt($('#canvas').attr('width'));
		config.height = parseInt($('#canvas').attr('height'));
	}
	
	// 网页插件
	if (type == null || type == 'webpage') {
		var width = parseInt($('#plugin_webpage').css('width'));
		var height = parseInt($('#plugin_webpage').css('height'));
		$('#plugin_webpage .tool .url input').css('width', width - 83 + 'px');
		$('#plugin_webpage .page').css('height', height - 79 + 'px');
		$('#plugin_webpage .page').css('width', width + 'px');
	}
}
resetWidthHeight();

/*页面变化*/
var pageWidth = $(window).width();
var activeDiv = '';
var leftWidth = parseInt($('.left_area').css('width'));
var interactiveWidth = parseInt($('.interactive').css('width'));

$(window).resize(function() {
	var newPageWidth = $(window).width();
	$('.left_area').css('width', leftWidth / pageWidth * newPageWidth + 'px');
	$('.interactive').css('width', interactiveWidth / pageWidth * newPageWidth + 'px');
	leftWidth = parseInt($('.left_area').css('width'));
	interactiveWidth = parseInt($('.interactive').css('width'));
	pageWidth = newPageWidth;
	resetWidthHeight();	
});

// 插件显示
function show_plugin(name) {
	$('.interactive .ct').css('display', 'none');
	$('.interactive .top li').removeClass('active');
	$('#plugin_'+name).css('display', 'block');
	$('#btn_'+name).addClass('active');
	if (name != 'blackboard')
		resetWidthHeight(name);
}