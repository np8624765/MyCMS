<?php
// ------------------------------------------------------------------------
/**
 * 单入口文件
 * 项目里所有页面跳转都是由这个index.php单一入口文件控制的
 * 1：负责载入项目全程必要的文件
 * 2：根据传递的控制器名和方法名，实例化对象并调用其中的方法
 * 
 * @author 陈志辉
 * @time 2013-11-14 
 */
	//申明header信息
	header("Content-Type: text/html; charset=utf-8");
	
	//启动session
	session_start();
	
	//载入全局文件
	include("common/error.php");		//错误处理
	include("common/permission.php");	//权限判断
	include("common/encrypt.php");		//加密
	include("system/my_database.php");	//数据库
	include("system/my_model.php");		//模型
	include("system/my_controll.php");	//控制器
	include("system/my_view.php");		//视图
	
	
	//判断传递的控制器(类)名称是否为空，默认为defalut
	if(!isset($_GET['action']))
	{
		$_GET['action'] = '';
	}
	
	$action = $_GET['action'];
	$action = $action == '' ? 'defalut' : $action;
	 
	//判断传递的方法名(类中成员方法)是否为空，默认为index
	if (!isset($_GET['method']))
	{
		$_GET['method'] = 'index';
	}
	$method = $_GET['method'];
	$method = $method == '' ? 'index' : $method;
	
	//根据控制器名称载入相对应的类文件，未找到则跳转404页面， _autoload为php自带加载文件方法
	function __autoload($action)
	{
		$classpath="controllers/".$action.".php";
	 	if(file_exists($classpath))
	 	{
	  		include($classpath);
	 	}
	 	else
	 	{
	 		$error = new Error();
	  		$error->error_404(0);
	 	}
	}
	
	//实例化一个控制器对象，并调用相对应的方法
	$controller = new $action();
	$controller->$method();
	
?>
