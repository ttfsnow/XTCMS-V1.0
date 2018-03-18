<?php
include_once ('admin.global.inc.php');//包含后台公共文件
$r=$db->Get_user_shell_check($uid, $shell);//验证用户登录的session信息
$result=$db->findall(CONFIG);//使用$db对象中的方法查找数据表
while ($row=$db->fetch_array($result)){ //给查询到的结果循环复制到数组，数组下标为对应的name字段值
	$arr[$row[name]]=$row[values];
}
if (isset($_POST['update'])){ //判断是否点击更新按钮
	unset($_POST['update']);   //删除POST全局数组中的$_POST['update']的值
	foreach ($_POST as $name=>$values){ //循环执行sql语句更新数据表中的信息
    $sql="update `".CONFIG."`set `values`=\"$values\" where `name`=\"$name\"";
	$db->query($sql);
	}
 $db->Get_admin_msg("admin_main.php");//数据更新完成回到本页
}
 
if (isset($_GET['action'])){ //如果用户点击退出按钮则退出登录。
	$db->Get_user_out();
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD><TITLE>后台管理</TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<LINK href="images/private.css" 
type=text/css rel=stylesheet>
</HEAD>
<BODY>
<TABLE class=navi cellSpacing=1 align=center border=0>
  <TBODY>
  <TR>
    <TH>后台 >> 系统配置</TH></TR></TBODY></TABLE><BR>
<form action="admin_main.php" method="post">
	<table border=0 cellspacing=1 align=center class=form>
	<tr>
		<th colspan="2">系统配置</th>
	</tr>
     	  <tr>
  <td align="right">网站名称:</td>
  <td><input type="text" name="websitename" value=<?php echo $arr[websitename] ?> size="20" maxlength="40"/>  </td>
  </tr>
       	  <tr>
  <td align="right">网站地址:</td>
  <td><input type="text" name="website" value=<?php echo $arr[website] ?> size="20" maxlength="40"/>  </td>
  </tr>
      	  <tr>
  <td align="right">网站备案:</td>
  <td><input type="text" name="icp" value=<?php echo $arr[icp] ?> size="20" maxlength="40"/>  </td>
  </tr>
      	  <tr>
  <td align="right">其他说明:</td>
  <td><input type="text" name="other" value=<?php echo $arr[other] ?> size="20" maxlength="40"/>  </td>
  </tr>
    <td colspan="2" align="center" height='30'>
  <input type="submit" name="update" value=" 更新 "/>

  </td>  
    </tr>
	</table>
	 </form>
	</BODY></HTML>
