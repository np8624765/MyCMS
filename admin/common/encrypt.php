<?php
/*
 * 加密算法
 * 2014年3月3日
 */

function getEncPwd($pwd)
{
	$len = strlen($pwd);
	$md5 = "HDU".$pwd."chenzhihui";
	for($i=0;$i<$len;$i++)
	{
		$md5 = md5($md5);
	}
	$cry = crypt($pwd,"MyCMS");
	$d_val = strlen($md5) - strlen($cry);
	$result = $cry.$d_val.$md5;
	return $result; 
}

?>