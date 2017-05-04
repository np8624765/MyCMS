<?php
class Admin extends My_controll
{
	function __construct()
	{
		parent::__construct();
		//载入模型
		$this->modelLoad("users");
		//判断是否已经登录
		$this->permission->islogined();
		//判断是否超时
		$this->permission->overtime();
	}
	
	//框架页面
	function index()
	{
		//载入视图
		$this->view->display("index");
	}
	
	//框架头部
	function top()
	{
		//用于在框架顶部显示用户名和上次登录时间
		$name = $_SESSION['username'];
		$last = $_SESSION['last'];
		$views = array("name"=>$name,"last"=>$last);
		//载入视图
		$this->view->display("top",$views);
	}
	
	//左侧菜单
	function menu()
	{
		//依据管理员权限，分别载入不同的视图
		switch ($_SESSION['per'])
		{
			case 0:
				$this->view->display("left_super");
				break;
			case 1:
				$this->view->display("left_senior");
				break;
			case 2:
				$this->view->display("left_normal");
				break;
			default:
				$this->view->display("left_normal");
				break;
		}
	}
	
	//欢迎界面
	function right()
	{
		//获得管理员信息
		$uid = $_SESSION['uid'];
		$user = $this->model['users']->getUserInfo($uid);
		//获得操作系统信息
		$os = $this->getOS();
		//获得浏览器信息
		$browser  = $this->getBrowser();
		//获得IP信息
		$ip  = $_SERVER["REMOTE_ADDR"];
		$views = array(
				'user'=>$user[0],'os'=>$os,'browser'=>$browser,'ip'=>$ip);
		//载入视图
		$this->view->display("right", $views);
	}
	
	//页脚
	function foot()
	{
		//载入视图
		$this->view->display("foot");
	}
	
	//获得浏览器类型
 	function getBrowser()
  	{
	     $sys = $_SERVER['HTTP_USER_AGENT'];
	     if (stripos($sys, "NetCaptor") > 0) {
	         $exp[0] = "NetCaptor";
	         $exp[1] = "";
	     } elseif (stripos($sys, "Firefox/") > 0) {
	        preg_match("/Firefox\/([^;)]+)+/i", $sys, $b);
	        $exp[0] = "Mozilla Firefox";
	        $exp[1] = $b[1];
	     } elseif (stripos($sys, "MAXTHON") > 0) {
	         preg_match("/MAXTHON\s+([^;)]+)+/i", $sys, $b);
	         preg_match("/MSIE\s+([^;)]+)+/i", $sys, $ie);
	         $exp[0] = $b[0] . " (IE" . $ie[1] . ")";
	         $exp[1] = $ie[1];
	     } elseif (stripos($sys, "MSIE") > 0) {
	         preg_match("/MSIE\s+([^;)]+)+/i", $sys, $ie);
	         $exp[0] = "Internet Explorer";
	         $exp[1] = $ie[1];
	     } elseif (stripos($sys, "Netscape") > 0) {
	         $exp[0] = "Netscape";
	         $exp[1] = "";
	     } elseif (stripos($sys, "Opera") > 0) {
	         $exp[0] = "Opera";
	         $exp[1] = "";
	     } elseif (stripos($sys, "Chrome") > 0) {
	         $exp[0] = "Chrome";
	         $exp[1] = "";
	     }elseif (stripos($sys, "Safari") > 0) {
	         $exp[0] = "Safari";
	         $exp[1] = "";
	     } else {
	         $exp[0] = "未知浏览器";
	         $exp[1] = "";
	     }
	     return $exp[0]." ".$exp[1];
 	}

 	//获得操作系统类型
    function getOS() {
		$os_name = $os_ver = null;
		$ua = $_SERVER['HTTP_USER_AGENT'];
		if (preg_match('/Windows 95/i', $ua) || preg_match('/Win95/', $ua)) {
			$os_name = "Windows";
			$os_ver = "95";
		} elseif (preg_match('/Windows NT 5.0/i', $ua) || preg_match('/Windows 2000/i', $ua)) {
			$os_name = "Windows";
			$os_ver = "2000";
		} elseif (preg_match('/Win 9x 4.90/i', $ua) || preg_match('/Windows ME/i', $ua)) {
			$os_name = "Windows";
			$os_ver = "ME";
		} elseif (preg_match('/Windows.98/i', $ua) || preg_match('/Win98/i', $ua)) {
			$os_name = "Windows";
			$os_ver = "98";
		} elseif (preg_match('/Windows NT 6.0/i', $ua)) {
			$os_name = "Windows";
			$os_ver = "Vista";
		} elseif (preg_match('/Windows NT 6.1/i', $ua)) {
			$os_name = "Windows";
			$os_ver = "7";
		} elseif (preg_match('/Windows NT 6.2/i', $ua)) {
			$os_name = "Windows";
			$os_ver = "8";
		} elseif (preg_match('/Windows NT 5.1/i', $ua)) {
			$os_name = "Windows";
			$os_ver = "XP";
		} elseif (preg_match('/Windows NT 5.2/i', $ua)) {
			$os_name = "Windows";
			if (preg_match('/Win64/i', $ua)) {
				$os_ver = "XP 64 bit";
			} else {
				$os_ver = "Server 2003";
			}
		}
		elseif (preg_match('/Mac_PowerPC/i', $ua)) {
			$os_name = "Mac OS";
		} elseif (preg_match('/Windows NT 4.0/i', $ua) || preg_match('/WinNT4.0/i', $ua)) {
			$os_name = "Windows";
			$os_ver = "NT 4.0";
		} elseif (preg_match('/Windows NT/i', $ua) || preg_match('/WinNT/i', $ua)) {
			$os_name = "Windows";
			$os_ver = "NT";
		} 
	     else{
			$os_name = '未知浏览器';
		}
		return $os_name." ".$os_ver;
	}
	
	
}
?>