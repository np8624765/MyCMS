<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>用户管理-用户管理</title>
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
.users { margin:0px auto; width:90%}
.users thead tr { background-color:#003366;}
.users thead th { padding:8px 30px; color:#FFF;}
.users tbody td { text-align:center; vertical-align:middle; padding:2px 0px;}
.users input { vertical-align:middle;}
.even { background-color:#CCCCCC;}
.op { width:100%; padding:5px 0px 0px 235px;}
.green { background:url(views/images/mess_green.png) left top;}
.red { background:url(views/images/mess_red.png) left top;}
.pagelist { float:right; color:#06C;  font-weight:bold; padding:5px 50px 0px 0px;}
.pagelist a { padding:2px 5px; text-decoration:none; color:#06C; border:1px solid #036; font-weight:bold;}
.pagelist a:hover { text-decoration:underline; cursor:pointer;}
.choice { float:left; margin:0px 0px 5px 43px;}
.check { float:left; margin-left:60px;}
</style>
<script type="text/javascript" src="views/js/jquery-1.6.4.js"></script>
<script type="text/javascript" src="views/js/jquery.form.js"></script>
<script language="javascript">
$(document).ready(function(){
    $('table.users tbody>tr:even').addClass("even");
	
	//单一删除
	$(".del").click(function() {
		if(!confirm("是否要将该用户删除至回收站中?")){
			 return false;
		}
		var id = $.trim($(this).attr("value"));
		if(id!="") {
			$.post("index.php?action=users_manage&method=del_user",{uid:id},function(data){
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
		if(!confirm("是否要将选中的用户批量删除至回收站中?")){
			 return false;
		}
		var arr = new Array();
		$('[name="checkbox"]:checkbox:checked').each(function(){
			arr.push($(this).val());
		});
		if(arr.length==0){
			alert("未选中用户！");
			 return false;
		}else{
			//将数组对象传递给服务器处理
			$.post("index.php?action=users_manage&method=lotdel_user",{arr:arr},function(data){
				if($.trim(data)==arr.length) {
					 window.location.reload();	
				}else{
					 $(".message").addClass("red");
			  		 $(".message").find("span").text("批量删除失败！");
				}
			});	
			$(".message").slideDown().delay(3000).slideUp();
		}
	});
	
	<?php if(isset($_SESSION['deluser'])){?>
		$(".message").addClass("green");
		$(".message").find("span").text("删除成功！");
		$(".message").slideDown().delay(3000).slideUp();
	<?php unset($_SESSION['deluser']);}?>
	
	<?php if(isset($_SESSION['lotdeluser'])){?>
		$(".message").addClass("green");
		$(".message").find("span").text("批量删除成功！");
		$(".message").slideDown().delay(3000).slideUp();
	<?php unset($_SESSION['lotdeluser']);}?>
	
	<?php if(isset($_SESSION['adduser'])){?>
		$(".message").addClass("green");
		$(".message").find("span").text("添加成功！");
		$(".message").slideDown().delay(3000).slideUp();
	<?php unset($_SESSION['adduser']);}?>
	
	<?php if(isset($_SESSION['edituser'])){?>
		$(".message").addClass("green");
		$(".message").find("span").text("修改成功！");
		$(".message").slideDown().delay(3000).slideUp();
	<?php unset($_SESSION['edituser']);}?>
	
	<?php if(isset($_SESSION['editpwd'])){?>
		$(".message").addClass("green");
		$(".message").find("span").text("修改密码成功！");
		$(".message").slideDown().delay(3000).slideUp();
	<?php unset($_SESSION['editpwd']);}?>
	
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
	
	//编辑用户
	$(".edit").click(function() {
		var id = $.trim($(this).attr("value"));
		window.location.href="index.php?action=users_manage&method=edit_user&uid="+id;
	});
	
	//更改密码
	$(".pwd").click(function() {
		var id = $.trim($(this).attr("value"));
		window.location.href="index.php?action=users_manage&method=mod_pwd&uid="+id;
	});
	
	//选择框
	$("#choice").change(function() {
		var id = $.trim($("#choice").val());
		window.location.href="index.php?action=users_manage&method=show_users&per="+id;
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
      <td class="top_m"><div class="title"><span>用户管理</span></div></td>
      <td class="top_r"></td>
    </tr>
    <tr class="mid">
      <td class="mid_l"></td>
      <td class="mid_m">
      <!------------------------自定义--------------------------->
      <div class="content">
      	  <div class="intro1">
          	<p>当前位置：用户管理</p>
             <div class="choice">
              <select name="choice" id="choice">
              	 <option value="4" <?php if($permi=='4'){echo "selected='selected'";}?>>全部</option>
                 <option value="3" <?php if($permi=='3'){echo "selected='selected'";}?>>普通用户</option>
                 <option value="2" <?php if($permi=='2'){echo "selected='selected'";}?>>普通管理员</option>
                 <option value="1" <?php if($permi=='1'){echo "selected='selected'";}?>>高级管理员</option>
                 <option value="0" <?php if($permi=='0'){echo "selected='selected'";}?>>超级管理员</option>
              </select>
              </div>
          </div>
          <table class="users" border="0" cellspacing="0">
            <thead>
          	<tr>
            	<th style="padding:5px 10px;">UID</th>
                <th>用户名</th>
                <th>权限</th>
                <th>工号</th>
                <th>真实姓名</th>
                <th>手机号码</th>
                <th style="padding:5px 50px;">上次登录时间</th>
                <th style="padding:5px 40px;">操作</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($users as $val){?>
            <tr>
            	<td><input type="checkbox" name="checkbox" value="<?php echo $val['uid'];?>"/><?php echo $val['uid'];?></td>
                <td><?php echo $val['username'];?></td>
                <td>
					<?php if($val['permission']==0)
						{ echo "超级管理员";}elseif($val['permission']==1){echo "高级管理员";}elseif($val['permission']==2){echo "普通管理员";}else{echo "普通用户";}
					?>
                </td>
                <td><?php echo $val['wid'];?></td>
                <td><?php echo $val['realname'];?></td>
                <td><?php echo $val['uphone'];?></td>
                <td><?php echo $val['lasttime'];?></td>
                <td>
                	<button class="pwd" value="<?php echo $val['uid'];?>">修改密码</button>
                	<button class="edit" value="<?php echo $val['uid'];?>">编辑</button>
                    <button class="del" value="<?php echo $val['uid'];?>">删除</button>
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
          <span style="color:#003;">用户总数：<?php echo $sum;?>&nbsp;位</span>&nbsp;&nbsp;
          <?php if($page!=1){?>
          <a href="index.php?action=users_manage&method=show_users&per=<?php echo $permi;?>&page=<?php echo $page-1;?>">≤</a>
          <?php }?>
          <?php for($i=$front;$i<$page;$i++){?>
          <a href="index.php?action=users_manage&method=show_users&per=<?php echo $permi;?>&page=<?php echo $i;?>"><?php echo $i;?></a>
          <?php }?>
          <a style="border:none;color:#333;" href="index.php?action=users_manage&method=show_users&per=<?php echo $permi;?>&page=<?php echo $page;?>"><?php echo $page;?></a>
          <?php for($i=$page+1;$i<=$back;$i++){?>
          <a href="index.php?action=users_manage&method=show_users&per=<?php echo $permi;?>&page=<?php echo $i;?>"><?php echo $i;?></a>
          <?php }?>
          <?php if($page!=$per){?>
          <a href="index.php?action=users_manage&method=show_users&per=<?php echo $permi;?>&page=<?php echo $page+1;?>">≥</a>
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
