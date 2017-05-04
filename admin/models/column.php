<?php
class Column extends My_model
{
	function __construct()
	{
		parent::__construct();
	}
	
	//获得所有主栏目
	function getMain()
	{
		$result = $this->db->select(
					"select * from `column` where `fid`=0 and `isexist`=0 order by `sid`");
		return $result;
	}
	
	//获得所有二级栏目
	function getSon($cid)
	{
		$result = $this->db->select(
					"select * from `column` where `fid`=$cid and `isexist`=0 order by `sid`");
		return $result;
	}
	
	//获得一个栏目
	function getColumn($cid)
	{
		$result = $this->db->select("select * from `column` where `cid`=$cid");
		return $result;
	}
	
	//添加一个新栏目
	function addColumn($cname,$fid,$sid,$ckey,$cdes,$ctype,$ccon,$curl,$cimage)
	{
		$imagedir = "";
		$dbdir = "";
		$imageok = true;
		
		//若有上传图片
		if($cimage['error']==0)
		{
			$imagesize = true;
			$imagetype = true;
			//判断大小是否超过5MB
			if($cimage['size']>(1024*1024*5))
			{
				$imagedir = false;
			}
			//判断文件类型
			$arr = explode('.', $cimage['name']);
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
				$imageok = @move_uploaded_file($cimage['tmp_name'],$imagedir);
			}
			else
			{
				$imageok = false;
			}	
		}
		//图片已经上传成功
		if($imageok)
		{
			//显示优先级为空
			if($sid==null)
			{
				if($fid==0)
				{
					$num = $this->db->select(
						"select MAX(`sid`) from `column` where `fid`=0");
					$sid = $num[0][0] + 1;
				}else {
					$num = $this->db->select(
						"select MAX(`sid`) from `column` where `fid`=$fid");
					$sid = $num[0][0] + 1;
				}
			}
			$time = date('Y-m-d H:i:s',time());
			$data = array("cname"=>$cname,"fid"=>$fid,"sid"=>$sid,"ckey"=>$ckey,"cdes"=>$cdes
							,"ctype"=>$ctype,"ccontent"=>$ccon,"curl"=>$curl,"cimage"=>$dbdir,"cnum"=>0,"ctime"=>$time,"isexist"=>0);
			$result = $this->db->insert("column", $data);
			return $result;
		}
		else
		{
			return "error";
		}
	}
	
	//更新栏目信息
	function updateColumn($cid,$cname,$fid,$sid,$ckey,$cdes,$ctype,$ccon,$curl,$cimage)
	{
		$imagedir = "";
		$dbdir = "";
		$imageok = true;
		
		//若有上传图片
		if($cimage['error']==0)
		{
			$imagesize = true;
			$imagetype = true;
			//判断大小是否超过5MB
			if($cimage['size']>(1024*1024*5))
			{
				$imagedir = false;
			}
			//判断文件类型
			$arr = explode('.', $cimage['name']);
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
				$imageok = @move_uploaded_file($cimage['tmp_name'],$imagedir);
			}
			else
			{
				$imageok = false;
			}	
		}
		//图片已经上传成功
		if($imageok)
		{
			//显示优先级为空
			if($sid==null)
			{
				if($fid==0)
				{
					$num = $this->db->select("select MAX(`sid`) from `column` where `fid`=0");
					$sid = $num[0][0] + 1;
				}else {
					$num = $this->db->select("select MAX(`sid`) from `column` where `fid`=$fid");
					$sid = $num[0][0] + 1;
				}
			}
			if ($dbdir=="")
			{
				$data = array("cname"=>$cname,"fid"=>$fid,"sid"=>$sid,"ckey"=>$ckey,"cdes"=>$cdes
								,"ctype"=>$ctype,"ccontent"=>$ccon,'curl'=>$curl);
			}
			else 
			{
				$data = array("cname"=>$cname,"fid"=>$fid,"sid"=>$sid,"ckey"=>$ckey,"cdes"=>$cdes
								,"ctype"=>$ctype,"ccontent"=>$ccon,'curl'=>$curl,"cimage"=>$dbdir);
			}
			$result = $this->db->update("column",$data,"cid",$cid);
			return $result;
		}
		else
		{
			return "error";
		}
	}
	
	//删除栏目
	function delColumn($cid)
	{
		$result = $this->db->select(
							"select `cnum` from `column` where `cid`='$cid'");
		$sons = $this->db->select(
							"select `cid` from `column` where `fid`='$cid' and `isexist`=0");
		if($sons!=null)
		{
			return "col";
			exit(0);
		}
		elseif($result[0]['cnum']!=0)
		{
			return "art";
			exit(0);
		}
		else
		{
			$result = $this->db->update("column",array("isexist"=>1),"cid",$cid);
			return $result;
		}
	}
	
	//栏目文章数量加一
	function addCnum($cid)
	{
		$this->db->sql("update `column` set `cnum`=`cnum`+1 where `cid`=$cid");
	}
	
	//栏目文章数量减一
	function cutCnum($cid)
	{
		$this->db->sql("update `column` set `cnum`=`cnum`-1 where `cid`=$cid");
	}
	
	//获得所有栏目
	function getAllColumn()
	{
		$result = $this->db->select("select * from `column`");
		return $result;
	}
	
	//获得在回收站中的栏目
	function getInRec()
	{
		$result = $this->db->select("select * from `column` where `isexist`=1");
		return $result;
	}
	
	//彻底清除栏目
	function clearColumn($cid)
	{
		$result = $this->db->delete("column","cid",$cid);
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
	
	//恢复栏目
	function recoverColumn($cid)
	{
		$result = $this->db->select(
							"select `fid` from `column` where `cid`='$cid'");
		//若为主栏目，可直接恢复，若为子栏目，需要判断父栏目是否存在
		$fid = $result[0]['fid'];
		if($fid==0)
		{
			$father = "ok";
		}
		else
		{
			$father = $this->db->select(
				"select `cid` from `column` where `cid`='$fid' and `isexist`=0");
		}
		
		
		if($father!=null)
		{
			$result = $this->db->update("column",array("isexist"=>0),"cid",$cid);
			return $result;
		}
		else
		{
			return "notfather";
			exit(0);
		}
	}
	
}

?>