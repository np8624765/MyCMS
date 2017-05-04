<?php
// ------------------------------------------------------------------------
/**
 * 出错处理类
 * 项目里所有出错处理的方法都在该类中定义
 * 1：404错误处理
 * 2：URI参数错误处理
 * 3：未知模型处理错误处理
 * 
 * @author 陈志辉
 * @time 2013-11-14 
 */

class Error
{
		/**
		 * 
		 * 404错误处理
		 */
		function error_404($i=1)
		{
			if($i)
			{
				header("Location:admin/views/error_404.php");
			}
			else
			{
				header("Location:views/error_404.php");
			}
		}
		
		/**
		 * 
		 * uri参数错误处理
		 */
		function error_param()
		{
			header("Location:views/error_param.php");
		}
		
		/**
		 * 
		 * 未知模型处理错误处理
		 */
		function error_model()
		{
			header("Location:views/error_model.php");
		}
}

 ?>
 