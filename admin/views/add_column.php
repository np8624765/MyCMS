<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>栏目管理-添加栏目</title>
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
.op { width:100%; padding:5px 0px 0px 175px;}
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
		var cname = $.trim(form.col_name.value);
		var fid = $.trim(form.col_fid.value);
		var sid = $.trim(form.col_sid.value);
		var ckey = $.trim(form.col_key.value);
		var cdes = $.trim(form.col_des.value);
		var ctype = $.trim(form.col_type.value);
		var ccon = $.trim(form.col_con.value);
		
		
		if((cname=="")||(fid==null)||(ctype==null)||(ccon==null)) {
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
			  window.location.href="index.php?action=column_manage&method=show_column";
		  }else if($.trim(responseText)=="imageerror"){
			  $(".message").addClass("red");
			  $(".message").find("span").text("添加失败！图片上传失败");
		  }else{
			  $(".message").addClass("red");
			  $(".message").find("span").text("添加失败");
		  }
		  $(".message").slideDown().delay(2000).slideUp();
	};  
	
	//终止默认的发生方式
	$('#myform').submit(function() {  
  		 $(this).ajaxSubmit(options);  
   		 return false; 
	}); 
	
	//链接型url
	$("#url").hide();
	$("input[name='col_con']").click(function(){
		var id = $("input[name='col_con']:checked").val();
		if(id==2) {
			$("#url").show();
		}else {
			$("input[name='col_curl']").val("http://");
			$("#url").hide();
		}
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
      <td class="top_m"><div class="title"><span>添加栏目</span></div></td>
      <td class="top_r"></td>
    </tr>
    <tr class="mid">
      <td class="mid_l"></td>
      <td class="mid_m">
      <!------------------------自定义--------------------------->
      <div class="content">
      	  <div class="intro">
          	<p>当前位置：添加栏目</p>
            <img src="views/images/add_column.png" />
            <span>在这里，您可以添加新的栏目！<br /><br />特别注意：请在添加介绍型栏目或链接型栏目之后，到文章管理模块为该栏目添加一篇子文章作为内容，否则栏目不生效。</span>
          </div>
       <form id="myform" action="index.php?action=column_manage&method=add_newcol" method="post" enctype="multipart/form-data">
 	  	<table class="setting" border="0" cellspacing="0">
      	<thead><tr><th>栏目设置列表</th><th></th><th></th></tr></thead>
        <tbody>
            <tr>
                <td width="15%">栏目名称：</td>
                <td width="30%"><input type="text" name="col_name" size="20" /></td>
                <td><span class="must">*</span>请输入您的栏目名称</td>
            </tr>
            <tr>
                <td>选择父级栏目：</td>
                <td>
                	<select name="col_fid" id="col_fid">
                    	<option value="0" selected="selected">设为主栏目</option>
                        <?php foreach($main as $value){?>
                        <option value="<?php echo $value['cid']?>"><?php echo $value['cname']?></option>
                        <?php }?>
                    </select>
                </td>
                <td><span class="must">*</span>你选择新增栏目的父级栏目，也可设为主栏目</td>
            </tr>
            <tr>
                <td>显示优先级：</td>
                <td><input type="text" name="col_sid" size="10" /></td>
                <td>设置该栏目显示时的排列顺序，优先级最高为1，级数越大优先级越低，不填写即默认，优先级最低，排列在最后。</td>
            </tr>
             <tr>
                <td>栏目关键字：</td>
                <td><input type="text" name="col_key" size="40" /></td>
                <td>设置栏目关键字利于被搜索引擎收录，多个关键字请以“，”隔开</td>
            </tr>
             <tr>
                <td>栏目描述：</td>
                <td><input type="text" name="col_des" size="40" /></td>
                <td>设置栏目描述利于被搜索引擎收录，一句话介绍该栏目即可</td>
            </tr>
            <tr>
                <td>上传栏目图片：</td>
                <td><input type="file" name="col_image" size="40"/></td>
                <td>若选择专题型栏目，请上传图片。图片格式为jpg,gif,png,bmp，大小不能超过5MB。</td>
            </tr>
             <tr>
                <td>栏目类型：</td>
                <td>
                	导航型<input type="radio" name="col_type" value="0" checked="checked"/>
                    专题型<input type="radio" name="col_type" value="1"/>
                </td>
                <td><span class="must">*</span>导航型栏目会出现在首页导航栏中，而专题型栏目不会出现在导航栏中，只在网站的其他地方使用</td>
            </tr>
             <tr>
                <td>栏目内容形式：</td>
                <td>
                	列表型<input type="radio" name="col_con" value="0" checked="checked"/>
                    介绍型<input type="radio" name="col_con" value="1"/>
                    链接型<input type="radio" name="col_con" value="2"/>
                </td>
                <td><span class="must">*</span>列表型栏目内容是文章列表，介绍型栏目内容是一篇介绍性文章，链接型栏目点击后跳转到其他网页。</td>
            </tr>
            <tr id="url">
                <td>链接型栏目URL：</td>
                <td><input type="text" name="col_curl" size="40" value="http://"/></td>
                <td>选择链接型栏目后，请为该栏目添加一个URL地址，并确保以http://开头</td>
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
