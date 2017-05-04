<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理中心TOP</title>
<script language=javascript>
function logout(){
	if (confirm("你要退出管理中心吗?")) {
		top.location = "index.php?method=logout";	
	}
	return false;
}
</script>
<base target="main">
<link href="views/style/skin.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0">
<table width="100%" height="64" border="0" cellpadding="0" cellspacing="0" class="admin_topbg">
  <tr>
    <td width="61%" height="64"><img src="views/images/logo.gif" width="262" height="64"></td>
    <td width="39%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="74%" height="38"  align="right" class="admin_txt">管理员:<?php echo $name;?>&nbsp;&nbsp;&nbsp;&nbsp;上次登录时间:<?php echo $last;?></td>
          <td width="22%"><a href="#" target="_self" onClick="logout();"><img src="views/images/out.gif" alt="退出" width="46" height="20" border="0"></a></td>
          <td width="4%">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="3">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
