<?php
//该页面为用户登录表单页面
include_once('admin.global.inc.php'); //包含后台全局文件
//使用$db对象中的方法将用户登录表单中的提交的用户名和密码 赋值给用户session值
//验证成功则跳转到后台控制主页面main.php
 if(!empty($_POST[username])&& !empty($_POST[password]))
 $db->Get_user_login($_POST[username],$_POST[password]);
?>
<html><head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
<title>后台管理用户登录</title>
<link rel='stylesheet' type='text/css' href='images/private.css'>
</head>
<body>
	<br><br><br>
	

	  <form action="" method="post">
	<table border=0 cellspacing=1 align=center class=form>
	<tr>
		<th colspan="2" >用户登录</th>
	</tr>
     	  <tr>
<td align="right">登录用户:</td>
  <td><input type="text" name="username" value="" size="20" maxlength="40"/>  </td>
  </tr>
       	  <tr>
  <td align="right">登录密码:</td>
  <td><input type="password" name="password" value="" size="20" maxlength="40"/>  </td>
  </tr>
  
  <tr>
    <td colspan="2" align="center" height='30'>
  <input type="submit" name="update" value=" 登录 "/>

  </td>  </form>
    </tr>
    
	</table>
	<br> 
	<font color="white"><center>欢迎使用讯通网络个人微博系统--XTCMS V1.0 讯通网络淘宝旗舰店<a href="http://shop72927761.taobao.com">http://shop72927761.taobao.com</a></center></font>
   <font color="white"><center></center></font>
</body></html>






