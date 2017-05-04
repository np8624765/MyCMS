<?php
class Users_manage extends My_controll
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
		//权限判断
		$this->permission->isPer(0); //超级管理员权限
	}
	
	//载入添加用户界面
	function add_users()
	{
		//载入视图
		$this->view->display("add_users");
	}
	
	//添加一个新用户
	function add_newuser()
	{
		//获得POST值
		$name = trim($_POST['new_uname']);
		$pwd = trim($_POST['new_pwd1']);
		$per = trim($_POST['new_per']);
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
		//判断必填项是否为空
		if(($name=="")||($pwd=="")||($per==""))
		{
			echo "fail";
			exit(0);
		}
		//新增一个用户
		$re = $this->model['users']->add_user(
			$name,$pwd,$per,$wid,$real,$dep,$app,$uphone,
					$ushort,$uoffice,$uhome,$email,$qq);
		//判断操作结果
		if($re=="exist")
		{
			//写入日志
			$this->model['logs']->add_log("新增用户\"".$name."\"失败");
			echo $re;
			exit(0);
		}
		elseif(!$re)
		{
			//写入日志
			$this->model['logs']->add_log("新增用户\"".$name."\"失败");
			echo "fail";
			exit(0);
		}
		//写入日志
		$this->model['logs']->add_log("新增用户\"".$name."\"成功");
		$_SESSION['adduser'] = "ok";
		echo "ok";
	}
	
	//显示所有用户
	function show_users()
	{
		//判断显示权限用户
		if(isset($_GET['per']))
		{
			$permi = trim($_GET['per']);
		}
		else
		{
			$permi = 4;
		}
		//获得用户总数
		$sum = $this->model['users']->getSum($permi);
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
		$users = $this->model['users']->getLimitUsers($permi,$start,$size);
		$views = array("users"=>$users,"start"=>$start+1,"per"=>$per,"page"=>$page,
						"front"=>$f,"back"=>$b,'sum'=>$sum,"permi"=>$permi);
		//载入视图
		$this->view->display("users_manage",$views);
	}
	
	//删除用户至回收站中
	function del_user()
	{
		//获得POST值
		$uid = $_POST['uid'];
		//删除用户至回收站中
		$result = $this->model['users']->delete_user('uid',$uid);
		if($result==1)
		{
			//写入日志
			$this->model['logs']->add_log("删除用户(uid:".$uid.")至回收站中成功");
			$_SESSION['deluser'] = "ok";
		}else {
			$this->model['logs']->add_log("删除用户(uid:".$uid.")至回收站中失败");
		}
		echo $result;
	}
	
	//批量删除用户至回收站中
	function lotdel_user()
	{
		//获得POST值
		$arr = $_POST['arr'];
		$count = 0;
		foreach ($arr as $uid)
		{
			//删除用户至回收站中
			$result = $this->model['users']->delete_user('uid',$uid);
			if($result==1)
			{
				//写入日志
				$this->model['logs']->add_log("删除用户(uid:".$uid.")至回收站中成功");
				$count++;
			}else {
				$this->model['logs']->add_log("删除用户(uid:".$uid.")至回收站中失败");
			}
		}
		if($count==count($arr))
		{
			$_SESSION['lotdeluser'] = "ok";
			echo $count;
		}
		else
		{
			echo "fail";
		} 
	}
	
	//载入编辑用户页面
	function edit_user()
	{
		//获得GET值
		$uid = trim($_GET['uid']);
		//获得用户信息
		$data = $this->model['users']->getUserInfo($uid);
		$views = array("user"=>$data);
		//载入视图
		$this->view->display("edit_user",$views);
	}
	
	//修改用户信息
	function update_user()
	{
		//获得GET和POST值
		$uid = trim($_GET['uid']);
		$name = trim($_POST['new_uname']);
		$per = trim($_POST['new_per']);
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
		//判断必填项是否为空
		if(($name=="")||($per==""))
		{
			echo "fail";
			exit(0);
		}
		//修改用户信息
		$re = $this->model['users']->up_user(
			$uid,$name,$per,$wid,$real,$dep,$app,$uphone,
								$ushort,$uoffice,$uhome,$email,$qq);
		//判断操作结果
		if($re=="exist")
		{
			//写入日志
			$this->model['logs']->add_log("修改用户信息(uid:".$uid.")失败");
			echo $re;
			exit(0);
		}
		elseif(!$re)
		{
			//写入日志
			$this->model['logs']->add_log("修改用户信息(uid:".$uid.")失败");
			echo "fail";
			exit(0);
		}
		//写入日志
		$this->model['logs']->add_log("修改用户信息(uid:".$uid.")成功");
		$_SESSION['edituser'] = "ok";
		echo "ok";
	}
	
	//载入修改密码界面
	function mod_pwd()
	{
		//获得GET值
		$uid = trim($_GET['uid']);
		$views = array('uid'=>$uid);
		//载入视图
		$this->view->display("modify_pwd",$views);
	}
	
	//修改用户密码
	function update_pwd()
	{
		//获得GET和POST值
		$uid = trim($_GET['uid']);
		$new = trim($_POST['new_pwd1']);
		//允许超级管理员修改其他用户密码
		$re = $this->model['users']->change_pwd($uid,$new);
		//判断操作结果
		if(!$re)
		{
			//写入日志
			$this->model['logs']->add_log("修改用户(uid:".$uid.")密码失败");
			echo "fail";
			exit(0);
		}
		//写入日志
		$this->model['logs']->add_log("修改用户(uid:".$uid.")密码成功");
		$_SESSION['editpwd'] = "ok";
		echo "ok";
	}
}
?>