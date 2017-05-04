<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>文章管理-文章管理</title>
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
.users { margin:0px auto; width:94%;}
.users thead tr { background-color:#003366;}
.users thead th { padding:8px 30px; color:#FFF;}
.users tbody td { text-align:center; vertical-align:middle; padding:3px 0px;}
.users input { vertical-align:middle;}
.even { background-color:#CCCCCC;}
.op { width:100%; padding:5px 0px 0px 235px;}
.green { background:url(views/images/mess_green.png) left top;}
.red { background:url(views/images/mess_red.png) left top;}
.pagelist { float:right; color:#06C;  font-weight:bold; padding: 3px 30px 0px 0px;}
.pagelist a { padding:2px 5px; text-decoration:none; color:#06C; border:1px solid #036; font-weight:bold;}
.pagelist a:hover { text-decoration:underline; cursor:pointer;}
.choice { float:left; margin:0px 0px 5px 22px;}
.search { float:right; margin-right:30px;}
.check { float:left; margin-left:40px;}
</style>
<script type="text/javascript" src="views/js/jquery-1.6.4.js"></script>
<script type="text/javascript" src="views/js/jquery.form.js"></script>
<script language="javascript">
$(document).ready(function(){
    $('table.users tbody>tr:even').addClass("even");
	
	//单一删除
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
	
	//批量删除
	$(".lotdel").click(function() {
		if(!confirm("是否要将选中的文章批量删除至回收站中?")){
			 return false;
		}
		var arr = new Array();
		$('[name="checkbox"]:checkbox:checked').each(function(){
			arr.push($(this).val());
		});
		if(arr.length==0){
			alert("未选中文章！");
			 return false;
		}else{
			//将数组对象传递给服务器处理
			$.post("index.php?action=article_manage&method=lotdel_article",{arr:arr},function(data){
				if($.trim(data)==arr.length) {
					 window.location.reload();	
				}else{
					 $(".message").addClass("red");
			  		 $(".message").find("span").text("删除失败！");
				}
			});	
			$(".message").slideDown().delay(3000).slideUp();
		}
	});
	
	<?php if(isset($_SESSION['delart'])){?>
		$(".message").addClass("green");
		$(".message").find("span").text("删除成功！");
		$(".message").slideDown().delay(3000).slideUp();
	<?php unset($_SESSION['delart']);}?>
	
	<?php if(isset($_SESSION['lotdel'])){?>
		$(".message").addClass("green");
		$(".message").find("span").text("批量删除成功！");
		$(".message").slideDown().delay(3000).slideUp();
	<?php unset($_SESSION['lotdel']);}?>
	
	<?php if(isset($_SESSION['addart'])){?>
		$(".message").addClass("green");
		$(".message").find("span").text("添加成功！");
		$(".message").slideDown().delay(3000).slideUp();
	<?php unset($_SESSION['addart']);}?>
	
	<?php if(isset($_SESSION['editart'])){?>
		$(".message").addClass("green");
		$(".message").find("span").text("修改成功！");
		$(".message").slideDown().delay(3000).slideUp();
	<?php unset($_SESSION['editart']);}?>
	
	//全选，全不选，反选
	$(".checkAll").click(function() {
		$('[name="checkbox"]:checkbox').attr("checked",true);
	});
	$(".checkNo").click(function() {
		$('[name="checkbox"]:checkbox').attr("checked",false);
	});
	$(".checkRev").click(function() {
		$('[name="checkbox"]:checkbox').each(function(){
				this.checked = !this.checked;
			});
	});
	
	//编辑
	$(".edit").click(function() {
		var id = $.trim($(this).attr("value"));
		window.location.href="index.php?action=article_manage&method=edit_article&aid="+id;
	});
	
	//选择框
	$("#choice").change(function() {
		var id = $.trim($("#choice").val());
		window.location.href="index.php?action=article_manage&method=show_article&cid="+id;
	});
	
	//判断搜索栏是否为空
	$("#sea").click(function() {
		$val = $.trim($("#sea_key").val());
		if($val==""){
			alert("搜索的内容不能为空！");
			return false;
		}
		$("#search").submit();
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
      <td class="top_m"><div class="title"><span>文章管理</span></div></td>
      <td class="top_r"></td>
    </tr>
    <tr class="mid">
      <td class="mid_l"></td>
      <td class="mid_m">
      <!------------------------自定义--------------------------->
      <div class="content">
      	  <div class="intro1">
          	<p>当前位置：文章管理
              <div class="choice">
              <select name="choice" id="choice">
              	   <option value="0" <?php if($cid==0){echo "selected='selected'";}?>>全部</option>
                   <?php foreach($main as $value){?>
                   <option value="<?php echo $value['cid']?>" <?php if($cid==$value['cid']){echo "selected='selected'";}?>><?php echo $value['cname']?>---</option>
                   <?php if(!empty($sons[$value['cid']])){foreach($sons[$value['cid']] as $val){?>
                   <option value="<?php echo $val['cid']?>" <?php if($cid==$val['cid']){echo "selected='selected'";}?> style="color:#036;">&nbsp;&nbsp;&nbsp;&nbsp;→<?php echo $val['cname']?></option>
                   <?php }} ?>
                   <?php } ?>
              </select>
              </div>
              <div class="search">
              <form name="search" id="search" action="index.php?action=article_manage&method=search" method="post">
            	<input type="text" name="sea_key" id="sea_key" placeholder="请输入标题关键字"/>
                <input type="button" name="sea" id="sea" value="搜索"/>
              </form>
              </div>
            </p>
          </div>
          <table class="users" border="0" cellspacing="0">
            <thead>
          	<tr>
            	<th>序号</th>
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
            	<td><input type="checkbox" name="checkbox" value="<?php echo $val['aid'];?>"/><?php echo $val['aid'];?></td>
                <td><?php echo $val['atitle'];?></td>
                <td>
					<?php foreach($cols as $value){if($value['cid']==$val['abelong']){echo $value['cname'];break;}}?>
                </td>
                <td><?php if($val['atype']==0){echo "普通型";}elseif($val['atype']==1){echo "图文型";}elseif($val['atype']==2){echo "视频型";}elseif($val['atype']==3){echo "下载型";}elseif($val['atype']==4){echo "链接型";}else{echo "未知类型";}?></td>
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
          <p class="check">
          	<button class="checkAll">全选</button>
            <button class="checkNo">全不选</button>
            <button class="checkRev">反选</button>
            <button class="lotdel">批量删除</button>
          </p>
         <p class="pagelist">
         <span style="color:#003;">文章总数：<?php echo $sum;?>&nbsp;篇</span>&nbsp;&nbsp;
          <?php if($page!=1){?>
         <a href="index.php?action=article_manage&method=show_article&cid=<?php echo $cid;?>&page=<?php echo $page-1;?>">≤</a>
          <?php }?>
          <?php for($i=$front;$i<$page;$i++){?>
   <a href="index.php?action=article_manage&method=show_article&cid=<?php echo $cid;?>&page=<?php echo $i;?>"><?php echo $i;?></a>
          <?php }?>
          <a style="border:none;color:#333;" href="index.php?action=article_manage&method=show_article&cid=<?php echo $cid;?>&page=<?php echo $page;?>"><?php echo $page;?></a>
          <?php for($i=$page+1;$i<=$back;$i++){?>
          <a href="index.php?action=article_manage&method=show_article&cid=<?php echo $cid;?>&page=<?php echo $i;?>"><?php echo $i;?></a>
          <?php }?>
          <?php if($page!=$per){?>
          <a href="index.php?action=article_manage&method=show_article&cid=<?php echo $cid;?>&page=<?php echo $page+1;?>">≥</a>
          <?php }?>
          &nbsp;&nbsp;<span style="color:#003;">总共<?php echo $per;?>页</span>
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
