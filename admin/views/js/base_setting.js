$(document).ready(function(){
	//列表样式
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
			var info = "提交失败! ";
			var name = $.trim(form.web_name.value);
			var address = $.trim(form.web_address.value);
			var keyword = $.trim(form.web_keyword.value);
			var desc = $.trim(form.web_description.value);
			var footer = $.trim(form.web_footer.value);
			var sess = $.trim(form.web_session.value);
			var phone = $.trim(form.web_phone.value);
			var email = $.trim(form.web_email.value);
			
			if((name=="")||(address=="")||(keyword=="")||(desc=="")||(footer=="")) {
				isok = false;
				info += "必填项不能为空 ";	
			}
			if(!isok)
			{
				alert(info);
				//window.location.reload();
				return false;  //只要不返回false，表单都会提交,在这里可以对表单元素进行验证 
			}
			return true;
	};  
  
	function showResponse(responseText, statusText){  
   		  if($.trim(responseText)=="ok") {
			  $(".message").addClass("green");
			  $(".message").find("span").text("修改成功！");
		  }else{
			  $(".message").addClass("red");
			  $(".message").find("span").text("修改失败！");
		  }
		  $(".message").slideDown().delay(3000).slideUp();
	};  
	
	$('#myform').submit(function() {  
  		 $(this).ajaxSubmit(options);  
   		 return false; //阻止表单默认提交  
	}); 
	
});