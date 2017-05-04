<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>用户管理-编辑用户</title>
<link href="views/style/base.css" rel="stylesheet" type="text/css">
<style type="text/css">
.message { position:absolute;
		   z-index:10;
		   margin:0px 450px; 
		   width:160px; 
		   height:20px; 
		   text-align:center;
		   padding-top:5px;
		   display:none;
		   }
.intro a { color:#666; text-decoration:none;}
.intro a:hover { color:#900;}
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
			var info = "修改失败";
			var name = $.trim(form.new_uname.value);
			var per = $.trim(form.new_per.value);

			if((name=="")||(per=="")) {
				isok = false;
				info += "必填项不能为空";	
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
			  window.location.href="index.php?action=users_manage&method=show_users";
		  }else if($.trim(responseText)=="exist") {
			  $(".message").addClass("red");
			  $(".message").find("span").text("修改失败！该用户名已存在");
		  }else{
			  $(".message").addClass("red");
			  $(".message").find("span").text("修改失败！");
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
  <table class="wrap" cellspacing="0">
    <tr class="top">
      <td class="top_l"></td>
      <td class="top_m"><div class="title"><span>编辑用户</span></div></td>
      <td class="top_r"></td>
    </tr>
    <tr class="mid">
      <td class="mid_l"></td>
      <td class="mid_m">
      <!------------------------自定义--------------------------->
      <div class="content">
      	  <div class="intro">
          	<p>当前位置：<a href="index.php?action=users_manage&method=show_users">用户管理</a>->编辑用户</p>
            <img src="views/images/edit_user.png" />
            <span>在这里，您可以编辑当前的用户信息！<br /><br />可以修改的信息包括：用户名，管理员权限，真实姓名，负责工作内容，邮箱，联系电话，QQ号码。</span>
          </div>
          <form id="myform" action="index.php?action=users_manage&method=update_user&uid=<?php echo $user[0]['uid'];?>" method="post">
 	  	<table class="setting" border="0" cellspacing="0">
      	<thead><tr><th>用户信息列表</th><th></th><th></th></tr></thead>
        <tbody>
            <tr>
                <td width="20%">用户名：</td>
                <td width="30%"><input type="text" name="new_uname" size="20" value="<?php echo $user[0]['username'];?>"/></td>
                <td><span class="must">*</span>修改用户的名称</td>
            </tr>
             <tr>
                <td>管理员权限：</td>
                <td><select name="new_per" id="new_per">
                	<option value="3" <?php if($user[0]['permission']==3){echo "selected='selected'";};?>>普通用户</option>
                	<option value="2" <?php if($user[0]['permission']==2){echo "selected='selected'";};?>>普通管理员</option>
                	<option value="1" <?php if($user[0]['permission']==1){echo "selected='selected'";};?>>高级管理员</option>
                    <option value="0" <?php if($user[0]['permission']==0){echo "selected='selected'";};?>>超级管理员</option>
                </select></td>
                <td><span class="must">*</span>修改用户的权限级别</td>
            </tr>
            <tr>
                <td>工号：</td>
                <td><input type="text" name="new_wid" size="20" value="<?php echo $user[0]['wid'];?>"/></td>
                <td>说明该用户的工号</td>
            </tr>
            <tr>
                <td>真实姓名：</td>
                <td><input type="text" name="new_realname" size="20" value="<?php echo $user[0]['realname'];?>"/></td>
                <td>修改用户的真实姓名</td>
            </tr>
            <tr>
                <td>所属部门：</td>
                <td><input type="text" name="new_dep" size="20" value="<?php echo $user[0]['department'];?>"/></td>
                <td>说明该用户所属的部门</td>
            </tr>
             <tr>
                <td>称谓：</td>
                <td><input type="text" name="new_app" size="20" value="<?php echo $user[0]['appellation'];?>"/></td>
                <td>说明该用户的称谓</td>
            </tr>
             <tr>
                <td>手机号码：</td>
                <td><input type="text" name="new_phone" size="20" value="<?php echo $user[0]['uphone'];?>"/></td>
                <td>修改用户的手机长号</td>
            </tr>
             <tr>
                <td>手机短号：</td>
                <td><input type="text" name="new_short" size="20" value="<?php echo $user[0]['ushort'];?>"/></td>
                <td>修改用户的手机短号</td>
            </tr>
             <tr>
                <td>办公电话：</td>
                <td><input type="text" name="new_office" size="20" value="<?php echo $user[0]['uoffice'];?>"/></td>
                <td>修改用户的办公电话</td>
            </tr>
             <tr>
                <td>家庭电话：</td>
                <td><input type="text" name="new_home" size="20" value="<?php echo $user[0]['uhome'];?>"/></td>
                <td>修改用户的家庭电话</td>
            </tr>
            <tr>
                <td>电子邮箱：</td>
                <td><input type="text" name="new_email" size="20" value="<?php echo $user[0]['uemail'];?>"/></td>
                <td>修改用户的邮箱地址</td>
            </tr>
            <tr>
                <td>QQ号码：</td>
                <td><input type="text" name="new_qq" size="20" value="<?php echo $user[0]['uqq'];?>"/></td>
                <td>修改用户的QQ号码</td>
            </tr>
        </tbody>
      </table>
      <div class="op"><input type="submit" name="sub" value="修改"/>&nbsp;<input type="reset" name="re" value="恢复"/></div>
      <div class="message"><span></span></div>
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
