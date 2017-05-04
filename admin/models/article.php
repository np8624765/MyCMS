<?php
class Article extends My_model
{
	function __construct()
	{
		parent::__construct();
	}
	
	//增加新文章
	function addNewArt($author,$atitle,$isbold,$aintro,$abelong,$atype,$acontent,$isshow,$istop,$aimage)
	{
		$imagedir = ""; 
		$dbdir = "";
		$imageok = true;
		//当上传了文件时
		if($aimage['error']==0)
		{
			$imagesize = true;
			$imagetype = true;
			//判断大小是否超过5MB
			if($aimage['size']>(1024*1024*5))
			{
				$imagedir = false;
			}
			//判断文件类型
			$arr = explode('.', $aimage['name']);
			$num = count($arr);
			$type = $arr[$num-1]; 
			switch ($type) {
				case "jpg":
					$imagetype = true;
					break;
				case "jpeg":
					$imagetype = true;
					break;
				case "png":
					$imagetype = true;
					break;
				case "gif":
					$imagetype = true;
					break;
				case "bmp":
					$imagetype = true;
					break;
				default:
					$imagetype = false;
				break;
			}
			if($imagesize&&$imagetype)
			{
				$imagename = time().(rand(1,100)).".".$type;
				$imagedir = "../uploads/pictures/{$imagename}";
				$dbdir = "./uploads/pictures/{$imagename}";
				$imageok = @move_uploaded_file($aimage['tmp_name'],$imagedir);
			}
			else
			{
				$imageok = false;
			}	
		}
		
		if($imageok)
		{
			$time = date('Y-m-d H:i:s',time());
			$data = array(
				'atitle'=>$atitle,'isbold'=>$isbold,'aintro'=>$aintro,'author'=>$author,'abelong'=>$abelong,'atype'=>$atype,
					'acontent'=>$acontent,'aimage'=>$dbdir,'anum'=>0,'isshow'=>$isshow,'istop'=>$istop,
						'isexist'=>0,'atime'=>$time);
			$result = $this->db->insert("article",$data);
			return $result;
		}
		else
		{
			return "error";
		}
	}
	
	
	//获得所有文章
	function getAllArticle($isexist=0)
	{
		$result = $this->db->select(
				"select * from `article` where `isexist`=$isexist order by `aid` desc");
		return $result;
	}
	
	//获得部分文章
	function getLimitArticle($cid,$start,$size,$isexist=0)
	{
		//判断栏目
		if($cid==0)
		{
			$field = "";
		}
		else
		{
			$field = "`abelong`=$cid AND";
		}
		$result = $this->db->select(
				"select * from `article` where $field `isexist`=$isexist 
									order by `aid` desc limit $start,$size");
		return $result;
	}
	
	//获得文章总数
	function getSum($cid,$isexist=0)
	{
		//判断栏目
		if($cid==0)
		{
			$field = "";
		}
		else
		{
			$field = "`abelong`=$cid AND";
		}
		$result = $this->db->select(
					"select count(`aid`) as sum from `article` where $field `isexist`=$isexist");
		return $result[0]['sum'];
	}
	
	//获取一篇文章
	function getArticle($aid)
	{
		$result = $this->db->select(
			"select * from `article` where `aid`=$aid");
		return $result;
	}
	
	//更新文章
	function updateArt($aid,$atitle,$isbold,$aintro,$abelong,$atype,$acontent,$atime,$isshow,$istop,$aimage)
	{
		$imagedir = ""; 
		$dbdir = "";
		$imageok = true;
		//当上传了文件时
		if($aimage['error']==0)
		{
			$imagesize = true;
			$imagetype = true;
			//判断大小是否超过5MB
			if($aimage['size']>(1024*1024*5))
			{
				$imagedir = false;
			}
			//判断文件类型
			$arr = explode('.', $aimage['name']);
			$num = count($arr);
			$type = $arr[$num-1]; 
			switch ($type) {
				case "jpg":
					$imagetype = true;
					break;
				case "jpeg":
					$imagetype = true;
					break;
				case "png":
					$imagetype = true;
					break;
				case "gif":
					$imagetype = true;
					break;
				case "bmp":
					$imagetype = true;
					break;
				default:
					$imagetype = false;
				break;
			}
			if($imagesize&&$imagetype)
			{
				$imagename = time().(rand(1,100)).".".$type;
				$imagedir = "../uploads/pictures/{$imagename}";
				$dbdir = "./uploads/pictures/{$imagename}";
				$imageok = @move_uploaded_file($aimage['tmp_name'],$imagedir);
			}
			else
			{
				$imageok = false;
			}	
		}
		
		if($imageok)
		{
			$atime = $atime.' '.(date('H:i:s',time()));
			if ($dbdir=="")
			{
				$data = array(
					'atitle'=>$atitle,'isbold'=>$isbold,'aintro'=>$aintro,'abelong'=>$abelong,'atype'=>$atype,
						'acontent'=>$acontent,'atime'=>$atime,'isshow'=>$isshow,'istop'=>$istop);
			}
			else
			{
				$data = array(
					'atitle'=>$atitle,'isbold'=>$isbold,'aintro'=>$aintro,'abelong'=>$abelong,'atype'=>$atype,
						'acontent'=>$acontent,'aimage'=>$dbdir,'atime'=>$atime,'isshow'=>$isshow,'istop'=>$istop);
			}
			$result = $this->db->update("article",$data,'aid',$aid);
			return $result;
		}
		else
		{
			return "error";
		}
	}
	
	//删除文章至回收站中
	function delete_art($field,$value)
	{
		$result = $this->db->update("article",array("isexist"=>1),$field,$value);
		return $result;
	}
	
	//获得在回收站中的文章
	function getInRec()
	{
		$result = $this->db->select("select * from `article` where `isexist`=1 order by `atime` desc");
		return $result;
	}
	
	//彻底清除在回收站中的文章
	function clearArticle($aid)
	{
		$result = $this->db->delete("article","aid",$aid);
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
	
	//恢复文章
	function recoverArticle($aid)
	{
		$result = $this->db->select(
							"select `abelong` from `article` where `aid`='$aid'");
		//需要判断所属栏目是否存在
		$cid = $result[0]['abelong'];
		$father = $this->db->select(
				"select `cid` from `column` where `cid`='$cid' and `isexist`=0");
		
		if($father!=null)
		{
			$result = $this->db->update("article",array("isexist"=>0),"aid",$aid);
			return $result;
		}
		else
		{
			return "notfather";
			exit(0);
		}
	}
	
	//搜索结果
	function getSearch($key)
	{
		@$key = mysql_real_escape_string($key);
		$result = $this->db->select(
				"select * from `article` where `atitle` like '%$key%' and `isexist`=0 order by `aid` desc");
		return $result;
	}
		
}
?>