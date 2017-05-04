<?php
class Person_safety extends My_controll
{
	function __construct()
	{
		parent::__construct();
		//载入模型
		$this->modelLoad("users");
		$this->modelLoad("logs");
		//判断是否已经登录
		$this->permission->islogined();
		//判断是否超时
		$this->permission->overtime();
	}
	
	//载入个人信息界面
	function person_info()
	{
		//获得Session
		$uid = $_SESSION['uid'];
		//获得用户信息
		$result = $this->model['users']->getUserInfo($uid);
		$views = array("data"=>$result);
		//载入视图
		$this->view->display("person_info",$views);
	}
	
	//修改个人信息
	function update_info()
	{
		//获得Session和POST，以及用户信息
		$uid = $_SESSION['uid'];
		$user = $this->model['users']->getUserInfo($uid);
		$name = $user[0]['username'];
		$per = $user[0]['permission'];
		$wid = trim($_POST['new_wid']);
		$real = trim($_POST['new_realname']);
		$dep = trim($_POST['new_dep']);
		$app = trim($_POST['new_app']);
		$uphone = trim($_POST['new_phone']);
		$ushort = trim($_POST['new_short']);
		$uoffice = trim($_POST['new_office']);
		$uhome = trim($_POST['new_home']);
		$email = trim($_POST['new_email']);
		$qq = trim($_POST['new_qq']);
		//更新个人信息
		$re = $this->model['users']->up_user(
				$uid,$name,$per,$wid,$real,$dep,$app,$uphone,
								$ushort,$uoffice,$uhome,$email,$qq);
		//判断操作结果
		if(!$re)
		{
			//写入日志
			$this->model['logs']->add_log("修改个人信息(uid:".$uid.")失败");
			echo "fail";
			exit(0);
		}
		//写入日志
		$this->model['logs']->add_log("修改个人信息(uid:".$uid.")成功");
		echo "ok";
	}
	
	//载入修改密码界面
	function modify_pwd()
	{
		//载入视图
		$this->view->display("person_pwd");
	}
	
	//修改个人密码
	function update_pwd()
	{
		//获得Session和POST值
		$uid = $_SESSION['uid'];
		$old = trim($_POST['old_pwd']);
		$new = trim($_POST['new_pwd1']);
		//修改个人密码
		$re = $this->model['users']->modify_pwd($uid,$old,$new);
		//判断旧密码是否正确
		if($re=="error")
		{
			//写入日志
			$this->model['logs']->add_log("修改个人密码(uid:".$uid.")失败");
			echo $re;
			exit(0);
		}
		elseif(!$re)
		{
			//写入日志
			$this->model['logs']->add_log("修改个人密码(uid:".$uid.")失败");
			echo "fail";
			exit(0);
		}
		//写入日志
		$this->model['logs']->add_log("修改个人密码(uid:".$uid.")成功");
		echo "ok";
	}
}
?>