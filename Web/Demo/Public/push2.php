<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
  <head> 
    <title>Comet demo</title> 
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
    <script type="text/javascript" src="js/jquery.min.js"></script> 
    <script> 
    var timestamp = 0; 
    var url = 'push.php'; 
    var error = false; 
/*
    function connect(){ 
        $.ajax({ 
            data : {'timestamp' : timestamp}, 
            url : url, 
            type : 'get', 
            timeout : 0, 
            success : function(response){ 
                var data = eval('('+response+')'); 
                error = false; 
                timestamp = data.timestamp; 
                $("#content").append('<div>' + data.msg + '</div>'); 
            }, 
            error : function(){ 
                error = true; 
                //setTimeout(function(){ connect();}, 5000); 
            }, 
            complete : function(){ 
                if (error) 
                    // if a connection problem occurs, try to reconnect each 5 seconds 
                    setTimeout(function(){connect();}, 5000); 
                else 
                    connect(); 
            } 
        }) 
    } 
*/

var plugin_list = 'code';
var identifier_list = '0';

function connect(){
	
	
	$.ajax({
		data : {'id' : 1, 'plugin' : plugin_list, 'identifier' : identifier_list},
		url : 'http://xiaoqs.com/Room/getInfo',
		type : 'get',
		timeout : 0,
		success : function(response){
			var data = eval('(' + response + ')');
			error = false;
                $("#content").append('<div>' + data.code.code + '</div>'); 
identifier_list =  data.code.identifier;

			//process(data);
        },
        error : function(){
			error = true;
        },
        complete:function(){
			if (error)
				setTimeout('connect()', 100);
			else
				setTimeout('connect()', 100);
        }
	});
}


    function send(msg){ 
        $.ajax({ 
            data : {'msg' : msg}, 
            type : 'get', 
            url : url 
        }) 
    } 
    $(document).ready(function(){ 
        connect(); 
    }) 
    </script> 
  </head> 
  <body> 
  
<?php echo 123; ?>

  <div id="content"> 
  </div> 
  
  <p> 
    <form action="" method="get" onsubmit="send($('#word').val());$('#word').val('');return false;"> 
      <input type="text" name="word" id="word" value="" /> 
      <input type="submit" name="submit" value="Send" /> 
    </form> 
  </p> 
  
  </body> 
</html>