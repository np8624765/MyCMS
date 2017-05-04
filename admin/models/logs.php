<?php
class Logs extends My_model
{
	function __construct()
	{
		parent::__construct();
	}
	
	//新增一条日志
	function add_log($event)
	{
		$uid = '0';
		$username = '未知操作者';
		$per = '4';
		$rtime = date('Y-m-d H:i:s',time());
		$ip = $_SERVER["REMOTE_ADDR"];
		//写入日志
		if(isset($_SESSION['uid'])&&isset($_SESSION['username'])&&isset($_SESSION['per']))
		{
			$uid = $_SESSION['uid'];
			$username = $_SESSION['username'];
			$per = $_SESSION['per'];
		}
		
		$data = array('uid'=>$uid,'username'=>$username,'permission'=>$per,'event'=>$event,'ip'=>$ip,'rtime'=>$rtime);
		$this->db->insert("logs",$data);
	}
	
	//获得所有日志
	function getAllLogs()
	{
		$result = $this->db->select("select * from `logs`");
		return $result;
	}
	
	//获得日志数量
	function getSum($time=4)
	{
		if($time==4)
		{
			$field = "";
		}
		elseif($time==3)
		{
			$field = "where DATEDIFF(NOW(),rtime)<=1";
		}
		elseif($time==2)
		{
			$field = "where DATEDIFF(NOW(),rtime)<=7";
		}
		elseif($time==1)
		{
			$field = "where DATEDIFF(NOW(),rtime)<=31";
		}
		elseif($time==0)
		{
			$field = "where DATEDIFF(NOW(),rtime)<=366";
		}
		$result = $this->db->select(
					"select count(`uid`) as sum from `logs` ".$field);
		return $result[0]['sum'];
	}
	
	//获取部分日志
	function getLimitLogs($time,$start,$size)
	{
		//判断权限
		if($time==4)
		{
			$field = "";
		}
		elseif($time==3)
		{
			$field = "where DATEDIFF(NOW(),rtime)<=1";
		}
		elseif($time==2)
		{
			$field = "where DATEDIFF(NOW(),rtime)<=7";
		}
		elseif($time==1)
		{
			$field = "where DATEDIFF(NOW(),rtime)<=31";
		}
		elseif($time==0)
		{
			$field = "where DATEDIFF(NOW(),rtime)<=366";
		}
		$result = $this->db->select("select * from `logs` ".$field." order by `rtime` desc limit $start,$size");
		return $result;
	}
}

?>