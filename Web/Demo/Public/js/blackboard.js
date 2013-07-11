// JavaScript Document

var config={
	canvasPos:{x:0.0,y:0.0},
	colorCanvasPos:{x:0.0,y:0.0},
	adjustOffset:{x:0.0,y:0.0},
	bg:new Image(),
	pressure:1.0,
	i:0,
	x1:0,
	y1:0,
	ratio:4,
	pointerY:36,
	//wrapper:document.getElementById('wrapper'),
	//main:document.getElementById('main'),
	canvas:document.getElementById('canvas'),
	context:document.getElementById('canvas').getContext('2d'),
	context2:document.getElementById('canvas').getContext('2d'),
	//adjustPointer:document.getElementById('pointer'),
	//adjustWidthBar:document.getElementById('widthLevel'),
	//adjustWidthArea:document.getElementById('adjustWidth'),
	//currColorCtx:document.getElementById('currColor').getContext('2d'),
	//colorCanvas:document.getElementById('color'),
	//colorChooser:document.getElementById('colorChooser'),
	//ctx:document.getElementById('color').getContext('2d'),
	eraserState:0,
	startState:0,
	strokeStyle:'#1d1d1d',
	width:100,
	height:100,
	width2:100,
	height2:100,
}

var cnt_board_container = 0;
var tot_board_container = 5;
var board_container = new Array();
for (var i = 0; i < tot_board_container; i++)
	board_container[i] = '';

function init(){
	document.getElementById("canvas").onselectstart = function(){return false;};
	
	//初始化画笔颜色
	config.context.strokeStyle='#1d1d1d';

	//主要绘图事件
	config.canvas.onmousedown=startDrawing;
	config.canvas.onblclick=liftPen;
	
	//加载择色板
	//config.bg.src="color.jpg";
	//config.bg.onload=initColorChooser;	
	
	//粗细调节条
	//config.adjustWidthBar.onmousedown=activateAdjuster;
	//config.adjustWidthBar.onmouseup=deactivateAdjuster;
	//config.adjustPointer.style.top='36px';
	
	//config.currColorCtx.fillStyle='#000';
	//config.currColorCtx.fillRect(0,0,60,30);
	//绑定清除画板事件
	document.getElementById('clearBoard').onclick=clearBoard;	
	//导出为png事件
	//document.getElementById('exportImg').onclick=exportImg;
	//松开鼠标取消事件
	document.documentElement.onmouseup=function(){liftPen();};
	//绑定滚轮事件
	//if(document.addEventListener){
		//document.addEventListener('DOMMouseScroll',scrollFunc,false);
	//}
	//window.onmousewheel=document.onmousewheel=scrollFunc;	
}	
	//绑定橡皮擦事件
	document.getElementById('rubber').onclick=activateEraser;
	
function clearBoard(){
	config.context.clearRect(0,0,960,580);
	board_container[cnt_board_container] += '0,0,clear;';
}

function liftPen(){
	if (config.startState == 1) {
		config.i=0;
		config.startState = 0;
		config.canvas.onmousemove=null;
		//config.adjustWidthArea.onmousemove=null;
		board_container[cnt_board_container] += '0,0,end;';
	}
}
function getCanvasOffset(){
	//var canvasPosLeft=config.wrapper.offsetLeft;
	//var canvasPosTop=config.main.offsetTop;
	
	//return {x:canvasPosLeft,y:canvasPosTop}
}

// 起点
function startDrawing(e){
	if(config.i==0){
		config.startState = 1;
		config.canvasPos=getCanvasOffset();
		if(e.offsetX){
		config.x1=e.offsetX;
		config.y1=e.offsetY;
		}else{
		config.x1=e.layerX;
		config.y1=e.layerY;
		}
		board_container[cnt_board_container] += config.width+','+config.height+',widthHeight;';
		board_container[cnt_board_container] += config.x1+','+config.y1+',start;';
		config.canvas.onmousemove=draw;
	}
}

// 画的过程中
function draw(e){
	config.context.strokeStyle = config.strokeStyle;
	config.context.beginPath();
	if(e.offsetX){
	var x2=e.offsetX
	var y2=e.offsetY;
	}else{
	var x2=e.layerX
	var y2=e.layerY;
	}
	if(config.eraserState==1){
		config.context.clearRect(x2,y2,config.pressure*config.ratio*3,config.pressure*config.ratio*3);
		board_container[cnt_board_container] += x2+','+y2+',rubber;';
	}else{
	config.context.moveTo(config.x1,config.y1);
	config.context.lineTo(x2,y2);
	config.context.lineCap='round';
	config.context.lineJoin='round'
	
	config.context.lineWidth=config.pressure*config.ratio;
	config.context.stroke();
	config.x1=x2;
	config.y1=y2;
		board_container[cnt_board_container] += x2+','+y2+','+config.context.strokeStyle+';';
	}
}

// 重新绘制
function reDraw(x1, y1, x2, y2, color) {
	x1 = parseInt(x1*config.width/config.width2);
	x2 = parseInt(x2*config.width/config.width2);
	y1 = parseInt(y1*config.height/config.height2);
	y2 = parseInt(y2*config.height/config.height2);
	config.context2.strokeStyle = color;
	config.context2.beginPath();
	config.context2.moveTo(x1, y1);
	config.context2.lineTo(x2, y2);
	config.context2.lineCap='round';
	config.context2.lineJoin='round';
	config.context2.lineWidth=config.pressure*config.ratio;
	config.context2.stroke();
}

// 重新橡皮擦除
function reRubber(x1, y1) {
	x1 = parseInt(x1*config.width/config.width2);
	y1 = parseInt(y1*config.height/config.height2);
	config.context2.clearRect(x1, y1, config.pressure*config.ratio*3, config.pressure*config.ratio*3);
} 

// 重新清除
function reClear(){
	config.context2.clearRect(0,0,2000,2000);
}

// 重新设定大小
function blackboard_resetWidthHeight(width, height) {
	config.width2 = width;
	config.height2 = height;
}

function initColorChooser(){
	//config.ctx.drawImage(config.bg,10,0,450,507);
	//config.colorCanvas.onmousedown=getColor;
	//config.colorChooser.onmouseover=liftPen;
	//config.ctx.fillRect(350,10,70,30)
}
function getCanvasPos(){
	//canvasX=config.colorChooser.offsetLeft;
	//canvasY=config.colorChooser.offsetTop;
	//return {x:canvasX,y:canvasY}
}
function getColor(e){
	config.colorCanvasPos=getCanvasPos();
	var cx=e.offsetX;
	var cy=e.offsetY;
	var rgba=config.ctx.getImageData(cx,cy,1,1);
	config.context.strokeStyle='rgba('+rgba.data[0]+','+rgba.data[1]+','+rgba.data[2]+','+config.pressure*255+')';
	config.ctx.fillStyle='rgba('+rgba.data[0]+','+rgba.data[1]+','+rgba.data[2]+','+rgba.data[3]+')';
	config.ctx.fillRect(350,10,70,30)
	//config.currColorCtx.fillStyle='rgba('+rgba.data[0]+','+rgba.data[1]+','+rgba.data[2]+','+rgba.data[3]+')';
	//config.currColorCtx.fillRect(0,0,60,30)
	//config.currColorCtx.strokeStyle='#000000';
	//config.currColorCtx.lineWidth=1;
	//config.currColorCtx.strokeRect(0, 0, 60, 30)
}
function getAdjusterOffset(){
	var adjusterPosTop=config.main.offsetTop;
	return adjusterPosTop
}
function activateAdjuster(){
	//config.adjustWidthArea.onmousemove=moveAdjuster;
}
function deactivateAdjuster(){
	//config.adjustWidthArea.onmousemove=null;
}
function moveAdjuster(e){

	config.adjustOffset=getAdjusterOffset();
	//减去标题高度
	
	config.pointerY=e.clientY-config.adjustOffset-41;
	if(config.pointerY<=200){
	//config.adjustPointer.style.top=config.pointerY+'px';
	}
	config.ratio=config.pointerY/4.5;
}
function scrollFunc(e){
	if(e.wheelDelta){
		if(e.wheelDelta>0)//向上滚
		{
			if(config.pointerY>5){
				config.pointerY-=5;
				//config.adjustPointer.style.top=config.pointerY+'px';
			}else if(config.pointerY<=5&&config.pointerY>0){
				config.pointerY=1
				//config.adjustPointer.style.top=config.pointerY+'px';
				}
			}
		else//向下滚
		{
			if(config.pointerY<=195){
				config.pointerY+=5;
				config.adjustPointer.style.top=config.pointerY+'px';
			}else if(config.pointerY>195&&config.pointerY<=200){
				config.pointerY=200;	
				config.adjustPointer.style.top=config.pointerY+'px';
			}
	}
}
else if(e.detail&&config.pointerY<=200){
	if(e.detail>0)//向上滚
		{
			if(config.pointerY>5){
				config.pointerY-=5;
				config.adjustPointer.style.top=config.pointerY+'px';
			}else if(config.pointerY<=5&&config.pointerY>0){
				config.pointerY=1
				config.adjustPointer.style.top=config.pointerY+'px';
				}
			}
		else//向下滚
		{
			if(config.pointerY<=195){
				config.pointerY+=5;
				config.adjustPointer.style.top=config.pointerY+'px';
			}else if(config.pointerY>195&&config.pointerY<=200){
				config.pointerY=200;	
				config.adjustPointer.style.top=config.pointerY+'px';
			}
	}
} 
config.ratio=config.pointerY/4.5;
}
function activateEraser(){
	config.eraserState = 1;
	$('#plugin_blackboard canvas').css('cursor', 'url(../images/room/rubber3.cur),auto');
}

function changePenColor(color) {
	config.eraserState = 0;
	$('#plugin_blackboard canvas').css('cursor', 'url(../images/room/paint.cur),auto');
	config.context.strokeStyle = color;
	config.strokeStyle = color;
}


function exportImg(){
	var url=config.canvas.toDataURL();
	window.open(url)
}
init();
