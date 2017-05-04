<?php
class Users extends My_model
{
	
	function __construct()
	{
		parent::__construct();
	}
	
	//验证登录，保存session
	function checkLogin($_username,$_password)
	{
		$result = $this->db->select(
			"select * from `users` where `username`='$_username' 
					and `isexist`=0 and `permission`!=3 and `ischeck`=1");
		if (empty($result))
		{
			return false;
		}
		else 
		{
			//密码进行加密运算后比较
			if($result[0]['password'] == getEncPwd($_password))
			{
				//用Session保存用户信息
				$_SESSION['uid'] = $result[0]['uid'];
				$_SESSION['username'] = $result[0]['username'];
				$_SESSION['per'] = $result[0]['permission'];
				$_SESSION['last'] = $result[0]['lasttime'];
				$_SESSION['time'] = time();
				$time = date('Y-m-d H:i:s',$_SESSION['time']);
				$this->db->update("users",array("lasttime"=>$time),"username",$result[0]['username']);
				return true;
			}
		}
		return false;
	}
	
	//新增一个用户
	function add_user($name,$pwd,$per,$wid,$real,$dep,$app,$uphone,$ushort,$uoffice,$uhome,$email,$qq)
	{
		$user = $this->db->select("select `uid` from `users` where `username`='$name'");
		if($user)
		{
			return "exist";
			exit(0);
		}
		$pwd = getEncPwd($pwd);
		$time = date('Y-m-d H:i:s',time());
		$data = array(
			"username"=>$name,"password"=>$pwd,"permission"=>$per,"wid"=>$wid,"realname"=>$real,
					"department"=>$dep,"appellation"=>$app,"uemail"=>$email,"uphone"=>$uphone,
							"ushort"=>$ushort,"uoffice"=>$uoffice,"uhome"=>$uhome,"uqq"=>$qq,"ischeck"=>1,"utime"=>$time);
		$result = $this->db->insert("users",$data);
		return $result;
	}
	
	//获得所有用户
	function getAllUsers()
	{
		$result = $this->db->select("select * from `users` where `isexist`=0 and `ischeck`=1");
		return $result;
	}
	
	//获得用户总数
	function getSum($permi,$isexist=0)
	{
		//判断权限
		if($permi==4)
		{
			$field = "";
		}
		else
		{
			$field = "`permission`='$permi' AND";
		}
		$result = $this->db->select(
					"select count(`uid`) as sum from `users` where $field `isexist`=$isexist and `ischeck`=1");
		return $result[0]['sum'];
	}
	
	//获得部分用户
	function getLimitUsers($permi,$start,$size,$isexist=0)
	{
		//判断权限
		if($permi==4)
		{
			$field = "";
		}
		else
		{
			$field = "`permission`='$permi' AND";
		}
		$result = $this->db->select(
				"select * from `users` where $field `isexist`=$isexist and `ischeck`=1
					order by `utime` desc limit $start,$size");
		return $result;
	}
	
	//删除用户至回收站中
	function delete_user($field,$value)
	{
		$result = $this->db->update("users",array("isexist"=>1),$field,$value);
		return $result;
	}
	
	//获得一个用户信息
	function getUserInfo($uid)
	{
		$result = $this->db->select(
			"select * from `users` where `uid`=$uid");
		return $result;
	}
	
	//更新用户信息
	function up_user($uid,$name,$per,$wid,$real,$dep,$app,$uphone,$ushort,$uoffice,$uhome,$email,$qq)
	{
		$user = $this->db->select("select `uid` from `users` where `username`='$name'");
		if($user)
		{
			if($user[0]['uid']!=$uid)
			{
				return "exist";
				exit(0);		
			}
		}
		
		$data = array(
			"username"=>$name,"permission"=>$per,"wid"=>$wid,"realname"=>$real,
				"department"=>$dep,"appellation"=>$app,"uemail"=>$email,"uphone"=>$uphone,
					"uqq"=>$qq,"ushort"=>$ushort,"uoffice"=>$uoffice,"uhome"=>$uhome);
		
		$result = $this->db->update("users",$data,"uid",$uid);
		return $result;
	}
	
	//修改自己密码
	function modify_pwd($uid,$old,$new)
	{
		$user = $this->db->select("select `password` from `users` where `uid`='$uid'");
		if((getEncPwd($old))!=$user[0]['password'])
		{
			return "error";
			exit(0);
		}
		$new = getEncPwd($new);
		$result = $this->db->update("users",array("password"=>$new),"uid",$uid);
		return $result;
	}
	
	//修改用户密码
	function change_pwd($uid,$new)
	{
		$new = getEncPwd($new);
		$result = $this->db->update("users",array("password"=>$new),"uid",$uid);
		return $result;
	}
	
	//获得在回收站中的用户
	function getInRec()
	{
		$result = $this->db->select("select * from `users` where `isexist`=1 and `ischeck`=1 order by `utime` desc");
		return $result;
	}
	
	//彻底清除用户
	function clearUser($uid)
	{
		$result = $this->db->delete("users","uid",$uid);
		if($result!=null)
		{
			return "ok";
			exit(0);
		}
		else
		{
			return "error";
			exit(0);
		}
	}
	
	//恢复用户
	function recoverUser($uid)
	{
		$result = $this->db->update("users",array("isexist"=>0),"uid",$uid);
		return $result;
	}
}
?>