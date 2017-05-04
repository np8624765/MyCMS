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
			return true;
	};  
  
	function showResponse(responseText, statusText){  
   		  if($.trim(responseText)=="ok") {
			  $(".message").removeClass("red");
			  $(".message").addClass("green");
			  $(".message").find("span").text("修改成功");
		  }else{
			  $(".message").addClass("red");
			  $(".message").find("span").text("修改失败");
		  }
		  $(".message").slideDown().delay(3000).slideUp();
	};  
	
	$('#myform').submit(function() {  
  		 $(this).ajaxSubmit(options);  
   		 return false; 
	}); 
	
});