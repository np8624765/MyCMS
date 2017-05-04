<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理中心-普通管理员</title>

<script src="views/js/prototype.lite.js" type="text/javascript"></script>
<script src="views/js/moo.fx.js" type="text/javascript"></script>
<script src="views/js/moo.fx.pack.js" type="text/javascript"></script>
<style>
body {
	font:12px Arial, Helvetica, sans-serif;
	color: #000;
	background-color: #EEF2FB;
	margin: 0px;
}
#container {
	width: 182px;
}
H1 {
	font-size: 12px;
	margin: 0px;
	width: 182px;
	cursor: pointer;
	height: 30px;
	line-height: 20px;	
}
H1 a {
	display: block;
	width: 182px;
	color: #000;
	height: 30px;
	text-decoration: none;
	moz-outline-style: none;
	background-image: url(views/images/menu_bgs.gif);
	background-repeat: no-repeat;
	line-height: 30px;
	text-align: center;
	margin: 0px;
	padding: 0px;
}
.content{
	width: 182px;
	height: 26px;
	
}
.MM ul {
	list-style-type: none;
	margin: 0px;
	padding: 0px;
	display: block;
}
.MM li {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	line-height: 26px;
	color: #333333;
	list-style-type: none;
	display: block;
	text-decoration: none;
	height: 26px;
	width: 182px;
	padding-left: 0px;
}
.MM {
	width: 182px;
	margin: 0px;
	padding: 0px;
	left: 0px;
	top: 0px;
	right: 0px;
	bottom: 0px;
	clip: rect(0px,0px,0px,0px);
}
.MM a:link {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	line-height: 26px;
	color: #333333;
	background-image: url(views/images/menu_bg1.gif);
	background-repeat: no-repeat;
	height: 26px;
	width: 182px;
	display: block;
	text-align: center;
	margin: 0px;
	padding: 0px;
	overflow: hidden;
	text-decoration: none;
}
.MM a:visited {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	line-height: 26px;
	color: #333333;
	background-image: url(views/images/menu_bg1.gif);
	background-repeat: no-repeat;
	display: block;
	text-align: center;
	margin: 0px;
	padding: 0px;
	height: 26px;
	width: 182px;
	text-decoration: none;
}
.MM a:active {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	line-height: 26px;
	color: #333333;
	background-image: url(views/images/menu_bg1.gif);
	background-repeat: no-repeat;
	height: 26px;
	width: 182px;
	display: block;
	text-align: center;
	margin: 0px;
	padding: 0px;
	overflow: hidden;
	text-decoration: none;
}
.MM a:hover {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	line-height: 26px;
	font-weight: bold;
	color: #006600;
	background-image: url(views/images/menu_bg2.gif);
	background-repeat: no-repeat;
	text-align: center;
	display: block;
	margin: 0px;
	padding: 0px;
	height: 26px;
	width: 182px;
	text-decoration: none;
}
</style>
</head>

<body>
<table width="100%" height="280" border="0" cellpadding="0" cellspacing="0" bgcolor="#EEF2FB">
  <tr>
    <td width="182" valign="top"><div id="container">
      
      <h1 class="type"><a href="javascript:void(0)">文章管理</a></h1>
       <div class="content">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><img src="views/images/menu_topline.gif" width="182" height="5" /></td>
          </tr>
        </table>
        <ul class="MM">
		  <li><a href="index.php?action=article_manage&method=add_article" target="main">添加文章</a></li>
		  <li><a href="index.php?action=article_manage&method=show_article" target="main">文章管理</a></li>
        </ul>
      </div>

	   <h1 class="type"><a href="javascript:void(0)">留言管理</a></h1>
      <div class="content">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><img src="views/images/menu_topline.gif" width="182" height="5" /></td>
            </tr>
          </table>
        <ul class="MM">
          <li><a href="index.php?action=message_manage&method=show_uncheck" target="main">未审核话题</a></li>
          <li><a href="index.php?action=message_manage&method=show_checked" target="main">已审核话题</a></li>
        </ul>
      </div>

       <h1 class="type"><a href="javascript:void(0)">个人安全</a></h1>
      	<div class="content">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><img src="views/images/menu_topline.gif" width="182" height="5" /></td>
            </tr>
          </table>
        <ul class="MM">
          <li><a href="index.php?action=person_safety&method=person_info" target="main">个人信息</a></li>
          <li><a href="index.php?action=person_safety&method=modify_pwd" target="main">修改密码</a></li>
        </ul>
      </div>
      
      <h1 class="type"><a href="javascript:void(0)">回收站</a></h1>
      <div class="content">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><img src="views/images/menu_topline.gif" width="182" height="5" /></td>
            </tr>
          </table>
        <ul class="MM">
          <li><a href="index.php?action=recycle_manage&method=article_recycle" target="main">文章回收站</a></li>
        </ul>
        <!-----------还需其他功能，请仿照以上模式，自己开发！------------------>
      </div>
      
     </div>
        <script type="text/javascript">
		var contents = document.getElementsByClassName('content');
		var toggles = document.getElementsByClassName('type');
	
		var myAccordion = new fx.Accordion(
			toggles, contents, {opacity: true, duration: 400}
		);
		myAccordion.showThisHideOpen(contents[0]);
	</script>
        </td>
  </tr>
</table>
</body>
</html>
