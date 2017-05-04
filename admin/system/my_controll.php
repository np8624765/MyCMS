<?php
// ------------------------------------------------------------------------
/**
 * 基类控制器文件
 * 项目里所有的控制器都继承于这个基类控制器My_controll
 * 1：成员变量有 错误处理对象，视图对象，模型对象（数组），判断权限对象
 * 2：成员方法有 构造器方法 ，载入模型方法， 错误处理
 * 
 * @author 陈志辉
 * @time 2013-11-14 
 */

class My_controll
{
	//错误处理对象
	protected $error;
	
	//视图对象
	protected $view;
	
	//模型对象数组，用于存放一个控制器里需要的多个模型
	protected $model;
	
	//权限对象，用于判断访问控制器时的权限
	protected $permission;
	
	/**
	 * 
	 * 构造器
	 * 初始化 错误处理对象，视图对象，模型对象数组
	 */
	function __construct()
	{
		$this->error = new Error();
		$this->permission = new Permission();
		$this->model = array();
		$this->view = new My_view();
	}
	
	/**
	 * 载入模型对象，并加入到模型对象数组中
	 * 该方法在控制器子类中的构造器里调用，用于载入多个需要使用到的模型对象
	 * 无返回值
	 */
	function modelLoad($action)
	{
		//判断载入的model文件是否存在，存在则加入模型对象数组，反之报错
		$classpath="models/".$action.".php";
	 	if(file_exists($classpath))
	 	{
	  		include($classpath);
	  		$this->model[$action] = new $action();
	 	}
	 	else
	 	{
			$this->error->error_model();	
	 	}
	}
	
	/**
	 * 
	 * PHP自带的未知方法错误处理
	 */
	function __call($n,$v)
	{
	  	$this->error->error_404(0);
	}
}

?>
