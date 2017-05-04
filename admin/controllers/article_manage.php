<?php
class Article_manage extends My_controll
{
	function __construct()
	{
		parent::__construct();
		//载入模型
		$this->modelLoad("article");
		$this->modelLoad("column");
		$this->modelLoad("logs");
		//判断是否已经登录
		$this->permission->islogined();
		//判断是否超时
		$this->permission->overtime();
	}
	
	//添加文章界面
	function add_article()
	{
		//按级别获得所有栏目
		$sons = array();
		//获得所有主栏目
		$main = $this->model['column']->getMain();
		//将所有二级栏目归入主栏目
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
		$this->view->display("add_article",$views);
	}
	
	//添加新文章
	function add_newart()
	{
		//获得POST值
		$author = $_SESSION['username'];
		$atitle = trim($_POST['atitle']);
		$isbold = trim($_POST['isbold']);
		$aintro = trim($_POST['aintro']);
		$abelong = trim($_POST['abelong']);
		$atype = trim($_POST['atype']);
		$acontent = $_POST['acontent'];
		$istop = trim($_POST['istop']);
		$isshow = trim($_POST['isshow']);
		$aimage = array('error'=>4);
		//判断是否有上传图片标题
		if(isset($_FILES['aimage']))
		{
			$aimage = $_FILES['aimage'];
		}
		//添加新文章
		$re = $this->model['article']->addNewArt(
						$author,$atitle,$isbold,$aintro,$abelong,$atype,$acontent,$isshow,$istop,$aimage);

		//判断操作结果
		//上传图片失败
		if($re=="error")
		{
			//写入日志
			$this->model['logs']->add_log("新增文章《".$atitle."》失败");
			echo $re;
			exit(0);
		}
		elseif(!$re)
		{
			//写入日志
			$this->model['logs']->add_log("新增文章《".$atitle."》失败");
			echo "fail";
			exit(0);
		}
		//文章数目加一
		$this->model['column']->addCnum($abelong);
		//写入日志
		$this->model['logs']->add_log("新增文章《".$atitle."》成功");
		$_SESSION['addart'] = "ok";
		echo "ok";
	}
	
	//显示文章列表
	function show_article()
	{
		//判断显示栏目
		if(isset($_GET['cid'])&&($_GET['cid']!=0))
		{
			$cid = trim($_GET['cid']);
		}
		else
		{
			$cid = 0;
		}
		//获得文章总数
		$sum = $this->model['article']->getSum($cid);
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
		$arts = $this->model['article']->getLimitArticle($cid,$start,$size);
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
				"front"=>$f,"back"=>$b,'main'=>$main,'sons'=>$sons,'cid'=>$cid,'sum'=>$sum);
		$this->view->display("article_manage",$views);
	}
	
	//载入编辑页面
	function edit_article()
	{
		//获得GET值
		$aid = trim($_GET['aid']);
		//获得文章信息
		$art = $this->model['article']->getArticle($aid);
		//按级别获得所有栏目
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
		$views = array('main'=>$main,'sons'=>$sons,'art'=>$art[0]);
		//载入视图
		$this->view->display("edit_article",$views);
	}
	
	//修改文章
	function edit_art()
	{
		//获得GET和POST值
		$aid = trim($_GET['aid']);
		$atitle = trim($_POST['atitle']);
		$isbold = trim($_POST['isbold']);
		$aintro = trim($_POST['aintro']);
		$abelong = trim($_POST['abelong']);
		$atype = trim($_POST['atype']);
		$acontent = $_POST['acontent'];
		$atime = trim($_POST['atime']);
		$istop = trim($_POST['istop']);
		$isshow = trim($_POST['isshow']);
		$aimage = array('error'=>4);
		//是否上传图片标题
		if(isset($_FILES['aimage']))
		{
			$aimage = $_FILES['aimage'];
		}
		//获得文章原有信息
		$art = $this->model['article']->getArticle($aid);
		//更新文章信息
		$re = $this->model['article']->updateArt(
						$aid,$atitle,$isbold,$aintro,$abelong,$atype,$acontent,$atime,$isshow,$istop,$aimage);

		//判断操作结果
		if($re=="error")
		{
			//写入日志
			$this->model['logs']->add_log("修改文章(aid:".$aid.")失败");
			echo $re;
			exit(0);
		}
		elseif(!$re)
		{
			//写入日志
			$this->model['logs']->add_log("修改文章(aid:".$aid.")失败");
			echo "fail";
			exit(0);
		}
		//修改文章数量
		if($art[0]['abelong']!=$abelong)
		{
			$this->model['column']->cutCnum($art[0]['abelong']);
			$this->model['column']->addCnum($abelong);
		}
		//写入日志
		$this->model['logs']->add_log("修改文章(aid:".$aid.")成功");
		$_SESSION['editart'] = "ok";
		echo "ok";
	}
	
	//删除文章至回收站中
	function del_article()
	{
		//获得POST值
		$aid = $_POST['aid'];
		//获得文章信息
		$art = $this->model['article']->getArticle($aid);
		//删除文章至回收站
		$result = $this->model['article']->delete_art('aid',$aid);
		//判断操作结果
		if($result==1)
		{
			//将文章数量减一
			$this->model['column']->cutCnum($art[0]['abelong']);
			//写入日志
			$this->model['logs']->add_log("删除文章(aid:".$aid.")至回收站中成功");
			$_SESSION['delart'] = "ok";
			echo $result;
		}
		else
		{
			$this->model['logs']->add_log("删除文章(aid:".$aid.")至回收站中失败");
			echo "fail";
		}
	}
	
	//批量删除文章至回收站中
	function lotdel_article()
	{
		//获得POST值
		$arr = $_POST['arr'];
		$count = 0;
		foreach ($arr as $aid)
		{
			//获得文章信息
			$art = $this->model['article']->getArticle($aid);
			//删除文章至回收站
			$result = $this->model['article']->delete_art('aid',$aid);
			//判断操作结果
			if($result==1)
			{
				//将文章数量减一
				$this->model['column']->cutCnum($art[0]['abelong']);
				//写入日志
				$this->model['logs']->add_log("删除文章(aid:".$aid.")至回收站中成功");
				$count++;
			}
			else
			{
				$this->model['logs']->add_log("删除文章(aid:".$aid.")至回收站中失败");
			}
		}
		//如果删除条数等于数组长度
		if($count==count($arr))
		{
			$_SESSION['lotdel'] = "ok";
			echo $count;
		}
		else
		{
			echo "fail";
		}
	}
	
	//搜索
	function search()
	{
		//获得POST值
		$key = trim($_POST['sea_key']);
		//获得符合搜索的文章
		$arts = $this->model['article']->getSearch($key);
		//获得所有栏目
		$cols = $this->model['column']->getAllColumn();
		$views = array("arts"=>$arts,"cols"=>$cols);
		//载入视图
		$this->view->display("article_search",$views);
	}
	
	
}
?>