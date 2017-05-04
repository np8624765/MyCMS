<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>个人安全-个人信息</title>
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
<script type="text/javascript" src="views/js/person_info.js"></script>
</head>

<body>
<div class="box">
  <div class="message"><span></span></div>
  <table class="wrap" cellspacing="0">
    <tr class="top">
      <td class="top_l"></td>
      <td class="top_m"><div class="title"><span>个人信息</span></div></td>
      <td class="top_r"></td>
    </tr>
    <tr class="mid">
      <td class="mid_l"></td>
      <td class="mid_m">
      <!------------------------自定义--------------------------->
      <div class="content">
      	  <div class="intro">
          	<p>当前位置：个人信息</p>
            <img src="views/images/person_info.png" />
            <span>在这里，您可以编辑您的个人信息资料！<br /><br />可以修改的信息包括：真实姓名，负责工作内容，邮箱，联系电话，QQ号码等。</span>
          </div>
          <form id="myform" action="index.php?action=person_safety&method=update_info" method="post">
 	  	<table class="setting" border="0" cellspacing="0">
      	<thead><tr><th>个人信息列表</th><th></th><th></th></tr></thead>
        <tbody>
            <tr>
                <td width="20%">真实姓名：</td>
                <td width="35%"><input type="text" name="new_realname" size="20" value="<?php echo $data[0]['realname']?>"/></td>
                <td>修改自己的真实姓名</td>
            </tr>
             <tr>
                <td>工号：</td>
                <td><input type="text" name="new_wid" size="20" value="<?php echo $data[0]['wid']?>"/></td>
                <td>修改自己的工号</td>
            </tr>
            <tr>
                <td>所属部门：</td>
                <td><input type="text" name="new_dep" size="20" value="<?php echo $data[0]['department']?>"/></td>
                <td>修改自己的所属部门</td>
            </tr>
            <tr>
                <td>称谓：</td>
                <td><input type="text" name="new_app" size="20" value="<?php echo $data[0]['appellation']?>"/></td>
                <td>修改自己的称谓</td>
            </tr>
             <tr>
                <td>手机号码：</td>
                <td><input type="text" name="new_phone" size="20" value="<?php echo $data[0]['uphone']?>"/></td>
                <td>修改自己的手机号码</td>
            </tr>
            <tr>
                <td>手机短号：</td>
                <td><input type="text" name="new_short" size="20" value="<?php echo $data[0]['ushort']?>"/></td>
                <td>修改自己的手机短号</td>
            </tr>
            <tr>
                <td>办公电话：</td>
                <td><input type="text" name="new_office" size="20" value="<?php echo $data[0]['uoffice']?>"/></td>
                <td>修改自己的办公电话</td>
            </tr>
            <tr>
                <td>家庭电话：</td>
                <td><input type="text" name="new_home" size="20" value="<?php echo $data[0]['uhome']?>"/></td>
                <td>修改自己的家庭电话</td>
            </tr>
            <tr>
                <td>电子邮箱：</td>
                <td><input type="text" name="new_email" size="20" value="<?php echo $data[0]['uemail']?>"/></td>
                <td>修改自己的邮箱地址</td>
            </tr>
            <tr>
                <td>QQ号码：</td>
                <td><input type="text" name="new_qq" size="20" value="<?php echo $data[0]['uqq']?>"/></td>
                <td>修改自己的QQ号码</td>
            </tr>
        </tbody>
      </table>
      <div class="op"><input type="submit" name="sub" value="修改"/>&nbsp;<input type="reset" name="re" value="恢复"/></div>
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
