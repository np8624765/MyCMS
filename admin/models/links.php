<?php
class Links extends My_model
{
	function __construct()
	{
		parent::__construct();
	}
	
	//获得所有链接组
	function getGroups()
	{
		$result = $this->db->select("select * from `links_group`");
		return $result;
	}
	
	//获得所有链接
	function getAllLinks()
	{
		$result = $this->db->select("select * from `links`");
		return $result;
	}
	
	//获得链接
	function getLinks($gid)
	{
		$result = $this->db->select("select * from `links` where `lgid`=$gid");
		return $result;
	}
	
	//修改组名
	function group_name($gid,$name)
	{
		$result = $this->db->select(
			"select `gid` from `links_group` where `gname`='$name'");
		if($result)
		{
			return "exist";
			exit(0);
		}
		$re = $this->db->update("links_group",array("gname"=>$name),"gid",$gid);
		return $re;
	}
	
	//新增链接组
	function add_group($name)
	{
		$result = $this->db->select(
			"select `gid` from `links_group` where `gname`='$name'");
		if($result)
		{
			return "exist";
			exit(0);
		}
		$data = array('gname'=>$name,'gnum'=>0,'gtime'=>time());
		$re = $this->db->insert("links_group",$data);
		return $re;
	}
	
	//新增链接
	function add_link($gid,$name,$dir,$image)
	{
		$imagedir = "";
		$dbdir = "";
		$imageok = true;
		//当上传了文件时
		if($image['error']==0)
		{
			$imagesize = true;
			$imagetype = true;
			//判断大小是否超过5MB
			if($image['size']>(1024*1024*5))
			{
				$imagedir = false;
			}
			//判断文件类型
			$arr = explode('.', $image['name']);
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
				$imageok = @move_uploaded_file($image['tmp_name'],$imagedir);
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
				'lgid'=>$gid,'lname'=>$name,'ldir'=>$dir,'limage'=>$dbdir,'ltime'=>$time);
			$result = $this->db->insert("links",$data);
			$this->db->sql("update `links_group` set `gnum`=`gnum`+1 where `gid`=$gid");
			return $result;
		}
		else
		{
			return "error";
		}
	}
	
	//获得链接信息
	function getLinkInfo($lid)
	{
		$result = $this->db->select("select * from `links` where `lid`=$lid");
		return $result;
	}
	
	//更新链接信息
	function update_link($lid,$name,$dir,$image)
	{
		$imagedir = "";
		$dbdir = "";
		$imageok = true;
		//当上传了文件时
		if($image['error']==0)
		{
			$imagesize = true;
			$imagetype = true;
			//判断大小是否超过5MB
			if($image['size']>(1024*1024*5))
			{
				$imagedir = false;
			}
			//判断文件类型
			$arr = explode('.', $image['name']);
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
				$imageok = @move_uploaded_file($image['tmp_name'],$imagedir);
			}
			else
			{
				$imageok = false;
			}	
		}
		
		if($imageok)
		{
			//不需要更新图片地址
			if($imagedir=="")
			{
				$data = array(
					'lname'=>$name,'ldir'=>$dir);
			}
			//需要更新图片地址
			else
			{
				$data = array(
					'lname'=>$name,'ldir'=>$dir,'limage'=>$dbdir);
			}
			$result = $this->db->update("links",$data,"lid",$lid);
			return $result;
		}
		else
		{
			return "error";
		}
	}
	
	//删除链接
	function delLink($lid)
	{
		$link = $this->db->select("select `lgid` from `links` where `lid`=$lid");
		$gid = $link[0]['lgid'];
		$this->db->sql("update `links_group` set `gnum`=`gnum`-1 where `gid`=$gid");
		$result = $this->db->delete("links","lid",$lid);
		if($result==1)
		{
			$_SESSION['dellink'] = "ok";
		}
		return $result;
	}
	
	//删除链接组
	function delGroup($gid)
	{
		$result = $this->db->sql(
			"delete from `links_group` where `gid`=$gid and `gnum`=0");
		if($result==1)
		{
			$_SESSION['delgroup'] = "ok";
		}
		return $result;
	}
}
?>