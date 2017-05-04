<?php
// ------------------------------------------------------------------------
/**
 * 基类模型文件
 * 项目里所有的模型都继承于这个基类模型，模型负责处理业务逻辑
 * 1：成员变量有 数据库对象，错误处理对象
 * 2：成员方法有 构造器方法，错误处理方法
 * 
 * @author 陈志辉
 * @time 2013-11-15 
 */

class My_model
{
	//数据库对象
	protected $db;
	
	//错误处理对象
	protected $error;
	
	/**
	 * 
	 * 构造器
	 * 载入数据库配置文件，对数据库对象，错误处理对象进行初始化操作
	 */
	function __construct()
	{
		//载入数据库配置文件
		include("config/DBconfig.php");
		
		//实参在配置文件中已定义
		$this->db = new My_database(
			$dbtype, $dbhost, $dbname, $dbuser, $dbpassword);
			
		$this->error = new Error();
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
