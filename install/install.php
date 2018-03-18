<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="common.css" rel="stylesheet" type="text/css" />
<title>XTCMS1.0安装</title>
</head>
<body>
 
<form action="install.php" method="post">
 <TABLE class=navi cellSpacing=1 align=center border=0>
  <TBODY>
  <TR>
    <TH>XTCMS1.0安装程序 >>参数配置</TH></TR></TBODY></TABLE><BR>
<form action="admin_main.php" method="post">
	<table border=0 cellspacing=1 align=center class=form>
	<tr>
		<th colspan="2">配置参数</th>
	</tr>
     	  <tr>
  <td align="right">主机地址:</td>
  <td><input type="text" name="db_host"  value="localhost"  size="20" maxlength="40"/>  </td>
  </tr>
       	  <tr>
  <td align="right">数据库用户名:</td>
  <td><input type="text" name="db_user"  value="root"  size="20" maxlength="40"/>  </td>
  </tr>
  <tr>
      	  <tr>
  <td align="right">数据库密码:</td>
  <td><input type="password" name="db_pass" size="20" maxlength="40"/>  </td>
  </tr>
      	  <tr>
  <td align="right">数据库名称:</td>
  <td><input type="text" name="db_name"  value="xtcms" size="20" maxlength="40"/>  </td>
  </tr>
   	  <tr>
  <td align="right">数据表前缀:</td>
  <td><input type="text" name="tb_prefix"   value="xt_" size="20" maxlength="40"/>  </td>
  </tr>
    <tr>
  <td align="right">管理员用户名:</td>
  <td><input type="text" name="admin"   value="admin" size="20" maxlength="40"/>  </td>
  </tr>
    <tr>
  <td align="right">管理员密码:</td>
  <td><input type="password" name="adminpass"     size="20" maxlength="40"/>  </td>
  </tr>
    <td colspan="2" align="center" height='30'>
  <input type="submit" name="install" value=" 安装 "/>

  </td>  
    </tr>
	</table></form>
</body>
</html>

<?php    
 //创建配置文件并写入配置信息	
$filepath="../config/config.php";
if (!file_exists($filepath)){//判断文件是否存在，如果不存在则创建该文件
	touch($filepath);
}
elseif(!is_writable($filepath)){  //判定文件是否可写，如果不可写，程序直接退出
 	echo "文件不可写！";
 	exit();
 }
 if (isset($_POST[install])){   //如果提交配置信息则将提交的配置信息写入config.php文件中
 $config="<?php ";
 $config.="\n";
 $config.='$db_host="'.$_POST[db_host].'";';
 $config.="\n";
 $config.='$db_user="'.$_POST[db_user].'";';
 $config.="\n";
 $config.='$db_pass="'.$_POST[db_pass].'";';
 $config.="\n";
 $config.='$db_name="'.$_POST[db_name].'";';
 $config.="\n";
 $config.='$tb_prefix="'.$_POST[tb_prefix].'";';
 $config.="\n";
 $config.='$admin="'.$_POST[admin].'";';
 $config.="\n";
 $config.='$adminpass="'.$_POST[adminpass].'";';
 $config.="\n";

 file_put_contents($filepath, $config);  //将提交的配置信息写入config.php文件中
  
 }else {
 	exit();
 }
 ///////////////////////////////////////////////////////////////
             //连接数据库创建基础数据表并写入管理员账号密码信息
/////////////////////////////////////////////////////////////////
include_once "$filepath"; //包含刚才写入的配置文件信息
//使用mysqli进行数据库链接
$mysqli=new mysqli("$db_host","$db_user","$db_pass");
//判断连接是否成功，如果不成功则则输出错误信息并退出程序
if (mysqli_connect_errno()){
	echo "数据库链接失败".mysqli_connect_error();
	$mysqli=null;
	exit();
}
$mysqli->query("create database `$db_name`"); //使用mysqli对象创建数据库
$mysqli->select_db($db_name);  //选择数据库

//创建sql语句，将sql语句赋予一个query数组
$query[]="CREATE TABLE `".$tb_prefix."admin` (
`uid` INT( 3 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`username` VARCHAR( 20 ) NOT NULL ,
`password` VARCHAR( 40 ) NOT NULL 
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;";
$query[]="INSERT INTO `".$tb_prefix."admin` (
`uid` ,
`username` ,
`password` 
)
VALUES (
NULL , '".$admin."', MD5('$adminpass')
);";
$query[]="CREATE TABLE `".$tb_prefix."config` (
  `name` varchar(20) NOT NULL,
  `values` varchar(100) NOT NULL,
  PRIMARY KEY  (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
 ";
$query[]="CREATE TABLE `".$tb_prefix."newsclass` (
`id` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`f_id` INT( 10 ) NOT NULL ,
`cname` VARCHAR( 20 ) NOT NULL 
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;";

$query[]="CREATE TABLE `".$tb_prefix."newscontent` (
  `id` int(11) NOT NULL auto_increment,
  `cid` int(11) NOT NULL,
  `title` varchar(50)  NOT NULL,
  `author` varchar(25)   NOT NULL,
  `date_time` int(10) NOT NULL,
  `keywrod` varchar(100)  NOT NULL,
  `content` text   NOT NULL, 
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  CHARACTER SET utf8 COLLATE utf8_general_ci;";

//循环执行数组中的sql语句，创建数据表
foreach ($query as $val){
	$mysqli->query($val);
}
////////////////////////////////////////////////////////////
   //向配置文件config.php中写入smarty模板配置信息
   //写入自定义常量信息，用作统一数据表名，方便后台调用
/////////////////////////////////////////////////////////////
//================
$smarty="\n";
$smarty.="//========smarty配置信息========";
$smarty.="\n";
$smarty.='$smarty_template_dir="'.'./templates/'.'";';
$smarty.="\n";
$smarty.='$smarty_compile_dir="'.'./templates_c/'.'";';
$smarty.="\n";
$smarty.='$smarty_config_dir="'.'./config/'.'";';
$smarty.="\n";
$smarty.='$smarty_cache_dir="'.'./cache/'.'";';
$smarty.="\n";
$smarty.='$smarty_caching='.'false'.';';
$smarty.="\n";
$smarty.='$smarty_delimiter='.'explode("|","{|}")'.';';
$smarty.="\n";
$smarty.="//========自定义常量信息========";
$smarty.="\n";
$smarty.='define(ADMIN, $tb_prefix.\'admin\');';
$smarty.="\n";
$smarty.='define(NEWSCLASS, $tb_prefix.\'newsclass\');';
$smarty.="\n";
$smarty.='define(NEWSCONTENT, $tb_prefix.\'newscontent\');';
$smarty.="\n";
$smarty.='define(CONFIG, $tb_prefix.\'config\');';
$smarty.="\n";
$smarty.="?> ";
$handle=fopen($filepath, "a+");//以读写方式打开配置文件，并将文件指针指向文件尾部
fwrite($handle, $smarty);
fclose($handle);

//重命名安装文件，防止再次重新安装
//rename("install.php", "install.lock");
echo "安装完成";
//安装完成后跳转到指定页面
//echo"<script>location.href='./index.php'</script>";
?>

