<?php
class Column_manage extends My_controll
{
	function __construct()
	{
		parent::__construct();
		//载入模型
		$this->modelLoad("column");
		$this->modelLoad("logs");
		//判断是否已经登录
		$this->permission->islogined();
		//判断是否超时
		$this->permission->overtime();
		//判断权限
		$this->permission->isPer(1);
	}
	
	//载入添加栏目界面
	function add_column()
	{
		//获得所有主栏目
		$main = $this->model['column']->getMain();
		$views = array('main'=>$main);
		//载入视图
		$this->view->display("add_column",$views);
	}
	
	//添加一个新栏目
	function add_newcol()
	{
		//获得POST值
		$cname = trim($_POST['col_name']);
		$fid = trim($_POST['col_fid']);
		$sid = trim($_POST['col_sid']);
		$ckey = trim($_POST['col_key']);
		$cdes = trim($_POST['col_des']);
		$ctype = trim($_POST['col_type']);
		$ccon = trim($_POST['col_con']);
		$curl = trim($_POST['col_curl']);
		$cimage = array('error'=>4);
		//判断是否有图片标题上传
		if(isset($_FILES['col_image']))
		{
			$cimage = $_FILES['col_image'];
		}
		//判断必填项是否为空
		if(($cname==null)||($fid==null)||($ctype==null)||($ccon==null))
		{
			echo "fail";
			exit(0);
		}
		//添加一个栏目
		$result = $this->model['column']->addColumn(
									$cname,$fid,$sid,$ckey,$cdes,$ctype,$ccon,$curl,$cimage);
		//判断操作结果
		if($result=="error")
		{
			//写入日志
			$this->model['logs']->add_log("新增栏目\"".$cname."\"失败");
			echo "imageerror";
			exit(0);
		}
		elseif(!$result)
		{
			//写入日志
			$this->model['logs']->add_log("新增栏目\"".$cname."\"失败");
			echo "fail";
			exit(0);
		}
		//写入日志
		$this->model['logs']->add_log("新增栏目\"".$cname."\"成功");
		$_SESSION['addcolumn'] = "ok";
		echo "ok";
     }
     
     //栏目管理，分级显示所有栏目
     function show_column()
     {
     	$sons = array();
     	//获得所有主栏目
		$main = $this->model['column']->getMain();
		//将所有二级栏目归入主栏目中
		for($i=0; $i<count($main); $i++)
		{
			$son = $this->model['column']->getSon($main[$i]['cid']);
			$main[$i]['csons'] = count($son);
			for($j=0; $j<count($son); $j++)
			{
				$sons[$main[$i]['cid']][$j] = $son[$j]; 
			}
		}
		$views = array('main'=>$main,'sons'=>$sons);
		//载入视图	
     	$this->view->display("column_manage",$views);
     }
     
     //编辑栏目
     function edit_column()
     {
     	//获得GET值
     	$cid = trim($_GET['cid']);
     	//获得栏目信息
     	$col = $this->model['column']->getColumn($cid);
     	//获得所有主栏目
     	$main = $this->model['column']->getMain();
		$views = array('main'=>$main,'col'=>$col[0]);
		//载入视图
     	$this->view->display("edit_column",$views);
     }
     
     //更新栏目信息
     function update_column()
     {
     	//获得GET和POST值
     	$cid = trim($_GET['cid']);
     	$cname = trim($_POST['col_name']);
		$fid = trim($_POST['col_fid']);
		$sid = trim($_POST['col_sid']);
		$ckey = trim($_POST['col_key']);
		$cdes = trim($_POST['col_des']);
		$ctype = trim($_POST['col_type']);
		$ccon = trim($_POST['col_con']);
		$curl = trim($_POST['col_curl']);
     	$cimage = array('error'=>4);
     	//判断是否有上传图片标题
		if(isset($_FILES['col_image']))
		{
			$cimage = $_FILES['col_image'];
		}
		//判断必填项是否为空
		if(($cname==null)||($fid==null)||($ctype==null)||($ccon==null))
		{
			echo "fail";
			exit(0);
		}
		//更新栏目信息
		$result = $this->model['column']->updateColumn(
								$cid,$cname,$fid,$sid,$ckey,$cdes,$ctype,$ccon,$curl,$cimage);
		//判断操作结果
     	if($result=="error")
		{
			//写入日志
			$this->model['logs']->add_log("修改栏目(cid:".$cid.")失败");
			echo "imageerror";
			exit(0);
		}
		elseif(!$result)
		{
			//写入日志
			$this->model['logs']->add_log("修改栏目(cid:".$cid.")失败");
			echo "fail";
			exit(0);
		}
		//写入日志
		$this->model['logs']->add_log("修改栏目(cid:".$cid.")成功");
		$_SESSION['editcolumn'] = "ok";
		echo "ok";
     }
     
     //删除栏目
     function del_column()
     {
     	//获得POST值
     	$cid = trim($_POST['cid']);
     	//删除栏目
     	$result = $this->model['column']->delColumn($cid);
     	//判断操作结果
     	if($result=="col")
     	{
     		//写入日志
			$this->model['logs']->add_log("删除栏目(cid:".$cid.")失败");
     		echo "col";
			exit(0);
     	}
     	elseif($result=="art")
		{
			//写入日志
			$this->model['logs']->add_log("删除栏目(cid:".$cid.")失败");
			echo "art";
			exit(0);
		}
		else
		{
			//写入日志
			$this->model['logs']->add_log("删除栏目(cid:".$cid.")至回收站成功");
			//删除成功
     		$_SESSION['delcolumn'] = "ok";
     		echo "ok";
		}
     }
}
?>