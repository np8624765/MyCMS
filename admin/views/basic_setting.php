<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>网站管理-基本设置</title>
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
      <td class="top_m"><div class="title"><span>基本设置</span></div></td>
      <td class="top_r"></td>
    </tr>
    <tr class="mid">
      <td class="mid_l"></td>
      <td class="mid_m">
      <div class="content">
      	  <div class="intro">
          	<p>当前位置：基本设置</p>
            <img src="views/images/basic_set.png" />
            <span>在这里，您可以根据您的网站需求，进行基本设置，打“<b style="color:#F00">*</b>”号表示必须填写的项目！<br /><br />列表项包括了网站名称，网站网址，管理员邮箱，管理员联系方式，网站滚动通知，关键词，网站描述，Session失效时间。</span>
            </div>
      <!------------------------列表--------------------------->
      <form id="myform" action="index.php?action=web_manage&method=base_post" method="post">
 	  <table class="setting" border="0" cellspacing="0">
      	<thead><tr><th>基本设置列表</th><th></th><th></th></tr></thead>
        <tbody>
            <tr>
                <td width="20%">网站名称：</td>
                <td width="30%"><input type="text" name="web_name" size="25" value="<?php echo $info[0][0];?>"/></td>
                <td><span class="must">*</span>网站的名称，首页title即为此名称</td>
            </tr>
            <tr>
                <td>网站地址：</td>
                <td><input type="text" name="web_address" size="30" value="<?php echo $info[1][0];?>"/></td>
                <td><span class="must">*</span>网站的访问地址，即您申请的域名</td>
            </tr>
            <tr>
                <td>网站关键词：</td>
                <td><input type="text" name="web_keyword" size="60"/ value="<?php echo $info[2][0];?>"></td>
                <td><span class="must">*</span>网站首页的关键字，便于被搜索引擎收录，多个关键字请用“，”分隔开</td>
            </tr>
            <tr>
                <td>网站描述：</td>
                <td><input type="text" name="web_description" size="60" value="<?php echo $info[3][0];?>"/></td>
                <td><span class="must">*</span>设置网站的描述，用一句话来描述你的网站，便于被搜索引擎收录</td>
            </tr>
            <tr>
                <td>网站滚动通知：</td>
                <td><input type="text" name="web_notice" size="60" value="<?php echo $info[4][0];?>"/></td>
                <td>如果你的首页中有滚动通知板块，请在此设置滚动通知的内容</td>
            </tr>
            <tr>
                <td>网站页脚信息：</td>
                <td><input type="text" name="web_footer" size="60" value="<?php echo $info[8][0];?>"/></td>
                <td>在网站的页脚中显示的版权等信息</td>
            </tr>
            <tr>
                <td>Session失效时间：</td>
                <td><input type="text" name="web_session" size="5" value="<?php echo $info[5][0];?>"/></td>
                <td>设置后台管理的失效时间，默认为120分钟，设置单位为分钟</td>
            </tr>
             <tr>
                <td>管理员联系电话：</td>
                <td><input type="text" name="web_phone" size="20" value="<?php echo $info[6][0];?>"/></td>
                <td>网站管理员的联系电话</td>
            </tr>
            <tr>
                <td>管理员邮箱：</td>
                <td><input type="text" name="web_email" size="20" value="<?php echo $info[7][0];?>"/></td>
                <td>网站管理员的邮箱地址</td>
            </tr>
            </tr>
        </tbody>
      </table>
      <div class="op"><input type="submit" name="sub" value="提交"/>&nbsp;<input type="reset" name="re" value="恢复"/></div>
      </form>
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
