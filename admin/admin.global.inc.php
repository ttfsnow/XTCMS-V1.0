<?php
session_start(); //启动session会话
include_once ("common/mysql.class.php"); //mysql类
include_once ("../config/config.php"); //配置参数
include_once ("common/page.class.php"); //后台专用分页类
include_once ("common/user.mysql.class.php"); //用户登录功能函数和数据库操作类

$db = new action($db_host, $db_user, $db_pass, $db_name, CON_FLAG, "utf8"); //数据库操作类.

$uid = $_SESSION[uid];  //为session全局数组$_SESSION[uid]起别名$uid；用来验证用户权限
$shell = $_SESSION[shell];//为session全局数组$_SESSION[shell]起别名$uid；用来综合验证用户权限
?>