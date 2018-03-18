<?php 
$db_host="localhost";
$db_user="root";
$db_pass="root";
$db_name="xtcms";
$tb_prefix="xt_";
$admin="admin";
$adminpass="admin";

//========smarty配置信息========
$smarty_template_dir="./templates/";
$smarty_compile_dir="./templates_c/";
$smarty_config_dir="./config/";
$smarty_cache_dir="./cache/";
$smarty_caching=false;
$smarty_delimiter=explode("|","{|}");
//========自定义常量信息========
define(ADMIN, $tb_prefix.'admin');
define(NEWSCLASS, $tb_prefix.'newsclass');
define(NEWSCONTENT, $tb_prefix.'newscontent');
define(CONFIG, $tb_prefix.'config');
?> 