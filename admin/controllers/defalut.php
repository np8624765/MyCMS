<?php 
class Defalut extends My_controll
{
	
	function __construct()
	{
		parent::__construct();
		//载入模型
		$this->modelLoad("users");
		$this->modelLoad("base_setting");
		$this->modelLoad("logs");
	}
	
	//载入登录界面
	function index()
	{
		//获得首页网址，用于登录页面页脚的返回首页功能
		$url = $this->model['base_setting']->getBaseSetting("网站地址");
		$views = array("url"=>$url[0]['bcontent']);
		//载入视图
		$this->view->display("login",$views);
	}
	
	//验证登录
	function login()
	{
		$uname = $_POST['name'];
		$pwd = $_POST['pwd'];
		$code = $_POST['code'];
		
		//若验证码错误
		if($code!=$_SESSION['rand'])	
		{
			//销毁当前验证码
			unset($_SESSION['rand']);
			echo "codefail";
			exit(0);
		}
		else if($this->model['users']->checkLogin($uname,$pwd))	//验证成功
		{
			//取得超时时间
			$this->model['base_setting']->getOvertime();
			//写入日志
			$this->model['logs']->add_log("登录系统成功");
			echo "success";
			exit(0);
		}else{													//帐号或密码错误
			//写入日志
			$this->model['logs']->add_log("以".$uname."为用户名登录系统失败");
			echo "fail"; 
		}
	}
	
	//退出管理中心
	function logout()
	{
		//写入日志
		$this->model['logs']->add_log("退出系统成功");
		//销毁全部Session
		session_destroy();
		//跳转回登录页
		echo "<script>top.location='index.php'</script>";
	}
	
}

?>

