<?php
class System_safety extends My_controll
{
	function __construct()
	{
		parent::__construct();
		//载入模型
		$this->modelLoad("logs");
		//判断是否已经登录
		$this->permission->islogined();
		//判断是否超时
		$this->permission->overtime();
		//判断是否是超级管理员以上
		$this->permission->isPer(0);
	}
	
	function show_logs()
	{
		//判断显示条件
		if(isset($_GET['time']))
		{
			$time = trim($_GET['time']);
		}
		else
		{
			$time = 4;	//默认全部显示
		}
		//获得日志总数
		$sum = $this->model['logs']->getSum($time);
		//设置每页显示条数
		$size = 12;
		//计算总页数,向上取整
		$per = ceil($sum/$size);
		//判断当前页号
		if(isset($_GET['page'])&&($_GET['page']>=1)&&($_GET['page']<=$per))
		{
			$page = $_GET['page'];
		}
		else
		{
			$page = 1;
		}
		//开始条数
		$start = ($page-1)*$size;
		//计算分页条
		$front = 3; //向前显示几页页码
		$back = 3;  //向后显示几页页码
		//计算分页条
		if(($page-$front)<1)
		{
			$f = 1;
		}
		else
		{
			$f = $page-$front;
		}
		if(($page+$back)>$per)
		{
			$b = $per;
		}
		else 
		{
			$b = $page+$back;
		}
		//获得部分用户
		$logs = $this->model['logs']->getLimitLogs($time,$start,$size);
		$views = array("logs"=>$logs,"start"=>$start+1,"per"=>$per,"page"=>$page,
						"front"=>$f,"back"=>$b,'sum'=>$sum,"time"=>$time);
		//载入视图
		$this->view->display("check_logs",$views);
	}
	
}
?>