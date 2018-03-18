<?php
include_once ('./config/config.php');
include_once ('./common/smarty/Smarty.class.php');
include_once ('./common/mysql.class.php'); 
include_once ('./common/action.mysql.class.php');
include_once ('./common/page.class.php');
//实例化了对象，包括数据库操作类和提示信息函数，只要包含这个文件，就可以直接使用$dbZ这个对象对数据库进行操作。
$db = new action($db_host, $db_user, $db_pass, $db_name, CON_FLAG, "utf8");

//********创建smarty对象并配置信息**********
$smarty = new smarty();
$smarty->template_dir	= $smarty_template_dir;
$smarty->compile_dir	= $smarty_compile_dir;
$smarty->config_dir		= $smarty_config_dir;
$smarty->cache_dir		= $smarty_cache_dir;
$smarty->caching		= $smarty_caching;
$smarty->left_delimiter = $smarty_delimiter[0];
$smarty->right_delimiter= $smarty_delimiter[1];

?>