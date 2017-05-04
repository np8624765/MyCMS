<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>网站设置-链接管理-添加链接</title>
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
.intro a { color:#666; text-decoration:none;}
.intro a:hover { color:#900;}
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
<script type="text/javascript">
$(document).ready(function(){
    $('table.setting tbody>tr:even').addClass("even");
	$('table.setting tbody>tr').find('td:eq(0)').addClass("one");
	$('table.setting tbody>tr').find('td:eq(2)').addClass("three");
	
	var options = {        
   					beforeSubmit: showRequest,  
   					success: showResponse,      
   					timeout: 3000               
	}  
  
	function showRequest(formData, jqForm, options){   
		var form = jqForm[0];
		var isok = true;
		var info = "添加失败! ";
		var name = $.trim(form.link_name.value);
		var dir = $.trim(form.link_dir.value);
		

		if((name=="")||(dir=="")) {
			isok = false;
			info += "必填项不能为空 ";	
		}
		if(!isok)
		{
			alert(info);
			return false; 
		}
		return true;
	};  
  
	function showResponse(responseText, statusText){  
   		  if($.trim(responseText)=="ok") {
			  window.location.href="index.php?action=web_manage&method=links_manage";
		  }else if($.trim(responseText)=="error"){
			  $(".message").removeClass("green");
			  $(".message").addClass("red");
			  $(".message").find("span").text("添加失败！图片上传错误");
		  }else{
			  $(".message").removeClass("green");
			  $(".message").addClass("red");
			  $(".message").find("span").text("添加失败");
		  }
		  $(".message").slideDown().delay(3000).slideUp();
	};  
	
	$('#myform').submit(function() {  
  		 $(this).ajaxSubmit(options);  
   		 return false; 
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
      <td class="top_m"><div class="title"><span>添加链接</span></div></td>
      <td class="top_r"></td>
    </tr>
    <tr class="mid">
      <td class="mid_l"></td>
      <td class="mid_m">
      <!------------------------自定义--------------------------->
      <div class="content">
      	  <div class="intro">
          	<p>当前位置：<a href="index.php?action=web_manage&method=links_manage">链接管理</a>->添加链接</p>
            <img src="views/images/add_link.png" />
            <span>在这里，您可以为你的链接组添加子链接！<br /><br />子链接分为文字链接和图片链接，图片链接需要上传相应的图片。</span>
          </div>
          <form id="myform" action="index.php?action=web_manage&method=addLink&gid=<?php echo $gid;?>" method="post" enctype="multipart/form-data">
 	  	<table class="setting" border="0" cellspacing="0">
      	<thead><tr><th>新链接列表</th><th></th><th></th></tr></thead>
        <tbody>
            <tr>
                <td width="20%">链接名称：</td>
                <td width="25%"><input type="text" name="link_name" size="30" /></td>
                <td><span class="must">*</span>请输入链接的名称</td>
            </tr>
            <tr>
                <td>链接地址：</td>
                <td><input type="text" name="link_dir" size="30" /></td>
                <td><span class="must">*</span>请输入链接的地址</td>
            </tr>
             <tr>
                <td>上传链接图片：</td>
                <td><input type="file" name="link_image" size="40"/></td>
                <td>如果你需要使用图片链接，请上传图片。图片格式为jpg,gif,png,bmp，大小不能超过5MB。</td>
            </tr>
        </tbody>
      </table>
      <div class="op"><input type="submit" name="sub" value="添加"/>&nbsp;<input type="reset" name="re" value="重置"/></div>
      </form>
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
