<?php
class Base_setting extends My_model
{
	function __construct()
	{
		parent::__construct();
	}
	
	//更新基本配置
	function updateInfo($name,$add,$key,$des,$notice,$footer,$session,$phone,$email)
	{
		$time = date('Y-m-d H:i:s',time());
		$this->db->update(
			"base_setting",array("bcontent"=>$name,"btime"=>$time),"bname","网站名称");
		$this->db->update(
			"base_setting",array("bcontent"=>$add,"btime"=>$time),"bname","网站地址");
		$this->db->update(
			"base_setting",array("bcontent"=>$key,"btime"=>$time),"bname","关键词设置");
		$this->db->update(
			"base_setting",array("bcontent"=>$des,"btime"=>$time),"bname","网站描述设置");
		$this->db->update(
			"base_setting",array("bcontent"=>$notice,"btime"=>$time),"bname","网站滚动通知");
		$this->db->update(
			"base_setting",array("bcontent"=>$footer,"btime"=>$time),"bname","网站页脚");
		$this->db->update(
			"base_setting",array("bcontent"=>$session,"btime"=>$time),"bname","session失效时间");
		$this->db->update(
			"base_setting",array("bcontent"=>$phone,"btime"=>$time),"bname","管理员联系电话");	
		$this->db->update(
			"base_setting",array("bcontent"=>$email,"btime"=>$time),"bname","管理员邮箱");
			
		return true;
	}
	
	//获得基本配置
	function getInfo()
	{
		$re = $this->db->select("select `bcontent` from `base_setting`");
		return $re;
	}
	
	//获得超时时间
	function getOvertime()
	{
		$re = $this->db->select(
			"select `bcontent` from `base_setting` where `bname`='session失效时间'");
		$limit = $re[0]['bcontent'];
		if($limit)
		{
			$_SESSION['limit'] = $limit*60;
		}
		else
		{
			$_SESSION['limit'] = 120*60; //默认30分钟
		}	
	}
	
	//获得某一项基本配置
	function getBaseSetting($bname)
	{
		$result = $this->db->select(
			"select `bcontent` from `base_setting` where `bname`='$bname'");
		return $result;
	}
}
?>