<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>用户管理-添加用户</title>
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
<script type="text/javascript" src="views/js/add_users.js"></script>
</head>

<body>
<div class="box">
  <table class="wrap" cellspacing="0">
    <tr class="top">
      <td class="top_l"></td>
      <td class="top_m"><div class="title"><span>添加用户</span></div></td>
      <td class="top_r"></td>
    </tr>
    <tr class="mid">
      <td class="mid_l"></td>
      <td class="mid_m">
      <!------------------------自定义--------------------------->
      <div class="content">
      	  <div class="intro">
          	<p>当前位置：添加用户</p>
            <img src="views/images/add_users.png" />
            <span>在这里，您可以为管理中心添加新的管理员和用户！<br /><br />需要提供的信息包括：用户名，密码，用户权限等。</span>
          </div>
          <form id="myform" action="index.php?action=users_manage&method=add_newuser" method="post">
 	  	<table class="setting" border="0" cellspacing="0">
      	<thead><tr><th>新用户列表</th><th></th><th></th></tr></thead>
        <tbody>
            <tr>
                <td width="20%">用户名：</td>
                <td width="30%"><input type="text" name="new_uname" size="20" /></td>
                <td><span class="must">*</span>用户的名称，只允许使用数字，大小写英文字母</td>
            </tr>
            <tr>
                <td>登录密码：</td>
                <td><input type="password" name="new_pwd1" size="20"/></td>
                <td><span class="must">*</span>用户登录时使用的密码</td>
            </tr>
            <tr>
                <td>重复输入密码：</td>
                <td><input type="password" name="new_pwd2" size="20" /></td>
                <td><span class="must">*</span>请再输入一次登录密码，确保登录密码无误</td>
            </tr>
             <tr>
                <td>用户权限：</td>
                <td><select name="new_per" id="new_per">
                    <option value="3" selected="selected">普通用户</option>
                	<option value="2" >普通管理员</option>
                	<option value="1">高级管理员</option>
                    <option value="0">超级管理员</option>
                </select></td>
                <td><span class="must">*</span>设置用户的权限级别</td>
            </tr>
            <tr>
                <td>工号：</td>
                <td><input type="text" name="new_wid" size="20" /></td>
                <td>设置用户的工号</td>
            </tr>
            <tr>
                <td>真实姓名：</td>
                <td><input type="text" name="new_realname" size="20" /></td>
                <td>设置用户的真实姓名</td>
            </tr>
            <tr>
                <td>所属部门：</td>
                <td><input type="text" name="new_dep" size="20" /></td>
                <td>说明该用户的所属部门</td>
            </tr>
            <tr>
                <td>称谓：</td>
                <td><input type="text" name="new_app" size="20" /></td>
                <td>说明该用户的称谓</td>
            </tr>
             <tr>
                <td>手机号码：</td>
                <td><input type="text" name="new_phone" size="20" /></td>
                <td>设置用户的手机长号</td>
            </tr>
             <tr>
                <td>手机短号：</td>
                <td><input type="text" name="new_short" size="20" /></td>
                <td>设置用户的手机短号</td>
            </tr>
             <tr>
                <td>办公电话：</td>
                <td><input type="text" name="new_office" size="20" /></td>
                <td>设置用户的办公电话</td>
            </tr>
             <tr>
                <td>家庭电话：</td>
                <td><input type="text" name="new_home" size="20" /></td>
                <td>设置用户的家庭电话</td>
            </tr>
            <tr>
                <td>电子邮箱：</td>
                <td><input type="text" name="new_email" size="20" /></td>
                <td>设置用户的邮箱地址</td>
            </tr>
            <tr>
                <td>QQ号码：</td>
                <td><input type="text" name="new_qq" size="20" /></td>
                <td>设置用户的QQ号码</td>
            </tr>
        </tbody>
      </table>
      <div class="op"><input type="submit" name="sub" value="添加"/>&nbsp;<input type="reset" name="re" value="重置"/></div>
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
