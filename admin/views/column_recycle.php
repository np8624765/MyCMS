<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>回收站-栏目回收站</title>
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
.intro1 { height:20px; border-bottom:1px solid #CCC; margin-bottom:20px; padding-left:10px; color:#666;}
.users { margin:0px auto;}
.users thead tr { background-color:#003366;}
.users thead th { padding:8px 30px; color:#FFF;}
.users tbody td { text-align:center; vertical-align:middle;}
.even { background-color:#CCCCCC;}

.op { width:100%; padding:5px 0px 0px 235px;}
.green { background:url(views/images/mess_green.png) left top;}
.red { background:url(views/images/mess_red.png) left top;}
</style>
<script type="text/javascript" src="views/js/jquery-1.6.4.js"></script>
<script type="text/javascript" src="views/js/jquery.form.js"></script>
<script language="javascript">
$(document).ready(function(){
    $('table.users tbody>tr:even').addClass("even");
	
	$(".del").click(function() {
		if(!confirm("是否要将该栏目彻底清除?")){
			 return false;
		}
		var id = $.trim($(this).attr("value"));
		if(id!="") {
			$.post("index.php?action=recycle_manage&method=delete_col",{cid:id},function(data){
				if($.trim(data)=="ok") {
					 window.location.reload();	
				}else{
					 $(".message").addClass("red");
			  		 $(".message").find("span").text("清除失败！");
				}
			});	
		}else {
			$(".message").addClass("red");
			$(".message").find("span").text("清除失败！");
		}
		 $(".message").slideDown().delay(2000).slideUp();
	});
	<?php if(isset($_SESSION['clearcol'])){?>
		$(".message").addClass("green");
		$(".message").find("span").text("清除成功！");
		$(".message").slideDown().delay(2000).slideUp();
	<?php unset($_SESSION['clearcol']);}?>
	
	$(".recover").click(function() {
		if(!confirm("是否要恢复该栏目?")){
			 return false;
		}
		var id = $.trim($(this).attr("value"));
		if(id!="") {
			$.post("index.php?action=recycle_manage&method=recover_col",{cid:id},function(data){
				if($.trim(data)=="ok") {
					 window.location.reload();	
				}else{
					 $(".message").addClass("red");
			  		 $(".message").find("span").text("恢复失败！父栏目不存在");
				}
			});	
		}else {
			$(".message").addClass("red");
			$(".message").find("span").text("恢复失败！");
		}
		 $(".message").slideDown().delay(2000).slideUp();
	});
	<?php if(isset($_SESSION['recovercol'])){?>
		$(".message").addClass("green");
		$(".message").find("span").text("恢复成功！");
		$(".message").slideDown().delay(2000).slideUp();
	<?php unset($_SESSION['recovercol']);}?>
	
});
</script>
</head>
<body>
<div class="box">
  <div class="message"><span></span></div>
  <table class="wrap" cellspacing="0">
    <tr class="top">
      <td class="top_l"></td>
      <td class="top_m"><div class="title"><span>栏目回收站</span></div></td>
      <td class="top_r"></td>
    </tr>
    <tr class="mid">
      <td class="mid_l"></td>
      <td class="mid_m">
      <!------------------------自定义--------------------------->
      <div class="content">
      	  <div class="intro1">
          	<p>当前位置：栏目回收站</p>
          </div>
          <table class="users" border="0" cellspacing="0">
            <thead>
          	<tr>
            	<th style="padding:5px 10px;">序号</th>
                <th>栏目名称</th>
                <th>栏目类型</th>
                <th>栏目内容形式</th>
                <th width="25%">创建时间</th>
                <th style="padding:5px 40px;">操作</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($cols as $val){?>
            <tr>
             <td><?php echo $val['cid'];?></td>
             <td><?php echo $val['cname'];?></td>
             <td><?php if($val['ctype']==0){echo "导航型";}else{echo "专题型";}?></td>
             <td><?php if($val['ccontent']==0){echo "列表型";}elseif($val['ccontent']==1){echo "介绍型";}else{echo "链接型";}?></td>
             <td><?php echo $val['ctime'];?></td>
             <td>
              	<button class="recover" value="<?php echo $val['cid'];?>">恢复</button>
                <button class="del" value="<?php echo $val['cid'];?>">彻底清除</button>
             </td>
            </tr>
           	<?php }?>
            </tbody>
          </table>
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
