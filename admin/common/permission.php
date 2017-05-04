<?php
/**
 * 权限判断类
 * 在访问控制器或控制器方法时进行权限判断
 * Session中保存 用户ID，用户名，用户权限，用户上次登录时间，操作时间
 * 1：初始化session值，未登录时为null
 * 2：打印出session值，为测试时使用的方法
 * 3：判断是否已经登录
 * 4：判断访问当前模块的用户是否拥有访问权限
 * 
 * @author 陈志辉
 * @time 2013-11-28 
 */
class Permission
{
	private $uid;
	private $username;
	private $per;
	private $lasttime;
	private $time;
	private $limit;
	
	//初始化函数
	function __construct()
	{
		//如果还未登录，先将Session值全部置NULL
		if(!isset($_SESSION['uid']))
		{
			$this->uid = null;
			$this->username = null;
			$this->per = null;
			$this->lasttime = null;
			$this->time = null;
			$this->limit = null;
		}
		//若已经登录，则获取session值
		else
		{
			$this->uid = $_SESSION['uid'];
			$this->username = $_SESSION['username'];
			$this->per = $_SESSION['per'];
			//报错不提示
			@$this->lasttime = $_SESSION['last'];
			@$this->time = $_SESSION['time'];
			@$this->limit = $_SESSION['limit'];
		}

	}
	
	
	//判断是否已经登录
	function isLogined()
	{
		//没有登录时，销毁Session，跳转到登录页
		if(($this->uid==null)||($this->username==null)||
			($this->per==null)||($this->lasttime==null)||($this->time==null))
		{
			session_destroy();
			echo "<script>top.location='index.php'</script>";
			exit(0);
		}
	}
	
	//判断访问当前模块的用户是否拥有访问权限
	function isPer($manage_per)
	{
		//没有权限时，销毁Session，跳转到登录页
		if(($this->per)>$manage_per)
		{
			session_destroy();
			echo "<script>top.location='index.php'</script>";
		}
	}
	
	//判断是否登录超时
	function overtime()
	{
		$long = time() - $this->time;
		if($long>($this->limit))
		{
			//超时，销毁session退出后台
			session_destroy();
			echo "<script>alert('登录超时，请重新登录!')</script>";
			echo "<script>top.location='index.php'</script>";
		}else{
			//更新时间
			$this->time = time();
		}
	}
}

?>