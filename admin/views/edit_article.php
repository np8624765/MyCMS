<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>编辑文章</title>
<link href="views/style/base.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="editor/themes/default/default.css" type="text/css"/>
<link rel="stylesheet" href="editor/plugins/code/prettify.css" type="text/css"/>
<link type="text/css" rel="stylesheet" href="views/style/calendar.css" >
<style type="text/css">
.message { position:absolute;
		   z-index:10;
		   margin:0px 450px; 
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
.op { width:100%; padding:5px 0px 0px 170px;}
.green { background:url(views/images/mess_green.png) left top;}
.red { background:url(views/images/mess_red.png) left top;}
</style>
<script type="text/javascript" src="views/js/jquery-1.6.4.js"></script>
<script type="text/javascript" src="views/js/jquery.form.js"></script>
<script charset="utf-8" src="editor/kindeditor.js"></script>
<script charset="utf-8" src="editor/lang/zh_CN.js"></script>
<script charset="utf-8" src="editor/plugins/code/prettify.js"></script>
<script type="text/javascript" src="views/js/calendar.js" ></script>  
<script type="text/javascript" src="views/js/calendar-zh.js" ></script>
<script type="text/javascript" src="views/js/calendar-setup.js"></script>
<script>
KindEditor.ready(function(K) {
	//表格样式
	$('table.setting tbody>tr:even').addClass("even");
	$('table.setting tbody>tr').find('td:eq(0)').addClass("one");
	$('table.setting tbody>tr').find('td:eq(2)').addClass("three");
	
	//在线编辑器设置
	var editor1 = K.create('textarea[name="acontent"]', {
		cssPath : 'editor/plugins/code/prettify.css',
		uploadJson : 'editor/php/upload_json.php',
		fileManagerJson : 'editor/php/file_manager_json.php',
		allowFileManager : true
	});
	prettyPrint();
	
	//ajax
	var options = {        
   					beforeSubmit: showRequest,  
   					success: showResponse,      
   					timeout: 3000               
	}  
  
	function showRequest(formData, jqForm, options){   
		var form = jqForm[0];
		var isok = true;
		var info = "编辑失败! ";
		var atitle = form.atitle.value;
		var abelong = $.trim(form.abelong.value);
		var atype = $.trim(form.atype.value);
		var aimage = $.trim(form.aimage.value);
		var acontent = form.acontent.value;
		var atime = form.atime.value;
		var isbold=$("input[name='isbold'][type='radio']:checked").val(); 
		var istop=$("input[name='istop'][type='radio']:checked").val(); 
		var isshow=$("input[name='isshow'][type='radio']:checked").val(); 
	
		if((atitle=="")||(abelong==null)||(atype==null)||(atime=="")||(isbold==null)||(istop==null)||(isshow=="")) {
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
			  window.location.href="index.php?action=article_manage&method=show_article";
		  }else if($.trim(responseText)=="error"){
			  $(".message").removeClass("green");
			  $(".message").addClass("red");
			  $(".message").find("span").text("编辑失败！图片标题上传错误");
		  }else{
			  $(".message").removeClass("green");
			  $(".message").addClass("red");
			  $(".message").find("span").text("编辑失败");
		  }
		  $(".message").slideDown().delay(2000).slideUp();
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
  <table class="wrap" cellspacing="0">
    <tr class="top">
      <td class="top_l"></td>
      <td class="top_m"><div class="title"><span>编辑文章</span></div></td>
      <td class="top_r"></td>
    </tr>
    <tr class="mid">
      <td class="mid_l"></td>
      <td class="mid_m">
      <!------------------------自定义--------------------------->
      <div class="content">
      	  <div class="intro">
          	<p>当前位置：<a href="index.php?action=article_manage&method=show_article">文章管理</a>->编辑文章</p>
            <img src="views/images/edit_article.png" />
            <span>在这里，您可以编辑文章<br /><br />注意：若要修改图片标题，请重新上传一张图片，若不需要更换，上传框无需填写。上传视频支持flv，mp4格式（小于500MB），或外链其他视频网站带有iframe标签的视频。</span>
          </div>
          <form id="myform" name="myform" action="index.php?action=article_manage&method=edit_art&aid=<?php echo $art['aid'];?>" method="post" enctype="multipart/form-data">
 	  	<table class="setting" border="0" cellspacing="0">
      	<thead><tr><th>编辑文章列表</th><th></th><th></th></tr></thead>
        <tbody>
            <tr>
                <td width="15%">标题：</td>
                <td width="65%"><input type="text" name="atitle" size="60" value="<?php echo $art['atitle'];?>"/></td>
                <td><span class="must">*</span>文章的文字标题</td>
            </tr>
            <tr>
                <td>标题高亮：</td>
                <td>
                	否<input type="radio" name="isbold" value="0" <?php if($art['isbold']==0){echo "checked='checked'";}?>/>&nbsp;&nbsp;&nbsp;
                    是<input type="radio" name="isbold" value="1" <?php if($art['isbold']==1){echo "checked='checked'";}?>/>
                </td>
                <td><span class="must">*</span>设置标题是否高亮显示</td>
            </tr>
            <tr>
                <td width="15%">文章导读：</td>
                <td width="65%"><input type="text" name="aintro" size="60" value="<?php echo $art['aintro'];?>"/></td>
                <td>为文章添加导读部分</td>
            </tr>
            <tr>
                <td>所属栏目：</td>
                <td>
                	<select name="abelong" id="abelong">
                    	<?php foreach($main as $value){?>
                        	<option value="<?php echo $value['cid']?>" <?php if($value['cid']==$art['abelong']){echo "selected='selected'";}?>><?php echo $value['cname']?>---</option>
                            <?php if(!empty($sons[$value['cid']])){foreach($sons[$value['cid']] as $val){?>
                            	<option value="<?php echo $val['cid']?>" <?php if($val['cid']==$art['abelong']){echo "selected='selected'";}?> style="color:#036;">&nbsp;&nbsp;&nbsp;&nbsp;→<?php echo $val['cname']?></option>
                             <?php }} ?>
                        <?php } ?>
                    </select>
                </td>
                <td><span class="must">*</span>文章所属于的栏目</td>
            </tr>
            <tr>
                <td>文章类型：</td>
                <td>
                	<select name="atype" id="atype">
                    	<option value="0" <?php if($art['atype']==0){echo "selected='selected'";}?>>普通型</option>
                        <option value="1" <?php if($art['atype']==1){echo "selected='selected'";}?>>图文型</option>
                        <option value="2" <?php if($art['atype']==2){echo "selected='selected'";}?>>视频型</option>
                        <option value="3" <?php if($art['atype']==3){echo "selected='selected'";}?>>下载型</option>
                        <option value="4" <?php if($art['atype']==4){echo "selected='selected'";}?>>链接型</option>
                    </select>
                </td>
                <td><span class="must">*</span>设置文章的类型</td>
            </tr>
             <tr>
                <td>图片标题：</td>
                <td><input type="file" name="aimage"/></td>
                <td>只有图文型文章才需要上传一张图片</td>
            </tr>
            <tr>
             <td style="vertical-align:top">文章正文：</td>
              <td><textarea name="acontent" style="width:100%;height:500px;visibility:hidden;"><?php echo $art['acontent']?></textarea></td>
                <td></td>
            </tr>
            <tr>
                <td width="15%">发布日期：</td>
                <td width="65%"><input type="text" id="atime" name="atime" size="7" value="<?php echo substr($art['atime'],0,10);?>" onclick="return showCalendar('atime', 'y-mm-dd');"/></td>
                <td><span class="must">*</span>文章的发布日期</td>
            </tr>
            <tr>
                <td>首页显示：</td>
                <td>
                	否<input type="radio" name="isshow" value="0" <?php if($art['isshow']==0){echo "checked='checked'";}?>/>&nbsp;&nbsp;&nbsp;
                    是<input type="radio" name="isshow" value="1" <?php if($art['isshow']==1){echo "checked='checked'";}?>/>
                </td>
                <td><span class="must">*</span>设置是否在首页中显示</td>
            </tr>
            <tr>
                <td>置顶显示：</td>
                <td>
                	否<input type="radio" name="istop" value="0" <?php if($art['istop']==0){echo "checked='checked'";}?>/>&nbsp;&nbsp;&nbsp;
                    是<input type="radio" name="istop" value="1" <?php if($art['istop']==1){echo "checked='checked'";}?>/>
                </td>
                <td><span class="must">*</span>设置是否在列表置顶显示</td>
            </tr>
        </tbody>
      </table>
      <div class="op"><input type="submit" name="sub" value="修改"/>&nbsp;<input type="reset" name="re" value="恢复"/></div>
      <div class="message"><span></span></div>
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