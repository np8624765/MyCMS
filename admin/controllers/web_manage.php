<?php
class Web_manage extends My_controll
{
	
	function __construct()
	{
		parent::__construct();
		//载入模型
		$this->modelLoad("base_setting");
		$this->modelLoad("links");
		$this->modelLoad("logs");
		//判断是否已经登录
		$this->permission->islogined();
		//判断是否超时
		$this->permission->overtime();
		//判断是否是高级管理员以上
		$this->permission->isPer(1);
		
	}
	
	//载入基本设置界面
	function base_setting()
	{
		//判断是否是超级管理员以上
		$this->permission->isPer(0);
		//获得基本信息
		$result = $this->model['base_setting']->getInfo();
		$views = array("info"=>$result);
		//载入视图
		$this->view->display("basic_setting",$views);
	}
	
	//更新基本设置
	function base_post()
	{
		//判断是否是超级管理员以上
		$this->permission->isPer(0);
		//获得POST值
		$name = trim($_POST['web_name']);
		$address = trim($_POST['web_address']);
		$keyword = trim($_POST['web_keyword']);
		$description = trim($_POST['web_description']);
		$notice = trim($_POST['web_notice']);
		$footer = trim($_POST['web_footer']);
		$session = trim($_POST['web_session']);
		$phone = trim($_POST['web_phone']);
		$email = trim($_POST['web_email']);
		//更新信息
		$re = $this->model['base_setting']->updateInfo(
			$name,$address,$keyword,$description,$notice,$footer,$session,$phone,$email);
		//立即更新Session失效时间
		$this->model['base_setting']->getOvertime();
		//判断操作是否成功
		if(!$re)
		{
			//写入日志
			$this->model['logs']->add_log("修改基本设置失败");
			echo "fail";
			exit(0);
		}
		//写入日志
		$this->model['logs']->add_log("修改基本设置成功");
		echo "ok";
	}
	
	//载入链接管理界面
	function links_manage()
	{	
		$links = array();
		//获得所有链接组
		$group = $this->model['links']->getGroups();
		//将所有链接归入所属的链接组
		for($i=0; $i<count($group); $i++)
		{
			$link = $this->model['links']->getLinks($group[$i]['gid']);
			for($j=0; $j<count($link); $j++)
			{
				$links[$group[$i]['gid']][$j] = $link[$j]; 
			}
		}
		$views = array('group'=>$group,'links'=>$links);
		//载入视图	
		$this->view->display("links_manage",$views);
	}
	
	//修改链接组名
	function modify_group()
	{
		//获得POST值
		$gid = trim($_POST['gid']);
		$name = trim($_POST['newname']);
		//修改链接组名
		$re = $this->model['links']->group_name($gid,$name);
		//判断是否组名已经存在
		if($re=="exist")
		{
			//写入日志
			$this->model['logs']->add_log("修改链接组名称(gid:".$gid.")失败");
			echo $re;
			exit(0);
		}	
		elseif(!$re)	//判断操作是否成功
		{
			//写入日志
			$this->model['logs']->add_log("修改链接组名称(gid:".$gid.")失败");
			echo "fail";
			exit(0);
		}
		//写入日志
		$this->model['logs']->add_log("修改链接组名称(gid:".$gid.")成功");
		echo "ok";
	}
	
	//载入添加新链接组界面
	function add_group()
	{
		//载入视图
		$this->view->display("add_group");
	}
	
	//新增链接组
	function addLinksGroup()
	{
		//获得POST值
		$name = trim($_POST['group_name']);
		//新增链接组
		$re = $this->model['links']->add_group($name);
		//判断是否组名已经存在
		if($re=="exist")
		{
			//写入日志
			$this->model['logs']->add_log("新增链接组\"".$name."\"失败");
			echo $re;
			exit(0);
		}
		elseif(!$re)
		{
			//写入日志
			$this->model['logs']->add_log("新增链接组\"".$name."\"失败");
			echo "fail";
			exit(0);
		}
		//写入日志
		$this->model['logs']->add_log("新增链接组\"".$name."\"成功");
		$_SESSION['addgroup'] = "ok";
		echo "ok";
	}
	
	//载入添加新链接界面
	function add_link()
	{
		//获得GET值
		$gid = trim($_GET['gid']);
		$views = array('gid'=>$gid);
		//载入视图
		$this->view->display("add_link",$views);
	}
	
	//添加新链接
	function addLink()
	{
		//获得POST和GET值
		$gid = trim($_GET['gid']);
		$name = trim($_POST['link_name']);
		$dir = trim($_POST['link_dir']);
		$image = array('error'=>4);
		//判断是否有上传图片
		if(isset($_FILES['link_image']))
		{
			$image = $_FILES['link_image'];
		}
		//添加新链接
		$re = $this->model['links']->add_link($gid,$name,$dir,$image);
		//是否为图片上传失败
		if($re=="error")
		{
			//写入日志
			$this->model['logs']->add_log("新增链接\"".$name."\"失败");
			echo $re;
			exit(0);
		}
		elseif(!$re)
		{
			//写入日志
			$this->model['logs']->add_log("新增链接\"".$name."\"失败");
			echo "fail";
			exit(0);
		}
		//写入日志
		$this->model['logs']->add_log("新增链接\"".$name."\"成功");
		$_SESSION['addlink'] = "ok";
		echo "ok";
	}
	
	//载入链接编辑界面
	function edit_link()
	{
		//获得GET值
		$lid = $_GET['lid'];
		//获得链接信息
		$re = $this->model['links']->getLinkInfo($lid);
		$views = array('link'=>$re[0]);
		//载入视图
		$this->view->display("edit_link",$views);
	}
	
	//更新链接信息
	function updateLink()
	{
		//获得GET值和POST值
		$lid = $_GET['lid'];
		$name = trim($_POST['link_name']);
		$dir = trim($_POST['link_dir']);
		$image = array('error'=>4);
		//判断是否有上传图片
		if(isset($_FILES['link_image']))
		{
			$image = $_FILES['link_image'];
		}
		//更新链接信息
		$re = $this->model['links']->update_link($lid,$name,$dir,$image);
		//是否为图片上传失败
		if($re=="error")
		{
			//写入日志
			$this->model['logs']->add_log("修改链接信息(lid:".$lid.")失败");
			echo $re;
			exit(0);
		}
		elseif(!$re)
		{
			//写入日志
			$this->model['logs']->add_log("修改链接信息(lid:".$lid.")失败");
			echo "fail";
			exit(0);
		}
		//写入日志
		$this->model['logs']->add_log("修改链接信息(lid:".$lid.")成功");
		$_SESSION['editlink'] = "ok";
		echo "ok";
	}
	
	//删除链接
	function del_link()
	{
		//获得POST值
		$lid = $_POST['lid'];
		//删除链接
		$re = $this->model['links']->delLink($lid);
		if(!$re)
		{
			//写入日志
			$this->model['logs']->add_log("删除链接(lid:".$lid.")失败");
			echo "fail";
			exit(0);
		}
		//写入日志
		$this->model['logs']->add_log("删除链接(lid:".$lid.")成功");
		echo "ok";
	}
	
	//删除链接组
	function del_group()
	{
		//获得POST值
		$gid = $_POST['gid'];
		//删除链接组
		$re = $this->model['links']->delGroup($gid);
		if(!$re)
		{
			//写入日志
			$this->model['logs']->add_log("删除链接组(gid:".$gid.")失败");
			echo "fail";
			exit(0);
		}
		//写入日志
		$this->model['logs']->add_log("删除链接组(gid:".$gid.")成功");
		echo "ok";
	}
}

?>