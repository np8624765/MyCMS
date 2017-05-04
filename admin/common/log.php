<?php
// ------------------------------------------------------------------------
/**
 * 日志记录类文件
 * 该类中提供方法，对用户的所有后台操作进行记录
 * 记录内容将按日期保存在logs文件夹中
 * 
 * @author 陈志辉
 * @time 2014-03-09 
 */
class Log
{
	//写入日志
	function writeLog($op="")
	{
		//获得当前时间
		$time = date('Y-m-d H:i:s',time());
		//获得文件名
		$filename = "logs/".substr($time,0,10).".log";
		//打开文件，若不存在，则尝试创建
		@$stream = fopen($filename, "a+");
		//写入内容
		if(isset($_SESSION['uid'])&&isset($_SESSION['username'])&&isset($_SESSION['per']))
		{
			$uid = $_SESSION['uid'];
			$username = $_SESSION['username'];
			$per = $_SESSION['per'];
			switch ($per)
			{
				case '0':
					$level = "超级管理员";
					break;
				case '1':
					$level = "高级管理员";
					break;
				case '2':
					$level = "普通管理员";
					break;
				case '3':
					$level = "普通用户";
					break;
				default:
					$level = "未知权限";
					break;
			}
		}
		else
		{
			$uid = "空";
			$username = "空";
			$level = "空";
		}
		
		$content = "$time , UID:$uid , USERNAME:$username , LEVEL:$level , EVENT:$op"."\r\n";
		fwrite($stream, $content);
		fclose($stream);
	}
	
}

?>