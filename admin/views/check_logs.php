<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>系统安全-查看日志</title>
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
.intro1 { height:20px; border-bottom:1px solid #CCC; margin-bottom:30px; padding-left:10px; color:#666;}
.logs { margin:0px auto; width:90%}
.logs thead tr { background-color:#003366;}
.logs thead th { padding:8px 30px; color:#FFF;}
.logs tbody td { text-align:center; vertical-align:middle; padding:5px 5px;}
.even { background-color:#CCCCCC;}
.op { width:100%; padding:5px 0px 0px 235px;}
.green { background:url(views/images/mess_green.png) left top;}
.red { background:url(views/images/mess_red.png) left top;}
.pagelist { float:right; color:#06C;  font-weight:bold; padding-right:50px;}
.pagelist a { padding:2px 5px; text-decoration:none; color:#06C; border:1px solid #036; font-weight:bold;}
.pagelist a:hover { text-decoration:underline; cursor:pointer;}
.choice { float:left; margin:0px 0px 5px 43px;}
</style>
<script type="text/javascript" src="views/js/jquery-1.6.4.js"></script>
<script type="text/javascript" src="views/js/jquery.form.js"></script>
<script language="javascript">
$(document).ready(function(){
    $('table.logs tbody>tr:even').addClass("even");
	
	//选择框
	$("#choice").change(function() {
		var id = $.trim($("#choice").val());
		window.location.href="index.php?action=system_safety&method=show_logs&time="+id;
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
      <td class="top_m"><div class="title"><span>查看日志</span></div></td>
      <td class="top_r"></td>
    </tr>
    <tr class="mid">
      <td class="mid_l"></td>
      <td class="mid_m">
      <!------------------------自定义--------------------------->
      <div class="content">
      	  <div class="intro1">
          	<p>当前位置：查看日志</p>
             <div class="choice">
              <select name="choice" id="choice">
              	 <option value="4" <?php if($time=='4'){echo "selected='selected'";}?>>全部</option>
                 <option value="3" <?php if($time=='3'){echo "selected='selected'";}?>>最近一天</option>
                 <option value="2" <?php if($time=='2'){echo "selected='selected'";}?>>最近一周</option>
                 <option value="1" <?php if($time=='1'){echo "selected='selected'";}?>>最近一月</option>
                 <option value="0" <?php if($time=='0'){echo "selected='selected'";}?>>最近一年</option>
              </select>
              </div>
          </div>
          <table class="logs" border="0" cellspacing="0">
            <thead>
          	<tr>
            	<th style="padding:5px 10px;">RID</th>
                <th>UID</th>
                <th>用户名</th>
                <th>操作者权限</th>
                <th style="padding:5px 80px;">操作事件</th>
                <th style="padding:5px 30px;">IP地址</th>
                <th style="padding:5px 50px;">操作时间</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($logs as $val){?>
            <tr>
            	<td><?php echo $val['rid'];?></td>
                <td><?php if($val['uid']==0){echo "未知uid";}else{echo $val['uid'];};?></td>
                <td><?php if($val['uid']==0){echo "未知用户名";}else{echo $val['username'];};?></td>
                <td>
					<?php if($val['permission']==0)
						{ echo "超级管理员";}elseif($val['permission']==1){echo "高级管理员";}elseif($val['permission']==2){echo "普通管理员";}else{echo "未知权限";}
					?>
                </td>
                <td><?php echo $val['event'];?></td>
                <td><?php echo $val['ip'];?></td>
                <td><?php echo $val['rtime'];?></td>
            </tr>
           <?php }?>
            </tbody>
          </table>
          <p class="pagelist">
          <span style="color:#003;">日志总条数：<?php echo $sum;?>&nbsp;条</span>&nbsp;&nbsp;
          <?php if($page!=1){?>
          <a href="index.php?action=system_safety&method=show_logs&time=<?php echo $time;?>&page=<?php echo $page-1;?>">≤</a>
          <?php }?>
          <?php for($i=$front;$i<$page;$i++){?>
          <a href="index.php?action=system_safety&method=show_logs&time=<?php echo $time;?>&page=<?php echo $i;?>"><?php echo $i;?></a>
          <?php }?>
          <a style="border:none;color:#333;" href="index.php?action=system_safety&method=show_logs&time=<?php echo $time;?>&page=<?php echo $page;?>"><?php echo $page;?></a>
          <?php for($i=$page+1;$i<=$back;$i++){?>
          <a href="index.php?action=system_safety&method=show_logs&time=<?php echo $time;?>&page=<?php echo $i;?>"><?php echo $i;?></a>
          <?php }?>
          <?php if($page!=$per){?>
          <a href="index.php?action=system_safety&method=show_logs&time=<?php echo $time;?>&page=<?php echo $page+1;?>">≥</a>
          <?php }?>
          <span style="color:#003;">总共<?php echo $per;?>页</span>
         </p>
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
