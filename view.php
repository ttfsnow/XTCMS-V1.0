<?php
header("content-type:text/html; charset=utf-8");//输出头信息
include('./global.inc.php'); //包换公共文件
$smarty->assign('template_dir',$smarty_template_dir);//$smarty_template_dir=./templates/ config文件中
///--------------------字符串截取 取整函数---------------------------------------------------
function substr_ext($str, $start=0, $length, $charset="utf-8", $suffix="")
{
    if(function_exists("mb_substr")){
         return mb_substr($str, $start, $length, $charset).$suffix;
	}
    elseif(function_exists('iconv_substr')){
         return iconv_substr($str,$start,$length,$charset).$suffix;
    }
    $re['utf-8']  = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
    $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
    $re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
    $re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
    preg_match_all($re[$charset], $str, $match);
    $slice = join("",array_slice($match[0], $start, $length));
    return $slice.$suffix;
}
///--------------------------------------------------------------------------------------------


//////////////////////////////////////////////////////////////////////////////////////////////////////
                                      ///分类名称查询
/////////////////////////////////////////////////////////////////////////////////////////////////////
$sql_class="select *from `".$tb_prefix."newsclass` where p_id=0 order by id ASC";//查询顶级分类
$result=$db->query($sql_class);
while ($row_class=$db->fetch_array($result)){
	//将顶级分类的名字和所对应的id 赋给二维数组$sm_class
	$sm_class[]=array('id'=>$row_class[id],'name'=>$row_class[name]);
}

//////////////////////////////////////////////////////////////////////////////////////////////////////
                                      ///配置信息查询
/////////////////////////////////////////////////////////////////////////////////////////////////////
$sql_config="select *from `".$tb_prefix."config`";//查询配置信息config数据表
$result=$db->query($sql_config);
while ($row_config=$db->fetch_array($result)){
	//将配置信息的值赋给一个数组
	$sm_config[]=$row_config[values];
}



///////////////////////////////////////////////////////////////////////////////////////////////////
//                  查询GET提交的id新闻内容
////////////////////////////////////////////////////////////////////////////////////////////////////////
$query=$db->findall("".$tb_prefix."newsclass"); //查找newsclass表中信息，即所有分类名称
    while ($row=$db->fetch_array($query)) {
    	$news_class_arr[$row[id]]=$row[name]; //将分类名称赋给一个数组，数组的下表为该分类的id
	}

$sql_content="select * from `".$tb_prefix."newscontent` where id='$_GET[id]' " ;//查询文章id
$result=$db->query($sql_content);
$row_content=$db->fetch_array($result);
//将该文章名字和所对应的id 赋给二维数组$sm_class
$sm_content=array('id'=>$row_content[id],'cid'=>$news_class_arr[$row_content[cid]],'title'=>$row_content[title],'content'=>$row_content[content]
	,'date_time'=>date("Y-m-d",$row_content[date_time]),'keyword'=>$row_content[keyword]);


//////////////////////////////////////////////////////////////////////////////////////////////////////
                                      ///相关文章标题列表查询
/////////////////////////////////////////////////////////////////////////////////////////////////////

$sql_list="select `id`,`title` from `".$tb_prefix."newscontent` where cid=$row_content[cid] order by id DESC limit 6";//查询顶级分类
$result=$db->query($sql_list);
while ($row_list=$db->fetch_array($result)){
	//将顶级分类的名字和所对应的id 赋给二维数组$sm_class
 	strlen($row_list[title])<56 ? $suffix=NULL : $suffix='...';
	$sm_list[]=array('id'=>$row_list[id],'title'=>substr_ext($row_list[title], $start=0, 28, $charset="utf-8", $suffix));
}


$smarty->assign('sm_class',$sm_class);//分配数组变量到模板
$smarty->assign('sm_config',$sm_config);//分配数组变量到模板
$smarty->assign('sm_list',$sm_list);//分配数组变量到模板
$smarty->assign('sm_content',$sm_content);//分配数组变量到模板
$smarty->display("view.html");//显示模板


?>