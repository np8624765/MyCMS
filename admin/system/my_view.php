<?php
// ------------------------------------------------------------------------
/**
 * 基类视图文件
 * 项目里其实不需要视图的子类，所有视图直接由这个基类实例化
 * 1：成员变量有 数据数组（来自从控制器传递来的数据，这些数据在视图中将展示），错误处理对象
 * 2：成员方法 构造器方法，显示视图方法
 * 
 * @author 陈志辉
 * @time 2013-11-15 
 */

class My_view
{
	//数据数组
	protected $value;
	
	//错误处理对象
	protected $error;
	
	/**
	 * 构造器方法
	 * 对数据数组进行初始化为空操作和初始化错误处理对象
	 */
	function __construct()
	{
		$this->error = new Error();
		$this->value = array();
	}
	
	/**
	 * 构造器方法
	 * 对数据数组进行初始化为空操作
	 */
	function display($_view,$_value=array())
	{
		$this->value = $_value;
		//php自带方法，将数组中的键名和键值拆成相对应的变量名和值，方便在视图中使用数据
		extract($this->value);
		//载入视图文件
		include("views/".$_view.".php");
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
