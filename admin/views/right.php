<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>后台首页-欢迎界面</title>
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
<script type="text/javascript" src="views/js/base_setting.js"></script>
</head>
<body>
<div class="box">
  <div class="message"><span></span></div>
  <table class="wrap" cellspacing="0">
    <tr class="top">
      <td class="top_l"></td>
      <td class="top_m"><div class="title"><span>欢迎界面</span></div></td>
      <td class="top_r"></td>
    </tr>
    <tr class="mid">
      <td class="mid_l"></td>
      <td class="mid_m">
      <div class="content">
      	  <div class="intro">
          	<p>当前位置：欢迎界面</p>
            <img src="views/images/welcome.png" />
            <span>欢迎，管理员登录MyCMS后台管理系统<br /><br />登录基本信息列表中显示出关于您的客户端ip，操作系统，浏览器等信息，请尽量使用高版本的浏览器访问内容管理系统。</span>
            </div>
      <!------------------------列表--------------------------->
 	  <table class="setting" border="0" cellspacing="0">
      	<thead><tr><th>登录基本信息</th><th></th><th></th></tr></thead>
        <tbody>
            <tr>
                <td width="20%">帐号名：</td>
                <td width="15%"><?php echo $user['username'];?></td>
                <td></td>
            </tr>
            <tr>
                <td>真实姓名：</td>
                <td><?php echo $user['realname'];?></td>
                <td></td>
            </tr>
            <tr>
                <td>IP地址：</td>
                <td><?php echo $ip;?></td>
                <td></td>
            </tr>
            <tr>
                <td>操作系统：</td>
                <td><?php echo $os;?></td>
                <td></td>
            </tr>
         	<tr>
                <td>浏览器信息：</td>
                <td><?php echo $browser;?></td>
                <td>
                	<span style="color:#F00">
					<?php if($browser=="Internet Explorer 6.0"){echo "警告：为了更加安全便捷的进行后台操作，请使用IE7.0及以上版本IE浏览器，或其它高版本浏览器！";}?>
                    </span>
                </td>
            </tr>
            <tr>
                <td>上次登录时间：</td>
                <td><?php echo $user['lasttime'];?></td>
                <td></td>
            </tr>
        </tbody>
      </table>
       <!------------------------列表结束--------------------------->
       </div>
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
