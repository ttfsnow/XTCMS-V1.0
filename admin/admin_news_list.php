<?php
include_once ('admin.global.inc.php');//包含公共文件
$r=$db->Get_user_shell_check($uid, $shell);//检测用户session信息
$query=$db->findall("".$tb_prefix."newsclass"); //查找newsclass表中信息，即所有分类名称
    while ($row=$db->fetch_array($query)) {
    	$news_class_arr[$row[id]]=$row[name]; //将分类名称赋给一个数组，数组的下表为该分类的id
	}

if(isset($_GET[del])){ //判断get传参del是否提交$_GET[del]的值为该条新闻记录的id值
	//根据传过来的id值删除该条新闻记录
	mysql_query("DELETE FROM `".$tb_prefix."newscontent` WHERE `id` = '$_GET[del]' LIMIT 1;");
	$db->Get_admin_msg("admin_news_list.php","删除成功");
}


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD><TITLE>后台管理</TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<LINK href="images/private.css" type=text/css rel=stylesheet>
</HEAD>
<BODY>
<TABLE class=navi cellSpacing=1 align=center border=0>
  <TBODY>
  <TR>
    <TH>后台 >> 新闻管理</TH></TR></TBODY></TABLE><BR>

	<table border=0 cellspacing=1 align=center class=form>
	<tr>
		<th width='100'>新闻分类</th><th>新闻标题</th><th width='100'>作者</th><th width='100'>日期</th><th width='100'>操作</th>
	</tr>
	<tr>
	<?php
    $result = mysql_query("select * from ".$tb_prefix."newscontent"); //查询newscontent表中所有内容
    $total = mysql_num_rows($result); //返回newscontent表中记录的条数
    pageft($total, 20);  //调用分页函数，确定每页显示记录的条数
    if ($firstcount < 0) $firstcount = 0;//去除id为负数的情况，及未满分页数则以0补
   $query = $db->findall("".$tb_prefix."newscontent limit  $firstcount, $displaypg");//动态显示每页规定的记录条数
   while ($row = $db->fetch_array($query)) { //循环显示出每条新闻记录的信息，包括所属的分类名称，标题，作者，时间等内容
   ?>
		<td><?php echo $news_class_arr[$row[cid]]//cid为该记录所属的分类id?></td><td><?php echo $row[title]?></td><td><?php echo $row[author]?></td>
		<td><?php echo date("Y-m-d H:i",$row[date_time])?></td><td><a href='?del=<?php echo $row[id]?>'>删除</a> / <a href='admin_news_edit.php?id=<?php echo $row[id]?>'>修改</a></td>

	</tr>
	<?php
} //while循环结束
?>
	<tr>
		<th colspan="5"><?php echo $pagenav; // 分页函数显示部分调用 ?></th> 
	</tr>
	</table>
<br>
	</BODY></HTML>


