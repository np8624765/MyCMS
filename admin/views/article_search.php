<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>文章管理-文章搜索结果</title>
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
.intro1 a { color:#666; text-decoration:none;}
.intro1 a:hover { color:#900;}
.users { margin:0px auto; width:94%;}
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
		if(!confirm("是否要将该文章删除至回收站中?")){
			 return false;
		}
		var id = $.trim($(this).attr("value"));
		if(id!="") {
			$.post("index.php?action=article_manage&method=del_article",{aid:id},function(data){
				if($.trim(data)==1) {
					 window.location.reload();	
				}else{
					 $(".message").addClass("red");
			  		 $(".message").find("span").text("删除失败！");
				}
			});	
		}else {
			$(".message").addClass("red");
			$(".message").find("span").text("删除失败！");
		}
		 $(".message").slideDown().delay(3000).slideUp();
	});
	<?php if(isset($_SESSION['delart'])){?>
		$(".message").addClass("green");
		$(".message").find("span").text("删除成功！");
		$(".message").slideDown().delay(2000).slideUp();
	<?php unset($_SESSION['delart']);}?>
	
	$(".edit").click(function() {
		var id = $.trim($(this).attr("value"));
		window.location.href="index.php?action=article_manage&method=edit_article&aid="+id;
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
      <td class="top_m"><div class="title"><span>搜索结果</span></div></td>
      <td class="top_r"></td>
    </tr>
    <tr class="mid">
      <td class="mid_l"></td>
      <td class="mid_m">
      <!------------------------自定义--------------------------->
      <div class="content">
      	  <div class="intro1">
          	<p>当前位置：<a href="index.php?action=article_manage&method=show_article">文章管理</a>->搜索结果</p>
          </div>
           <?php if(empty($arts)){?>
            	<p class="back" style="margin:10px;">无搜索结果，<a href="index.php?action=article_manage&method=show_article">点击返回</a></p>
            <?php }else{ ?>
          <table class="users" border="0" cellspacing="0">
            <thead>
          	<tr>
            	<th>ID</th>
                <th style="width:25%">标题</th>
                <th >所属栏目</th>
                <th >文章类型</th>
                <th >作者</th>
                <th style="width:15%">发布时间</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($arts as $val){?>
            <tr>
            	<td><?php echo $val['aid'];?></td>
                <td><?php echo $val['atitle'];?></td>
                <td>
					<?php foreach($cols as $value){if($value['cid']==$val['abelong']){echo $value['cname'];break;}}?>
                </td>
                <td><?php if($val['atype']==0){echo "普通型";}elseif($val['atype']==1){echo "图文型";}elseif($val['atype']==2){echo "视频型";}else{echo "未知类型";}?></td>
                <td><?php echo $val['author'];?></td>
                <td><?php echo $val['atime'];?></td>
                <td>
                	<button class="edit" value="<?php echo $val['aid'];?>">编辑</button>
                    <button class="del" value="<?php echo $val['aid'];?>">删除</button>
                </td>
            </tr>
           	<?php }?>
            </tbody>
          </table>
          <?php }?>
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
