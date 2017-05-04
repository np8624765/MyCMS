<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>栏目管理-栏目管理</title>
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
table .links thead tr { background-color:#3589a5; color:#FFF; }
table .links thead th { text-align:left; padding-left:10px; }
table .links .group { background-color:#e6f1f5;}
table .links .group td { border-bottom:1px solid #999;}
#son {color: #730000;}
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
	
	//编辑栏目
	$("button.edit").click(function() {
		var cid = $(this).parent("td").parent("tr").attr("value");
		window.location.href="index.php?action=column_manage&method=edit_column&cid="+cid;
	});
	
	//删除栏目
	$("button.del").click(function() {
		if(!confirm("是否要删除该栏目?")){
			 return false;
		}
		var id = $(this).attr("value");
		$.post("index.php?action=column_manage&method=del_column",{'cid':id},function(data){
			if($.trim(data)=="ok")
			{
				window.location.reload();
			}
			else if($.trim(data)=="col")
			{
			  $(".message").removeClass("green");
			  $(".message").addClass("red");
			  $(".message").find("span").text("删除失败！还有二级栏目");
			}
			else if($.trim(data)=="art")
			{
			  $(".message").removeClass("green");
			  $(".message").addClass("red");
			  $(".message").find("span").text("删除失败！栏目中还有文章");
			}
			else
			{
			  $(".message").removeClass("green");
			  $(".message").addClass("red");
			  $(".message").find("span").text("删除失败！");
			}
			$(".message").slideDown().delay(3000).slideUp();
		});
	});
	<?php if(isset($_SESSION['delcolumn'])){?>
		$(".message").addClass("green");
		$(".message").find("span").text("删除栏目成功！");
		$(".message").slideDown().delay(3000).slideUp();
	<?php unset($_SESSION['delcolumn']);}?>
	
	<?php if(isset($_SESSION['addcolumn'])){?>
		$(".message").addClass("green");
		$(".message").find("span").text("添加栏目成功！");
		$(".message").slideDown().delay(3000).slideUp();
	<?php unset($_SESSION['addcolumn']);}?>
	
	<?php if(isset($_SESSION['editcolumn'])){?>
		$(".message").addClass("green");
		$(".message").find("span").text("修改栏目成功！");
		$(".message").slideDown().delay(3000).slideUp();
	<?php unset($_SESSION['editcolumn']);}?>
});
</script>
</head>

<body>
<div class="box">
  <div class="message"><span></span></div>
  <table class="wrap" cellspacing="0">
    <tr class="top">
      <td class="top_l"></td>
      <td class="top_m"><div class="title"><span>栏目管理</span></div></td>
      <td class="top_r"></td>
    </tr>
    <tr class="mid">
      <td class="mid_l"></td>
      <td class="mid_m">
      <!------------------------自定义--------------------------->
      <div class="content">
      	  <div class="intro">
          	<p>当前位置：栏目管理</p>
            <img src="views/images/column_manage.png" />
            <span>在这里，您可以对网站的所有栏目进行管理！<br /><br />一个主栏目中可以包含多个二级栏目，注意只有当栏目中没有二级栏目和文章时才能被删除。主栏目下没有子栏目时才能重新设置为二级栏目。</span>
          </div>
         
 	  	<table class="links" border="0" cellspacing="0">
      	<thead><tr class="titletr"><th colspan="3">全站栏目列表(点击主栏目名打开二级栏目列表)</th><th></th><th></th><th style="text-align:right;"></th></tr></thead>
      <?php foreach($main as $value){?>
        <tbody>
            <tr class="group" value="<?php echo $value['cid'];?>">
                <td width="15%"><?php echo $value['cname'];?></td>
                <td>CID:<?php echo $value['cid'];?></td>
                <td width="25%">下属二级栏目数量:<?php echo $value['csons'];?></td>
                <td width="15%">栏目类型：<?php if($value['ctype']==0){echo "导航型";}else{echo "专题型";}?></td>
                <td width="15%">内容形式：<?php if($value['ccontent']==0){echo "列表型";}elseif($value['ccontent']==1){echo "介绍型";}else{echo "链接型";}?></td>
                <td><button class="edit" value="<?php echo $value['cid'];?>">编辑主栏目</button><button class="del" value="<?php echo $value['cid'];?>">删除主栏目</button></td>
            </tr>
            <?php if(!empty($sons[$value['cid']])){foreach($sons[$value['cid']] as $val){?>
            <tr id="son" value="<?php echo $val['cid'];?>">
                <td><?php echo $val['cname'];?></td>
                <td>CID:<?php echo $val['cid'];?></td>
                <td>文章数量：<?php echo $val['cnum'];?></td>
                <td>栏目类型：<?php if($val['ctype']==0){echo "导航型";}else{echo "专题型";}?></td>
                <td>内容形式：<?php if($val['ccontent']==0){echo "列表型";}elseif($val['ccontent']==1){echo "介绍型";}else{echo "链接型";}?></td>
                <td><button class="edit" value="<?php echo $val['cid'];?>">编辑二级栏目</button><button class="del" value="<?php echo $val['cid'];?>">删除二级栏目</button></td>
            </tr>
            <?php }?>
        </tbody>   
     <?php } }?>
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
