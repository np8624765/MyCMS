<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>个人安全-修改密码</title>
<link href="views/style/base.css" rel="stylesheet" type="text/css">
<style type="text/css">
.message { position:absolute;
		   z-index:10;
		   margin:45px 300px; 
		   width:160px; 
		   height:20px; 
		   text-align:center;
		   padding-top:5px;
		   display:none;
		   }
table .setting { width:100%; margin:0px 10px; border-top:1px solid #999;}
table .setting .must { color:#F00; display:inline; padding-right:5px;}
table .setting tr { height:30px; text-align:left;}
table .setting thead { background-color:#e1e5ee; }
table .setting thead th { text-align:left; padding-left:10px;}
.even { background-color:#f2f2f2;}
.three { color:#6D6D6D;}
.one { text-align:right; padding-right:20px;}
.op { width:100%; padding:5px 0px 0px 235px;}
.green { background:url(views/images/mess_green.png) left top;}
.red { background:url(views/images/mess_red.png) left top;}
</style>
<script type="text/javascript" src="views/js/jquery-1.6.4.js"></script>
<script type="text/javascript" src="views/js/jquery.form.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('table.setting tbody>tr:even').addClass("even");
	$('table.setting tbody>tr').find('td:eq(0)').addClass("one");
	$('table.setting tbody>tr').find('td:eq(2)').addClass("three");
	
	var options = {        
   					beforeSubmit: showRequest,  
   					success: showResponse,      
   					timeout: 3000               
	}  
  
	function showRequest(formData, jqForm, options){   
		var form = jqForm[0];
		var isok = true;
		var info = "修改失败! ";
		var old = $.trim(form.old_pwd.value);
		var pwd1 = $.trim(form.new_pwd1.value);
		var pwd2 = $.trim(form.new_pwd2.value);
		

		if((old=="")||(pwd1=="")||(pwd2=="")) {
			isok = false;
			info += "必填项不能为空 ";	
		}
		if(pwd1!=pwd2)
		{
			isok = false;
			info += "两次输入的密码不相同 ";	
		}
		if(!isok)
		{
			alert(info);
			return false; 
		}
		return true;
	};  
  
	function showResponse(responseText, statusText){  
   		  if($.trim(responseText)=="ok") {
			  $(".message").removeClass("red");
			  $(".message").addClass("green");
			  $(".message").find("span").text("修改成功");
			  $('#myform').clearForm();
		  }else if($.trim(responseText)=="error"){
			  $(".message").addClass("red");
			  $(".message").find("span").text("修改失败！旧密码错误");
		  }else{
			  $(".message").addClass("red");
			  $(".message").find("span").text("修改失败");
		  }
		  $(".message").slideDown().delay(3000).slideUp();
	};  
	
	$('#myform').submit(function() {  
  		 $(this).ajaxSubmit(options);  
   		 return false; 
	}); 
	
});
</script>
</head>

<body>
<div class="box">
  <div class="message"><span></span></div>
  <table class="wrap" cellspacing="0">
    <tr class="top">
      <td class="top_l"></td>
      <td class="top_m"><div class="title"><span>修改密码</span></div></td>
      <td class="top_r"></td>
    </tr>
    <tr class="mid">
      <td class="mid_l"></td>
      <td class="mid_m">
      <!------------------------自定义--------------------------->
      <div class="content">
      	  <div class="intro">
          	<p>当前位置：修改密码</p>
            <img src="views/images/password.png" />
            <span>在这里，您可以修改你的帐号密码！<br /><br />设置新密码前，你需要输入旧密码。设置新密码之后，新密码将作为你的登录密码，请牢记。</span>
          </div>
          <form id="myform" action="index.php?action=person_safety&method=update_pwd" method="post">
 	  	<table class="setting" border="0" cellspacing="0">
      	<thead><tr><th>修改个人密码</th><th></th><th></th></tr></thead>
        <tbody>
            <tr>
                <td width="20%">你的旧密码：</td>
                <td width="25%"><input type="password" name="old_pwd" size="20" /></td>
                <td><span class="must">*</span>请输入您的旧密码</td>
            </tr>
            <tr>
                <td>你的新密码：</td>
                <td><input type="password" name="new_pwd1" size="20" /></td>
                <td><span class="must">*</span>请输入你要更换的新密码</td>
            </tr>
             <tr>
                <td>重复输入新密码：</td>
                <td><input type="password" name="new_pwd2" size="20" /></td>
                <td><span class="must">*</span>再次输入新密码</td>
            </tr>
        </tbody>
      </table>
      <div class="op"><input type="submit" name="sub" value="修改"/>&nbsp;<input type="reset" name="re" value="重置"/></div>
      </form>
        </div>
        <!------------------------自定义--------------------------->
        </td>
      <td class="mid_r"></td>
    </tr>
    <tr class="bom">
      <td class="bom_l"></td>
      <td class="bom_m"></td>
      <td class="bom_r"></td>
    </tr>
  </table>
</div>
</body>
</html>
