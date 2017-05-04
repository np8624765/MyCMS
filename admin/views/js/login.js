$(document).ready(function(){
     //过滤非法字符  
     function stripscript(s){   
         var pattern = new RegExp("[`~!@#$^&*()=|{}':;',\\[\\].<>/?~！@#￥……&*（）——|{}【】‘；：”“'。，、？]");   
         var rs = "";   
         for(var i = 0; i < s.length; i++){   
                rs = rs+s.substr(i, 1).replace(pattern,'');   
         }   
         return rs;   
     }
	 
	$("#submit").click(function(){
		var nameuser = $.trim($("#username").val());
		var password = $.trim($("#password").val());
		var identifycode = $.trim($("#code").val());
		if((nameuser=="")||(password=="")) {
			$("p.error").text("用户名或密码不能为空！").show().delay(4000).hide(0);
			return false;
		}
		else if(identifycode=="") {
			$("p.error").text("请填写验证码！").show().delay(4000).hide(0);
			return false;
		}else{
			$.post("index.php?method=login",{name:stripscript(nameuser),pwd:password,code:identifycode},function(data){
				if($.trim(data)=="success") {
					window.location.href="index.php?action=admin";
				}
				if($.trim(data)=="fail") {
					$('img.code').click();
					$("p.error").text("用户名或密码不正确！").show().delay(4000).hide(0);
					return false;		
				}
				if($.trim(data)=="codefail") {
					$('img.code').click();
					$("p.error").text("验证码输入错误！").show().delay(4000).hide(0);
					return false;		
				}
				return false;
			});	
		}
		//
	});
	
});