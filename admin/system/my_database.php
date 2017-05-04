<?php
// ------------------------------------------------------------------------
/**
 * 数据库类文件
 * 项目里所有的模型都要引入数据库对象，才能对数据库进行操作
 * 1：成员变量有 PDO对象
 * 2：成员方法有 ...
 * 
 * @author 陈志辉
 * @time 2013-11-15 
 */

class My_database
{
	// PDO对象
	protected  $db;
	protected  $error;
	/**
	 * 
	 * 构造器方法
	 * 用于初始化PDO对象
	 * @param 数据库类型  $dbtype
	 * @param 主机名            $dbhost
	 * @param 数据库名       $dbname
	 * @param 用户名 	   $dbuser
	 * @param 密码                 $dbpassword
	 */
	function __construct($dbtype,$dbhost,$dbname,$dbuser,$dbpassword)
	{
		//最后一个参数array(PDO::ATTR_PERSISTENT=>TRUE)，表示采用长连接方式连接数据库
		$this->db = new PDO(
			"$dbtype:host=$dbhost;dbname=$dbname", $dbuser, $dbpassword, array(PDO::ATTR_PERSISTENT=>TRUE));
		//设置使用UTF8字符集
		$this->db->query("set names UTF8");
		//实例化错误处理对象
		$this->error = new Error();
	}
	
	/**
	 * 
	 * 执行一个自定义的SQL语句 
	 * 返回被影响的行数
	 */
	function sql($sql)
	{
		$result = $this->db->exec($sql);
		return $result;
	}
	
	/**
	 * 
	 *	传递一个完整的SQL语句，进行执行
	 *  返回值是一个数据集，是二维数组
	 */
	function select($sql)
	{
		$result = $this->db->query($sql);
		return $result->fetchAll();
	}
	
	/**
	 * 
	 *	传递4个参数执行update语句更新数据
	 *  1：表名  2：数据数组（字段=>值）3：where条件的字段 4：where条件的值
	 *  返回update所影响的行数
	 */
	function update($table,$data,$field,$value)
	{
		$con = "";
		$key = array_keys($data);
		for($i=0; $i<count($key); $i++)
		{ 
			$keyname = $key[$i];
			if(count($key)==1||$i==(count($key)-1))
			{
				$con .= "`$keyname`='$data[$keyname]'"; 
			}
			else
			{
				$con .= "`$keyname`='$data[$keyname]',";
			}
			
		}
		$result = $this->db->exec("update `$table` set $con where `$field`='$value'");
		return $result;
	}
	
	/**
	 * 
	 *	传递2个参数执行insert语句插入一条数据
	 *  1：表名  2：数据数组（字段=>值）
	 *  返回insert所影响的行数
	 *  下面的方法写复杂了，可以用array_push(),我懒得改了，使用者可以自行修改...
	 */
	function insert($table,$data)
	{
		$field = "";
		$con = "";
		$key = array_keys($data);
		
		for($i=0; $i<count($key); $i++)
		{
			$keyname = $key[$i];
			if(count($key)==1)
			{
				$field .= "(`$key[$i]`)";
				$con .= "('$data[$keyname]')";
				break;
			}
			elseif($i==0)
			{
				$field .= "(`$key[$i]`";
				$con .= "('$data[$keyname]'";
			}
			elseif($i==(count($key)-1))
			{
				$field .= ",`$key[$i]`)";
				$con .= ",'$data[$keyname]')";
			}
			else
			{
				$field .= ",`$key[$i]`";
				$con .= ",'$data[$keyname]'";
			}
		}

		$result = $this->db->exec("insert into `$table` $field values$con");
		return $result;
	}
	
	/**
	 * 
	 *	传递3个参数执行delete语句插入一条数据
	 *  1：表名   2：字段名  3：值
	 *  返回delete所影响的行数
	 */
	function delete($table,$field,$value)
	{
		$result = $this->db->exec("delete from `$table` WHERE `$field`='$value'");
		return $result;
	}
	
	/**
	 * PHP自带的未知方法错误处理
	 */
	function __call($n,$v)
	{
	  	$this->error->error_404();
	}
	
	/**
	 * ****************************************************************************
	 * ****************************************************************************
	 * 以下方法用于前端数据提取，不含html代码
	 * 由于时间仓促，所提供的方法可能不是很全，请使用者根据需要自行添加函数
	 * 2014-03-07
	 * 作者:陈志辉 - 杭州电子科技大学
	 * ****************************************************************************
	 */
	
	//提取某几个栏目的某些类型的某几条文章信息
	function f_getArts($cols,$types,$start=0,$num=1,$isshow=1)
	{
		//计算SQL语句中的栏目字段
		if($cols=="全部")
		{
			$field1 = "";
		}
		else 
		{
			$field1 = array();
			for($i=0;$i<count($cols);$i++)
			{
				$cid = $cols[$i]; 
				$col = $this->select(
					"select `cid` from `column` where `cid`=$cid");
				if(!empty($col))
				{
					array_push($field1,$col[0]['cid']);
				}
			}
			$field1 = implode(',', $field1);
			$field1 = "`abelong` in(".$field1.") and"; 
		}
		//计算SQL语句中的文章类型
		if($types=="全部")
		{
			$field2 = "";
		}
		else 
		{
			$field2 = array();
			for($i=0;$i<count($types);$i++)
			{
				$atype = $types[$i]; 
				switch ($atype)
				{
					case "普通型":
						$type = '0';
						break;
					case "图文型":
						$type = '1';
						break;
					case "视频型":
						$type = '2';
						break;
					case "下载型":
						$type = '3';
						break;
					case "链接型":
						$type = '4';
						break;
					default:
						$type = "none";
						break;
				}
				if($type!="none")
				{
					array_push($field2,$type);
				}
			}
			$field2 = implode(',', $field2);
			$field2 = "`atype` in(".$field2.") and"; 
		}
		//是否提取需要首页显示的文章
		$field4 = ""; 
		if($isshow==1)
		{
			$field4 = "`isshow`=1 and"; 
		}
		//计算LIMIT字段
		if($start==="全部")
		{
			$field3 = "";
		}
		else
		{
			$field3 = "LIMIT ".$start.",".$num;
		} 
		//生成最终查询语句
		$sql = "SELECT `aid`,`atitle`,`isbold`,`aintro`,`atype`,`aimage`,`atime` FROM `article` 
					WHERE $field1 $field2 $field4 `isexist`=0 
						order by `istop` desc,`atime` desc $field3";
		$result = $this->select($sql);
		return $result;
	}
	
	//用于分页提取文章信息
	function f_getPage($cols,$types,$size,$front,$back)
	{
		$result = array("arts"=>null,"pagelist"=>null,"page"=>null);
		$pagelist = array();
		//计算文章总数
		$sum = count($this->f_getArts($cols,$types,"全部",1,0));
		//计算总页数
		$per = ceil($sum/$size);
		//获得当前页号
		if(isset($_GET['page'])&&($_GET['page']>=1)&&($_GET['page']<=$per))
		{
			$page = $_GET['page'];
		}
		else
		{
			$page = 1;
		}
		$start = ($page-1)*$size;
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
		//将页号组成分页条
		for($i=$f; $i<=$b; $i++)
		{
			array_push($pagelist, $i);
		}
		$arts = $this->f_getArts($cols,$types,$start,$size,0);
		$result['arts'] = $arts;
		$result['pagelist'] = $pagelist;
		$result['page'] = $page;
		$result['sum'] = $sum;
		$result['per'] = $per;
		return $result;
	}
	
	
	//以下函数用于提取各种网站配置信息
	//提取网站名称
	function f_getWebTitle()
	{
		$result = $this->select(
			"SELECT `bcontent` FROM `base_setting` WHERE `bname`='网站名称'");
		return $result[0]['bcontent'];
	}
	
	//提取网站关键词
	function f_getWebKeywords()
	{
		$result = $this->select(
			"SELECT `bcontent` FROM `base_setting` WHERE `bname`='关键词设置'");
		return $result[0]['bcontent'];
	}
	
	//提取网站描述
	function f_getWebDesc()
	{
		$result = $this->select(
			"SELECT `bcontent` FROM `base_setting` WHERE `bname`='网站描述设置'");
		return $result[0]['bcontent'];
	}
	
	//提取网站地址
	function f_getWebUrl()
	{
		$result = $this->select(
			"SELECT `bcontent` FROM `base_setting` WHERE `bname`='网站地址'");
		return $result[0]['bcontent'];
	}
	
	//提取网站滚动通知
	function f_getWebNotice()
	{
		$result = $this->select(
			"SELECT `bcontent` FROM `base_setting` WHERE `bname`='网站滚动通知'");
		return $result[0]['bcontent'];
	}
	
	//提取网站页脚
	function f_getWebFooter()
	{
		$result = $this->select(
			"SELECT `bcontent` FROM `base_setting` WHERE `bname`='网站页脚'");
		return $result[0]['bcontent'];
	}
	
	//以下为提取栏目
	//提取导航型的主栏目信息（包括其下也是导航型的二级栏目信息）
	function f_getNavMainColumn()
	{
		$result = $this->select(
			"SELECT * FROM `column` WHERE `fid`=0 AND `ctype`=0 AND `isexist`=0
					ORDER BY `sid`,`cid`");
		$secs = $this->select(
			"SELECT * FROM `column` WHERE `fid`!=0 AND `ctype`=0 AND `isexist`=0
					ORDER BY `sid`,`cid`");
		//将二级栏目添加到主栏目的属性中
		for($i=0; $i<count($result); $i++)
		{
			$sec = array();
			for($j=0; $j<count($secs); $j++)
			{
				if($secs[$j]['fid']==$result[$i]['cid'])
				{
					array_push($sec, $secs[$j]);
				}
			} 
			$result[$i]['sec'] = $sec;
		}
		return $result;
	}
	
	//根据栏目名，提取栏目信息
	function f_getColumn($cname)
	{
		$result = $this->select(
			"SELECT * FROM `column` WHERE `cname`='$cname' AND `isexist`=0");
		return $result[0];
	}
	
	//根据栏目ID提取栏目信息
	function f_getColumnInfo($cid)
	{
		$cid = check_input(trim($cid));
		$result = $this->select(
			"SELECT * FROM `column` WHERE `cid`=$cid AND `isexist`=0");
		if($result[0])
		{
			return $result[0];
		}
		else
		{
			$this->error->error_404();
		}
	}
	
	//提取某些主栏目下的二级栏目
	function f_getSecColumn($main,$type,$content)
	{
		//提取主栏目CID
		if($main=="全部")
		{
			$field1 = "";
		}
		else
		{
			$field1 = array();
			for ($i=0; $i<count($main); $i++)
			{
				$cname = $main[$i];
				$re = $this->select(
					"SELECT `cid` FROM `column` WHERE `cname`='$cname' AND `isexist`=0");
				array_push($field1, $re[0]['cid']);
			}
			$field1 = implode(',', $field1);
			$field1 = "`fid` in(".$field1.") AND"; 
		}
		//提取类型
		if($type=="全部")
		{
			$field2 = "";
		}
		else
		{
			$field2 = array();
			for ($i=0; $i<count($type); $i++)
			{
				switch ($type[$i])
				{
					case "导航型":
						$ctype = '0';
						break;
					case "专题型":
						$ctype = '1';
						break;
					default:
						$ctype = "none";
						break;
				}
				if($ctype!="none")
				{
					array_push($field2, $ctype);
				}
			}
			$field2 = implode(',', $field2);
			$field2 = "`ctype` in(".$field2.") AND"; 
		}
		//提取内容形式
		if($content=="全部")
		{
			$field3 = "";
		}
		else
		{
			$field3 = array();
			for ($i=0; $i<count($content); $i++)
			{
				switch ($content[$i])
				{
					case "列表型":
						$ccontent = '0';
						break;
					case "介绍型":
						$ccontent = '1';
						break;
					case "链接型":
						$ccontent = '2';
						break;
					default:
						$ccontent = "none";
						break;
				}
				if($ccontent!="none")
				{
					array_push($field3, $ccontent);
				}
			}
			$field3 = implode(',', $field3);
			$field3 = "`ccontent` in(".$field3.") AND"; 
		}
		$result = $this->select(
			"SELECT * FROM `column` WHERE $field1 $field2 $field3 
				`fid`!=0 AND `isexist`=0 ORDER BY `fid`,`sid`,`cid`");
		return $result;
	}
	
	//根据文章标题提取文章
	function  f_getArticleByName($atitle="")
	{
		$result = $this->select(
			"SELECT * FROM `article` WHERE `atitle`='$atitle'");
		return $result[0];
		
	}
	
	//根据文章ID提取文章信息
	function  f_getArticleById($aid="")
	{
		//浏览数+1
		$this->sql("update `article` set `anum`=`anum`+1 where `aid`=$aid");
		$result = $this->select(
			"SELECT * FROM `article` WHERE `aid`='$aid'");
		if($result[0])
		{
			return $result[0];
		}
		else
		{
			$this->error->error_404();
		}
	}
	
	//根据文章ID提取所属栏目cid
	function  f_getCidByArticleId($aid="")
	{
		$result = $this->select(
				"SELECT `abelong` FROM `article` WHERE `aid`='$aid'");
		return $result[0];
	}
	
	
	//获取介绍型栏目的第一篇文章
	function f_getIntroArticle($cid)
	{
		$result = $this->select(
			"SELECT * FROM `article` WHERE `abelong`='$cid'");
		if($result)
		{
			return $result[0];
		}
		else
		{
			$result = array('acontent'=>"该介绍型栏目暂无内容");
			return $result;
		}
	}
	
	//以下为在文章页，提取文章内容
	function f_getArticle($aid)
	{
		$result = $this->select(
				"SELECT `article`.*,`column`.`cname`,`column`.`ccontent` FROM `article`,`column`
				 	WHERE `aid`=$aid AND `article`.`isexist`=0 
				 		AND `article`.`abelong`=`column`.`cid`");
		
		//判断文章是否存在
		if($result)
		{
			//替换文章类型
			if($result[0]['atype']==0)
			{
				$result[0]['atype'] = "普通型";
			}
			elseif($result[0]['atype']==1)
			{
				$result[0]['atype'] = "图文型";
			}
			elseif($result[0]['atype']==2)
			{
				$result[0]['atype'] = "视频型";
			}
			elseif($result[0]['atype']==3)
			{
				$result[0]['atype'] = "下载型";
			}
			elseif($result[0]['atype']==4)
			{
				$result[0]['atype'] = "链接型";
			}
			else
			{
				$result[0]['atype'] = "未知类型";
			}
			return $result[0];
		}
		else
		{
			$this->error->error_404();
		}
	
	}
	
	//以下是提取链接组
	function f_getLinkGroup($gid)
	{
		$result = $this->select(
			"SELECT * FROM `links` WHERE `lgid`=$gid");
		return $result;
	}
	
	//提取一个链接信息
	function f_getLink($lname)
	{
		$result = $this->select(
			"SELECT * FROM `links` WHERE `lname`='$lname'");
		return $result[0];
	}
	
	//根据栏目id和文章标题搜索文章信息
	function f_getSearchArticle($cid,$word)
	{
		$word = check_input(trim($word));
		if($cid==0)
		{
			$field =  "";
		}
		else 
		{
			$field = "`abelong`=$cid AND";
		}
		$result = $this->select(
				"SELECT `aid`,`atitle`,`atime`,`cname` FROM `article`,`column`
						WHERE `atitle` like '%$word%' and $field `article`.`isexist`=0 
							and `article`.`abelong` = `column`.`cid`
								order by `istop` desc,`atime` desc");
		return $result;
	}
	
	//链接型和下载型文章需要提取出内容里的url放入a标签中
	function f_getUrl($value)
	{
		preg_match('#<a.+?href="(.+?)".*?>(.+?)</a>#',$value,$matches);
		return $matches[1];
	}

	
	/**
	 * ****************************************************************************
	 * ****************************************************************************
	 * 以下方法用于前端数据提取，含html代码
	 * 2015-04-19重新修改
	 * 作者:陈志辉 - 杭州电子科技大学
	 * ****************************************************************************
	 */
	
	//提取导航栏
	function html_getNav()
	{
		//获取主栏目，包括二级栏目
		$navs = $this->f_getNavMainColumn();
		//获取网站首页地址
		$weburl = $this->f_getWebUrl();
	    $html = "<ul class='yiji'>
	    			 <li><a class='first-layer' href='$weburl'>首页</a></li>";
	    foreach($navs as $f)
	    {
	    	$html .= "<li><a class='first-layer' href='";
	    	if($f['sec'])
	    	{
	    		$html .= "#'>".$f['cname']."</a>";;
	    	}
	    	elseif($f['ccontent']==2)
	    	{
	    		$html .= $f['curl']."'>".$f['cname']."</a>";;
	    	}
	    	else
	    	{
	    		$html .= "list.php?cid=".$f['cid']."'>".$f['cname']."</a>";
	    	}
	    	//添加子栏目
	    	if($f['sec'])
	    	{
	    		$html .= "<ul class='erji hide'>";
	    		foreach($f['sec'] as $s)
	    		{
			    	$html .= "<li><a href='";
			    	if($s['ccontent']==2)
			    	{
			    		$html .= $s['curl']."'>".$s['cname']."</a></li>";;
			    	}
			    	else
			    	{
			    		$html .= "list.php?cid=".$s['cid']."'>".$s['cname']."</a></li>";
			    	}
	    		}
	    		$html .= "</ul>";
	    	}
	    	$html .= "</li>";
	    }
	    $html .= "</ul>";
	    echo $html;
	}
	
	//提取轮播图片
	function html_getLoopImages($aid)
	{
		$art = $this->f_getArticleById($aid);
		echo $art['acontent'];
	}
	
	//提取某些栏目的部分文章列表(是否带日期)
	function html_getListArts($col,$types,$num,$istime,$size=100)
	{
		$arts = $this->f_getArts($col,$types,0,$num,1);
		if($arts)
		{
			$html = "";
			foreach($arts as $val)
			{
				$val['atitle'] = cut_str($val['atitle'],$size);
				$val['atime'] = substr($val['atime'],0,10);
				if($val['isbold'])
				{
					$html .= "<li class='highlight'>";
				}
				else
				{
					$html .= "<li>";
				}
				$html .= "<a href='";
				if($val['atype']==3||$val['atype']==4)
				{
					$art = $this->f_getArticleById($val['aid']);
					$url = $this->f_getUrl($art['acontent']);
					$html .= $url;
					$html .= "' target='_blank'>".$val['atitle']."</a>";
					if($istime)
					{
						$html .= "<span class='date'>[".$val['atime']."]</span></li>";
					}
					else
					{
						$html .= "</li>";
					}
				}
				else
				{
					$html .= "art.php?aid=".$val['aid'];
					$html .= "'>".$val['atitle']."</a>";
					if($istime)
					{
						$html .= "<span class='date'>[".$val['atime']."]</span></li>";
					}
					else
					{
						$html .= "</li>";
					}
				}
			}
			echo $html;
		}
	}
	
	//提取当前位置，参数对象类型0表示列表页，1表示文章页，对象id，间隔符
	function html_getCurLoc($id,$type,$char='-')
	{
		$url = $this->f_getWebUrl();
		if($type==0)
		{
			$col = $this->f_getColumnInfo($id);
			if($col['fid']==0)
			{
				$html = "<span>
							<a href='".$url."'>首页</a>".$char."
							<a href='list.php?cid=".$col['cid']."'>".$col['cname']."</a>
						</span>";
				echo $html;
			}
			else
			{
				$f = $this->f_getColumnInfo($col['fid']);
				$html = "<span>
							<a href='".$url."'>首页</a>".$char."
							<a href='#'>".$f['cname']."</a>$char
							<a href='list.php?cid=".$col['cid']."'>".$col['cname']."</a>
						</span>";
				echo $html;
			}
		}
		if($type==1)
		{
			$art = $this->f_getArticleById($id);
			$f = $this->f_getColumnInfo($art['abelong']);
			$this->html_getCurLoc($f['cid'],0,$char);
		}
	}
	
	//提取网站外链，0表示提取文字链接，1表示提取图片链接，2提取图片+文字链接
	function html_getLinks($gid,$type=0)
	{
		$links = $this->f_getLinkGroup($gid);
		if($links)
		{
			$html = "<ul>";
			foreach ($links as $val)
			{
				if($type==0)
				{
					$html .= "<li><a href='".$val['ldir']."'>".$val['lname']."</a></li>";
				}
				elseif($type==1)
				{
					$html .= "<li><a href='".$val['ldir']."'><img src='".$val['limage']."'/></a></li>";
				}
				elseif($type==2)
				{
					$html .= "<li><a href='".$val['ldir']."'><img src='".$val['limage']."'/>
								<p>".$val['lname']."</p></a></li>";
				}
			}
			$html .= "</ul>";
			echo $html;
		}
	}

	//获得list页的列表型栏目的列表或者介绍型栏目的内容（是否带日期）
	function html_getListPages($cid,$per,$front,$back,$istime,$size=100)
	{
		$col = $this->f_getColumnInfo($cid);
		if($col['ccontent']==0)
		{
			$result = $this->f_getPage(array($cid),"全部",$per,$front,$back);
			$arts = $result['arts'];
		    $page = $result['pagelist'];
			$cur = $result['page'];
			$sumper = $result['per'];
			$html = "<ul class='news_list'>";
			foreach ($arts as $val)
			{
				$val['atime'] = substr($val['atime'],0,10);
	            $temp = cut_str($val['atitle'],$size);
				if($val['atype']==3||$val['atype']==4)
				{
					$art = $this->f_getArticleById($val['aid']);
					$url = $this->f_getUrl($art['acontent']);
					if($val['isbold'])
					{
						$html .= "<li class='highlight'>";
					}
					else
					{
						$html .= "<li>";
					}
					$html .= "<a href='".$url."' target='_blank'>".$temp."</a>";
					if($istime)
					{
						$html .= "<span class='date'>".$val['atime']."</span></li>";
					}
					else
					{
						$html .= "</li>";
					}
				}			
				else
				{
					if($val['isbold'])
					{
						$html .= "<li class='highlight'>";
					}
					else
					{
						$html .= "<li>";
					}
					$html .= "<a href='art.php?aid=".$val['aid']."'>".$temp."</a>";
					if($istime)
					{
						$html .= "<span class='date'>".$val['atime']."</span></li>";
					}
					else
					{
						$html .= "</li>";
					}
				}
			}
			$html .= "</ul><div class='page' style='text-align:center;margin:10px auto;'>";
			if(count($page)>1) {
				$html .= "<ul id='yw0' class='yiiPager'>";
				$html .= "<li class='previous'><a href='list.php?cid=".$cid."&page=".($cur-1)."'>&lt; 前页</a></li>";
				foreach($page as $val)
				{
					if($val==$cur)
					{
						$html .= " <li class='page selected'><a href='list.php?cid=".$cid."&page=".$val."'>".$val."</a></li> ";
					}
					else
					{
						$html .= " <li class='page'><a href='list.php?cid=".$cid."&page=".$val."'>".$val."</a></li> ";
					}
				}
				$html .= " <li class='next'><a href='list.php?cid=".$cid."&page=".($cur+1)."'>后页 &gt;</a></li> ";
				$html .= " <span>共".$sumper."页</span>";
			}
			$html .= "</div>";
			echo $html;
		}
		elseif($col['ccontent']==1)
		{
			$art = $this->f_getIntroArticle($cid);
			$html = "<div class='content'>".$art['acontent']."</div>";
			echo $html;
		}
	}
	
	//提取一个栏目的图文文章,0图片标题，1图片标题+文章标题
	function html_getImageArts($cid,$num,$type,$size=100)
	{
		$info = $this->f_getColumnInfo($cid);
		$arts = $this->f_getArts(array($info['cid']),array("图文型"),0,$num,0);
		$html = "<ul>";
		foreach($arts as $val)
		{
			$val['atitle'] = cut_str($val['atitle'], $size);
			if($type)
			{
				$html .= "<li><a href='art.php?aid=".$val['aid']."'>
							<img src='".$val['aimage']."'/><span>".$val['atitle']."</span></a></li>";
			}
			else 
			{
				$html .= "<li><a href='art.php?aid=".$val['aid']."'>
							<img src='".$val['aimage']."'/></a></li>";
			}
		}
		$html .= "</ul>"; 
		echo $html;
	}
	
	//用于在list页提取二级栏目的同级栏目列表，0文字名称，1图片名称，2图片名称+文字名称
	function html_getListCols($cid,$type=0)
	{
		$col = $this->f_getColumnInfo($cid);
		if($col['fid']==0)
		{
			$s =  $this->f_getSecColumn(array($col['cname']),"全部","全部");
			if($s)
			{
				$this->html_getListCols($s[0]['cid'],$type);
			}
			else
			{
				$html = "";
				if($type==0)
				{
					$html = "h2>".$s['cname']."</h2>";
				}
				elseif($type==1)
				{
					$html = "<ul><li class='now'><a href='#'><img src='".$col['cimage']."'/></a></li></ul>";
				}
				elseif($type==2)
				{
					$html = "<ul><li class='now'><a href='#'><img src='".$col['cimage']."'/><span>".$col['cname']."</span></a></li></ul>";
				}
				echo $html;
			}
		}
		else
		{
			$f = $this->f_getColumnInfo($col['fid']);
			$s = $this->f_getSecColumn(array($f['cname']),"全部","全部");
			$html = "<h2>".$f['cname']."</h2><ul>";
			foreach($s as $val)
			{
// 				if($val['cid']==$cid)
// 				{
// 					if($type==0)
// 					{
// 						$html .= "<li><a href='#'>".$val['cname']."</a></li>";
// 					}
// 					elseif($type==1)
// 					{
// 						$html .= "<li class='now'><a href='#'><img src='".$val['cimage']."'/></a></li>";
// 					}
// 					elseif($type==2)
// 					{
// 						$html .= "<li class='now'><a href='#'><img src='".$val['cimage']."'/><span>".$val['cname']."</span></a></li>";
// 					}
// 				}
// 				else
				{
					if($val['ccontent']==2)//链接型栏目
					{
						if($type==0)
						{
							$html .= "<li><a href='".$val['curl']."'>".$val['cname']."</a></li>";
						}
						elseif($type==1)
						{
							$html .= "<li><a href='".$val['curl']."'><img src='".$val['cimage']."'/></a></li>";
						}
						elseif($type==2)
						{
							$html .= "<li><a href='".$val['curl']."'><img src='".$val['cimage']."'/><span>".$val['cname']."</span></a></li>";
						}
					}
					else
					{
						if($type==0)
						{
							$html .= "<li><a href='list.php?cid=".$val['cid']."'>".$val['cname']."</a></li>";
						}
						elseif($type==1)
						{
							$html .= "<li><a href='list.php?cid=".$val['cid']."'><img src='".$val['cimage']."'/></a></li>";
						}
						elseif($type==2)
						{
							$html .= "<li><a href='list.php?cid=".$val['cid']."'><img src='".$val['cimage']."'/><span>".$val['cname']."</span></a></li>";
					
						}
					}
				}
			}
			$html .= "</ul>";
			echo $html;
		}
	}
	
	//获取文章内容
	function html_getArticle($aid)
	{
		//浏览数+1
		$this->sql("update `article` set `anum`=`anum`+1 where `aid`=$aid");
		$art = $this->f_getArticle($aid);
		$time = substr($art['atime'],0,10);
		$author = $art['author'];
		$counter = $art['anum'];
		$dd = $art['aintro'];
		$con = $art['acontent'];
		$html = "<div class='art'>
					<div class='art-title'>
						<h1>".$art['atitle']."</h1>
					</div>
					<div class='art-info'><p>
						<span>作者：$author</span>
						<span>浏览数:$counter</span>
						<span>发表时间：$time</span></p>
					</div>
					<div class='art-intro'>$dd</div>
					<div class='art-content'>$con</div>
				 </div>";
		echo $html;
	}
	
	//提取滚动图文,0不带文字标题，1带文字标题
	function html_getRollImages($cols,$num,$type,$size=100)
	{
		$arts = $this->f_getArts($cols,array("图文型"),0,$num,1);
		$html = "";
		foreach($arts as $val)
		{
			if($type==1)
			{
				$val['atitle'] = cut_str($val['atitle'], $size);
				$html .= "<li><a><img src='".$val['aimage']."'><p>".$val['atitle']."</p></a></li>";
			}
			else
			{
				$html .= "<li><a><img src='".$val['aimage']."'></a></li>";
			}
		}
		echo $html;
	}
	
	//提取图片标题+文字标题+导读+链接
	function html_getArtInfo($cols,$num,$size1=100,$size2=100)
	{
		$arts = $this->f_getArts($cols,array("图文型"),0,$num,1);
		if($arts)
		{
			$html = "";
			foreach ($arts as $art)
			{
				$art['atitle'] = cut_str($art['atitle'], $size1);
				$art['aintro'] = cut_str($art['aintro'], $size2);
				$html .= "<li><a href='art.php?aid=".$art['aid']."'><div class='img'><img src='".$art['aimage']."'/></div><div class='text'><p class='stuName'>".$art['atitle']."</p>
						<p class='stuCon'>".$art['aintro']."</p></div></a></li>";
			}
			echo $html;
		}
	}
	
	//提取栏目搜索类目
	function html_getSearchColumn()
	{
		//获取主栏目，包括二级栏目
		$navs = $this->f_getNavMainColumn();
		$html = "<select name='cid'>
		<option value='0' selected='selected'>搜索全部分类</option>";
		foreach($navs as $f)
		{
			$html .= "<option value='".$f['cid']."' disabled='disabled'>".$f['cname']."</option>";
			//添加子栏目
			if($f['sec'])
			{
				foreach($f['sec'] as $s)
				{
					$html .= "<option value='".$s['cid']."'>&nbsp;&nbsp;&lceil;&nbsp;".$s['cname']."</option>";
				}
			}
		}
		$html .= "</select>";
		echo $html;
	}
}
?>