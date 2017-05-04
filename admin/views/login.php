<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>登录界面</title>
<link href="views/style/skin.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-color: #1b3142;
}
-->
</style>
<script type="text/javascript" src="views/js/jquery-1.6.4.js"></script>
<script type="text/javascript" src="views/js/login.js"></script>
</head>
<body>
<table width="100%" height="166" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="42" valign="top"><table width="100%" height="110" border="0" cellpadding="0" cellspacing="0" class="login_top_bg">
      <tr>
        <td width="1%" height="21">&nbsp;</td>
        <td height="42">&nbsp;</td>
        <td width="17%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td valign="top"><table width="100%" height="532" border="0" cellpadding="0" cellspacing="0" class="login_bg">
      <tr>
        <td width="49%" align="right"><table width="91%" height="532" border="0" cellpadding="0" cellspacing="0" class="login_bg2">
            <tr>
              <td height="138" valign="top"><table width="89%" height="427" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td height="149">&nbsp;</td>
                </tr>
                <tr>
                  <td height="80" align="right" valign="top"><img src="views/images/logo.png" width="279" height="68"></td>
                </tr>
                <tr>
                  <td height="198" align="right" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="55%">&nbsp;</td>
                      <td height="25" colspan="2" class="left_txt"><p>① 功能齐全：内置内容管理系统常用功能</p></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td height="25" colspan="2" class="left_txt"><p>② 对接便捷：与静态页面结合简单，方便</p></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td height="25" colspan="2" class="left_txt"><p>③ 扩展性好：轻量级结构，便于自定义扩展</p></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td height="25" colspan="2" class="left_txt"><p>④ 多平台优势：适合在多种平台下运行</p></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                  </table></td>
                </tr>
              </table></td>
            </tr>
            
        </table></td>
        <td width="1%" >&nbsp;</td>
        <td width="50%" valign="bottom"><table width="100%" height="59" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="4%">&nbsp;</td>
              <td width="96%" height="38"><span class="login_txt_bt">登陆后台管理</span></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td height="21"><table cellSpacing="0" cellPadding="0" width="100%" border="0" id="table211" height="328">
                  <tr>
                    <td height="164" colspan="2" align="middle"><form name="myform" action="index.html" method="post">
                        <table cellSpacing="0" cellPadding="0" width="100%" border="0" height="143" id="table212">
                          <tr>
                            <td width="7%" height="38" class="top_hui_text"><span class="login_txt">管理员：</span></td>
                            <td height="38" colspan="2" class="top_hui_text"><input type="text" name="username" class="editbox4" size="20" id="username">                            </td>
                          </tr>
                          <tr>
                            <td width="7%" height="35" class="top_hui_text"><span class="login_txt">密&nbsp;&nbsp;&nbsp;&nbsp;码：</span></td>
                            <td height="35" colspan="2" class="top_hui_text"><input class="editbox4" type="password" size="20" name="password" id="password">
                              <img src="views/images/luck.gif" width="19" height="18"> </td>
                          </tr>
                          <tr>
                            <td width="7%" height="35" ><span class="login_txt">验证码：</span></td>
                            <td height="35" class="top_hui_text"><input name="code" id="code" type="text" size=6 /></td>
                            <td><img class="code" src="common/identifying_code.php" title="看不清楚?请点击刷新" onClick="this.src=this.src+'?'+Math.random();" style="cursor:pointer;"></td>
                          </tr>
                          <tr>
                            <td height="35" >&nbsp;</td>
                   		    <td width="2%" height="35" ><input name="submit" type="button" id="submit" value="登 陆"> </td>
                            <td class="top_hui_text"><input name="cs" type="reset" value="重 置"></td>
                          </tr>
                          <tr>
                            <td  height="35" colspan="3"><p class="error"></p></td>
                          </tr>
                        </table>
                        <br>
                    </form></td>
                  </tr>
                  <tr>
                    <td width="433" height="164" align="right" valign="bottom"><img src="views/images/login-wel.gif" width="242" height="138"></td>
                    <td width="57" align="right" valign="bottom">&nbsp;</td>
                  </tr>
              </table></td>
            </tr>
          </table>
          </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="20"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="login-buttom-bg">
      <tr height="100" >
        <td align="center">
        	<span class="login-buttom-txt">
            	Copyright © 2014 HangZhou Dianzi University Design by Chen Zhihui 
                <a href="<?php echo $url;?>" style="color:#CCC;">&nbsp;返回首页</a>
             </span>
        </td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>