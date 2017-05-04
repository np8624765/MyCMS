<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>网站管理-链接管理</title>
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
table .links { width:96%; margin:0px auto; border-top:1px solid #999;}
table .links .must { color:#F00; display:inline; padding-right:5px;}
table .links tr { height:30px; text-align:center; background-color:#ecfbd4;}
table .links thead tr { background-color:#3589a5; color:#FFF;}
table .links thead th { text-align:left; padding-left:10px; }
table .links .group { background-color:#e6f1f5;}
table .links .group td { border-bottom:1px solid #999;}
.even { }
.five { text-align:center;}
.hand { cursor:pointer; cursor:hand;}
.op { width:100%; padding:5px 0px 0px 235px;}
.green { background:url(views/images/mess_green.png) left top;}
.red { background:url(views/images/mess_red.png) left top;}
</style>
<script type="text/javascript" src="views/js/jquery-1.6.4.js"></script>
<script type="text/javascript" src="views/js/jquery.form.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('table.links tbody>tr').find('td:eq(4)').addClass("five")
	$(".group").parent("tbody").find("tr:not([class])").hide();
	$(".group").find("td:first").addClass("hand");
	
	//伸缩组
	$(".group").find("td:first").toggle(function(){
	  	$(this).parent("tr").parent("tbody").find("tr:not([class])").show();
	},function(){
		$(this).parent("tr").parent("tbody").find("tr:not([class])").hide();
	});
	
	//修改组名
	$("button.modify_name").click(function(){
		var id = $(this).attr("value");
		var td = $(this).parents("td").parent("tr.group").find("td:first");
		var old = td.html();
		td.html("<input type='text' id='"+id+"' size='15' name='group' value='"+old+"' />");
		$("input#"+id).focus();
		$("input#"+id).blur(function(){
			var newval = $.trim($(this).val());
			if(newval=="")
			{
				td.html(old);
				$(".message").removeClass("green");
				$(".message").addClass("red");
			    $(".message").find("span").text("修改失败！组名不能为空");
			}else if(newval==old){
				td.html(old);
				$(".message").removeClass("red");
				$(".message").addClass("green");
			    $(".message").find("span").text("修改组名成功！");
			}else{
				$.post("index.php?action=web_manage&method=modify_group",{gid:id,newname:newval},function(data){
					if($.trim(data)=="ok") {
						td.html(newval);
						$(".message").removeClass("red");
						$(".message").addClass("green");
			    		$(".message").find("span").text("修改组名成功！");
					}else if($.trim(data)=="exist"){
						td.html(old);
						$(".message").removeClass("green");
						$(".message").addClass("red");
			    		$(".message").find("span").text("修改失败！组名已存在");
					}else{
						td.html(old);
						$(".message").removeClass("green");
						$(".message").addClass("red");
			    		$(".message").find("span").text("修改失败！");
					}
				});
			}
			$(".message").slideDown().delay(3000).slideUp();
		});
	});
	
	//添加新链接组
	$("button#add_group").click(function() {
		window.location.href="index.php?action=web_manage&method=add_group";
	});
	
	//添加链接
	$("button.add_link").click(function() {
		var gid = $(this).attr("value");
		window.location.href="index.php?action=web_manage&method=add_link&gid="+gid;
	});
	
	//编辑链接
	$("button.edit").click(function() {
		var lid = $(this).parent("td").parent("tr").attr("value");
		window.location.href="index.php?action=web_manage&method=edit_link&lid="+lid;
	});
	
	//删除链接
	$("button.del_link").click(function() {
		if(!confirm("是否要删除该链接?")){
			 return false;
		}
		var id = $(this).parent("td").parent("tr").attr("value");
		$.post("index.php?action=web_manage&method=del_link",{'lid':id},function(data){
			if($.trim(data)=="ok")
			{
				window.location.reload();
			}
			else
			{
			  $(".message").removeClass("green");
			  $(".message").addClass("red");
			  $(".message").find("span").text("删除失败");
			}
			$(".message").slideDown().delay(3000).slideUp();
		});
	});
	<?php if(isset($_SESSION['dellink'])){?>
		$(".message").addClass("green");
		$(".message").find("span").text("删除成功！");
		$(".message").slideDown().delay(3000).slideUp();
	<?php unset($_SESSION['dellink']);}?>
	
	//删除链接组
	$("button.del_group").click(function() {
		if(!confirm("是否要删除该链接组?")){
			 return false;
		}
		var id = $(this).attr("value");
		$.post("index.php?action=web_manage&method=del_group",{'gid':id},function(data){
			if($.trim(data)=="ok")
			{
				window.location.reload();
			}
			else
			{
			  $(".message").removeClass("green");
			  $(".message").addClass("red");
			  $(".message").find("span").text("删除组失败！还有子链接");
			}
			$(".message").slideDown().delay(3000).slideUp();
		});
	});
	<?php if(isset($_SESSION['delgroup'])){?>
		$(".message").addClass("green");
		$(".message").find("span").text("删除组成功！");
		$(".message").slideDown().delay(3000).slideUp();
	<?php unset($_SESSION['delgroup']);}?>
	
	<?php if(isset($_SESSION['addlink'])){?>
		$(".message").addClass("green");
		$(".message").find("span").text("添加链接成功！");
		$(".message").slideDown().delay(3000).slideUp();
	<?php unset($_SESSION['addlink']);}?>
	
	<?php if(isset($_SESSION['addgroup'])){?>
		$(".message").addClass("green");
		$(".message").find("span").text("添加链接组成功！");
		$(".message").slideDown().delay(3000).slideUp();
	<?php unset($_SESSION['addgroup']);}?>
	
	<?php if(isset($_SESSION['editlink'])){?>
		$(".message").addClass("green");
		$(".message").find("span").text("修改链接成功！");
		$(".message").slideDown().delay(3000).slideUp();
	<?php unset($_SESSION['editlink']);}?>
	
});
</script>
</head>

<body>
<div class="box">
  <div class="message"><span></span></div>
  <table class="wrap" cellspacing="0">
    <tr class="top">
      <td class="top_l"></td>
      <td class="top_m"><div class="title"><span>链接管理</span></div></td>
      <td class="top_r"></td>
    </tr>
    <tr class="mid">
      <td class="mid_l"></td>
      <td class="mid_m">
      <!------------------------自定义--------------------------->
      <div class="content">
      	  <div class="intro">
          	<p>当前位置：链接管理</p>
            <img src="views/images/links.png" />
            <span>在这里，您可以对网站的链接分组管理！<br /><br />一个链接组中可以包含多个链接，你可以添加链接组或删除没有子链接的链接组，组名括号内的数字表示组内子链接数量。</span>
          </div>
         
 	  	<table class="links" border="0" cellspacing="0">
      	<thead><tr class="titletr"><th colspan="2">链接组列表(点击组名打开子链接列表)</th><th></th><th></th><th style="text-align:right;"><button id="add_group">新增链接组</button></th></tr></thead>
        <?php foreach($group as $val){?>
        <tbody>
            <tr class="group">
                <td width="15%"><?php echo $val['gname'];?></td>
                <td width="10%">GID:<?php echo $val['gid'];?></td>
                <td width="25%">子链接数量:<?php echo $val['gnum'];?></td>
                <td width="20%">&nbsp;</td>
                <td><button class="add_link" value="<?php echo $val['gid'];?>">添加链接</button><button class="modify_name" value="<?php echo $val['gid'];?>">修改名称</button><button class="del_group" value="<?php echo $val['gid'];?>">删除组</button></td>
            </tr>
            <?php if(!empty($links[$val['gid']])){foreach($links[$val['gid']] as $value){?>
            <tr value="<?php echo $value['lid'];?>">
                <td>LID:<?php echo $value['lid'];?></td>
                <td><?php echo $value['lname'];?></td>
                <td><?php if($value['limage']){ echo "图片链接";}else{ echo "文字链接";}?></td>
                <td><?php echo $value['ldir'];?></td>
                <td><button class="edit" value="<?php echo $value['lid'];?>">编辑</button><button class="del_link" value="<?php echo $value['lid'];?>">删除</button></td>
            </tr>
            <?php }?>
        </tbody>
        <?php }}?>
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
