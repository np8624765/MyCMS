<?php
//过滤非法字符
function check_input($value)
{
	// 去除斜杠
	if(get_magic_quotes_gpc())
	{
	  	$value = stripslashes($value);
	}
	// 如果不是数字则加引号
	if(!is_numeric($value))
	{
	  @$value = mysql_real_escape_string($value);
	}
	return preg_replace('/<script.*<\/script>/iU','',$value);
}
?>