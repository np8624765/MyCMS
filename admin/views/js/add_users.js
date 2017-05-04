$(document).ready(function(){
    $('table.setting tbody>tr:even').addClass("even");
	$('table.setting tbody>tr').find('td:eq(0)').addClass("one");
	$('table.setting tbody>tr').find('td:eq(2)').addClass("three");
	
	var options = {        
   					beforeSubmit: showRequest,  //提交前的回调函数  
   					success: showResponse,      //提交后的回调函数  
   					timeout: 3000               //限制请求的时间，当请求大于3秒后，跳出请求  
	}  
  
	function showRequest(formData, jqForm, options){   
  			var form = jqForm[0];
			var isok = true;
			var info = "添加失败! ";
			var name = $.trim(form.new_uname.value);
			var pwd1 = $.trim(form.new_pwd1.value);
			var pwd2 = $.trim(form.new_pwd2.value);
			var per = $.trim(form.new_per.value);
			
			//判断是否特殊字符
			var patt = /^[_0-9a-zA-Z]{0,30}$/
			if(!patt.test(name)) {
				isok = false;
				info += "用户名不符合规范 ";	
			}
			if((name=="")||(pwd1=="")||(pwd2=="")||(per=="")) {
				isok = false;
				info += "必填项不能为空 ";	
			}
			if(pwd1!=pwd2)
			{
				isok = false;
				info += "两次输入的密码不相同 ";	
			}
			if(!isok)
			{
				alert(info);
				return false;  //只要不返回false，表单都会提交,在这里可以对表单元素进行验证 
			}
			return true;
	};  
  
	function showResponse(responseText, statusText){  
   		  if($.trim(responseText)=="ok") {
			  window.location.href="index.php?action=users_manage&method=show_users";
		  }else if($.trim(responseText)=="exist") {
			  $(".message").addClass("red");
			  $(".message").find("span").text("添加失败！用户名已存在");
		  }else{
			  $(".message").addClass("red");
			  $(".message").find("span").text("添加失败！");
		  }
		  $(".message").slideDown().delay(2000).slideUp();
	};  
	
	$('#myform').submit(function() {  
  		 $(this).ajaxSubmit(options);  
   		 return false; //阻止表单默认提交  
	}); 
	
});