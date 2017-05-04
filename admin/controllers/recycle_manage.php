<?php
class Recycle_manage extends My_controll
{
	function __construct()
	{
		parent::__construct();
		//载入模型
		$this->modelLoad("users");
		$this->modelLoad("article");
		$this->modelLoad("column");
		$this->modelLoad("logs");
		//判断是否已经登录
		$this->permission->islogined();
		//判断是否超时
		$this->permission->overtime();
	}
	
	//显示栏目回收站
	function column_recycle()
	{
		//判断是否为高级管理员以上
		$this->permission->isPer(1);
		//获得在回收站中的栏目
		$cols = $this->model['column']->getInRec();
		$views = array('cols'=>$cols);
		//载入视图
		$this->view->display("column_recycle",$views);
	}
	
	//显示在回收站中的文章列表
	function article_recycle()
	{
		//获得在回收站中的文章总数
		$cid = 0;
		$sum = $this->model['article']->getSum($cid,1);
		//设置每页显示条数
		$size = 11;
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
		$front = 5; //向前显示几页页码
		$back = 5;  //向后显示几页页码
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
		//获取部分和所有栏目信息
		$arts = $this->model['article']->getLimitArticle($cid,$start,$size,1);
		$cols = $this->model['column']->getAllColumn();
		//按级别获得所有栏目
		$sons = array();
		$main = $this->model['column']->getMain();
		for($i=0; $i<count($main); $i++)
		{
			$son = $this->model['column']->getSon($main[$i]['cid']);
			$main[$i]['csons'] = count($son);
			for($j=0; $j<count($son); $j++)
			{
				$sons[$main[$i]['cid']][$j] = $son[$j]; 
			}
		}
		$views = array(
			"arts"=>$arts,"cols"=>$cols,"start"=>$start+1,"per"=>$per,"page"=>$page,
				"front"=>$f,"back"=>$b,'main'=>$main,'sons'=>$sons,'sum'=>$sum);
		$this->view->display("article_recycle",$views);
	}
	
	//显示用户回收站
	function user_recycle()
	{
		//判断是否为超级管理员以上
		$this->permission->isPer(0);
		$permi = 4;
		//获得用户总数
		$sum = $this->model['users']->getSum($permi,1);
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
		$users = $this->model['users']->getLimitUsers($permi,$start,$size,1);
		$views = array("users"=>$users,"start"=>$start+1,"per"=>$per,"page"=>$page,
						"front"=>$f,"back"=>$b,'sum'=>$sum);
		//载入视图
		$this->view->display("user_recycle",$views);
	}
	
	//彻底清除栏目
	function delete_col()
	{
		//判断是否为高级管理员以上
		$this->permission->isPer(1);
		//获得POST值
		$cid = trim($_POST['cid']);
		//彻底清除栏目
		$result = $this->model['column']->clearColumn($cid);
		if($result=="error")
		{
			//写入日志
			$this->model['logs']->add_log("彻底清除栏目(cid:".$cid.")失败");
			echo "error";
			exit(0);
		}
		else
		{
			//写入日志
			$this->model['logs']->add_log("彻底清除栏目(cid:".$cid.")成功");
			//清除成功
     		$_SESSION['clearcol'] = "ok";
     		echo "ok";
		}
	}
	
	//恢复栏目
	function recover_col()
	{
		//判断是否为高级管理员以上
		$this->permission->isPer(1);
		//获得POST值
		$cid = trim($_POST['cid']);
		//恢复栏目
		$result = $this->model['column']->recoverColumn($cid);
		//判断操作结果
		if($result=="notfather")
     	{
     		//写入日志
			$this->model['logs']->add_log("恢复栏目(cid:".$cid.")失败");
			//不存在父栏目
     		echo "notfather";
			exit(0);
     	}
		else
		{
			//写入日志
			$this->model['logs']->add_log("恢复栏目(cid:".$cid.")成功");
			//恢复栏目成功
     		$_SESSION['recovercol'] = "ok";
     		echo "ok";
		}
	}
	
	//彻底清除文章
	function delete_art()
	{
		//获得POST值
		$aid = trim($_POST['aid']);
		//彻底清除文章
		$result = $this->model['article']->clearArticle($aid);
		//判断操作结果
		if($result=="error")
		{
			//写入日志
			$this->model['logs']->add_log("彻底清除文章(aid:".$aid.")失败");
			echo "error";
			exit(0);
		}
		else
		{
			//写入日志
			$this->model['logs']->add_log("彻底清除文章(aid:".$aid.")成功");
			//清除成功
     		$_SESSION['clearart'] = "ok";
     		echo "ok";
		}
	}
	
	//批量彻底清除文章
	function lotdelete_art()
	{
		//获得POST值
		$arr = $_POST['arr'];
		$count = 0;
		foreach ($arr as $aid)
		{
			//彻底清除文章
			$result = $this->model['article']->clearArticle($aid);
			//判断操作结果
			if($result=="ok")
			{
				//写入日志
				$this->model['logs']->add_log("彻底清除文章(aid:".$aid.")成功");
				$count++;
			}
			else
			{
				//写入日志
				$this->model['logs']->add_log("彻底清除文章(aid:".$aid.")失败");
			}
		}
		if($count==count($arr))
		{
			//清除成功
			$_SESSION['lotclearart'] = "ok";
	     	echo $count;
		}
		else
		{
			echo "fail";
		}
	}
	
	//恢复文章
	function recover_art()
	{
		//获得POST值
		$aid = trim($_POST['aid']);
		//获得文章信息
		$art = $this->model['article']->getArticle($aid);
		//恢复文章
		$result = $this->model['article']->recoverArticle($aid);
		//判断操作结果
		if($result=="notfather")
     	{
     		//写入日志
			$this->model['logs']->add_log("恢复文章(aid:".$aid.")失败");
     		echo "notfather";
			exit(0);
     	}
		else
		{
			//写入日志
			$this->model['logs']->add_log("恢复文章(aid:".$aid.")成功");
			//文章数量加一
			$this->model['column']->addCnum($art[0]['abelong']);
     		$_SESSION['recoverart'] = "ok";
     		echo "ok";
		}	
	}
	
	//批量恢复文章
	function lotrecover_art()
	{
		//获得POST值
		$arr = $_POST['arr'];
		$count = 0;
		foreach ($arr as $aid)
		{
			//获得文章信息
			$art = $this->model['article']->getArticle($aid);
			//恢复文章
			$result = $this->model['article']->recoverArticle($aid);
			//判断操作结果
			if($result=="notfather")
	     	{
	     		//写入日志
				$this->model['logs']->add_log("恢复文章(aid:".$aid.")失败");
	     	}
			else
			{
				//写入日志
				$this->model['logs']->add_log("恢复文章(aid:".$aid.")成功");
				//文章数量加一
				$this->model['column']->addCnum($art[0]['abelong']);
	     		$count++;
			}	
		}
		if($count==count($arr))
		{
			$_SESSION['lotrecoverart'] = "ok";
	     	echo $count;
		}
		else
		{
			echo "notfather";
			exit(0);
		}
	}
	
	//彻底清除用户
	function delete_user()
	{
		//判断是否为超级管理员以上
		$this->permission->isPer(0);
		//获得POST值
		$uid = trim($_POST['uid']);
		//彻底清除用户
		$result = $this->model['users']->clearUser($uid);
		//判断操作结果
		if($result=="error")
		{
			//写入日志
			$this->model['logs']->add_log("彻底清除用户(uid:".$uid.")失败");
			echo "error";
			exit(0);
		}
		else
		{
			//写入日志
			$this->model['logs']->add_log("彻底清除用户(uid:".$uid.")成功");
     		$_SESSION['clearuser'] = "ok";
     		echo "ok";
		}
	}
	
	//批量彻底清除用户
	function lotdelete_user()
	{
		//判断是否为超级管理员以上
		$this->permission->isPer(0);
		//获得POST值
		$arr = $_POST['arr'];
		$count = 0;
		foreach ($arr as $uid)
		{
			//彻底清除用户
			$result = $this->model['users']->clearUser($uid);
			//判断操作结果
			if($result=="error")
			{
				//写入日志
				$this->model['logs']->add_log("彻底清除用户(uid:".$uid.")失败");
			}
			else
			{
				//写入日志
				$this->model['logs']->add_log("彻底清除用户(uid:".$uid.")成功");
				$count++;
			}
		}
		if($count==count($arr))
		{
			$_SESSION['lotclearuser'] = "ok";
	     	echo $count;
		}
		else
		{
			echo "fail";
		}
	}
	
	//恢复用户
	function recover_user()
	{
		//判断是否为超级管理员以上
		$this->permission->isPer(0);
		//获得POST值
		$uid = trim($_POST['uid']);
		//恢复用户
		$result = $this->model['users']->recoverUser($uid);
		//判断操作结果
		if($result==null)
     	{
     		//写入日志
			$this->model['logs']->add_log("恢复用户(uid:".$uid.")失败");
     		echo "error";
			exit(0);
     	}
		else
		{
			//写入日志
			$this->model['logs']->add_log("恢复用户(uid:".$uid.")成功");
     		$_SESSION['recoveruser'] = "ok";
     		echo "ok";
		}	
	}
	
	//批量恢复用户
	function lotrecover_user()
	{
		//判断是否为超级管理员以上
		$this->permission->isPer(0);
		//获得POST值
		$arr = $_POST['arr'];
		$count = 0;
		foreach ($arr as $uid)
		{
			//恢复用户
			$result = $this->model['users']->recoverUser($uid);
			//判断操作结果
			if($result==null)
	     	{
	     		//写入日志
				$this->model['logs']->add_log("恢复用户(uid:".$uid.")失败");
	     	}
			else
			{
				//写入日志
				$this->model['logs']->add_log("恢复用户(uid:".$uid.")成功");
	     		$count++;
			}	
		}
		if($count==count($arr))
		{
			$_SESSION['lotrecoveruser'] = "ok";
	     	echo $count;
		}
		else
		{
			echo "fail";
		}
	}
	
}