<?php
include_once ('admin.global.inc.php');//包换公共文件
$r=$db->Get_user_shell_check($uid, $shell);//验证用户session信息
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD><TITLE>后台管理</TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<LINK href="images/private.css" type=text/css rel=stylesheet>
</HEAD>
<BODY>
<!-- 此处是添加分类 HTML部分开始-->
<TABLE class=navi cellSpacing=1 align=center border=0>
  <TBODY>
  <TR>
    <TH>后台 >> 新闻分类</TH></TR></TBODY></TABLE><BR>
	<table border=0 cellspacing=1 align=center class=form>
	<tr>
		<th colspan="2">添加分类</th>
	</tr>
	<form action="" method="post" >
    <tr>
    <td colspan="2" align="center" height='30'>

  <select name="p_id">   <!-- 列表的名称为P_ID -->
    <option value="0">添加分类</option> <!-- 不做选择的话，默认项为顶级分类，值为0 -->
<?php
    //无限极分类按照bpath字段进行排序即可得到正常层级关系
    $query=mysql_query("SELECT id, name, p_id, path, concat( path, '-', id ) AS bpath
    FROM ".$tb_prefix."newsclass
    ORDER BY bpath
    ");
    while ($row=mysql_fetch_array($query)) //循环显示查询出来的分类名称
    {
      $path_arr[$row[id]]=$row[path];//将字段path的值称赋给一个数组，下标为该分类的id值
   
      echo "<option value=\"$row[id]\">"; //选择项的值为该条记录的id值
      //循环输出每一个分类前面的空格，空格数量由bpath中的数字个数决定；
      //这样字段的层级关系就明显了
    
         for ($i=0;$i<count(explode('-', $row[bpath]));$i++) 
         {
            echo '&nbsp;&nbsp;&nbsp;';
         }
      echo "┗".$row[name];
	  echo  "</option>";   
	 
   } 
?>
  </select>
    <input type="text" name="name" value="" /> <!-- 此处是填写分类名称的文本表单 -->
    <input type="submit" name="into_class" value="添加分类"/> <!-- 此处是提交表单按钮name="into_class"哦 -->
    </td>
    </form>
    </tr>
	</table>
<br>
<!-- 此处是添加分类 HTML部分结束-->

<!-- -----------------------------------------华丽分割线----------------------------------------------  -->


<!-- 此处是删除分类 HTML部分开始-->
<table border=0 cellspacing=1 align=center class=form>
	<tr>
		<th colspan="2">删除分类</th>
	</tr>
	<form action="" method="post" >
    <tr>
    <td colspan="2" align="center" height='30'>

  <select name="p_id">   <!-- 列表的名称为P_ID -->
    <option value="0">删除分类</option> <!-- 不做选择的话，默认删除id=0 的记录，即什么也不删除-->
    
<?php
    //无限极分类按照bpath字段进行排序即可得到正常层级关系
    $query=mysql_query("SELECT id, name, p_id, path, concat( path, '-', id ) AS bpath
    FROM ".$tb_prefix."newsclass
    ORDER BY bpath
    ");
    while ($row=mysql_fetch_array($query)) //循环显示查询出来的分类名称
    {
      $path_arr[$row[id]]=$row[path];//将字段path的值称赋给一个数组，下标为该分类的id值
   
      echo "<option value=\"$row[id]\">"; //选择项的值为该条记录的id值
      //循环输出每一个分类前面的空格，空格数量由bpath中的数字个数决定；
      //这样字段的层级关系就明显了
    
         for ($i=0;$i<count(explode('-', $row[bpath]));$i++) 
         {
            echo '&nbsp;&nbsp;&nbsp;';
         }
      echo "┗".$row[name];
	  echo  "</option>";   
	 
   } 
?>
 </select>
     &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
    <input type="submit" name="del_class" value="删除分类"/> <!-- 此处是提交表单按钮name="del_class"哦 -->
    </td>
    </form>
    </tr>
	</table>
<br>

<!-- 此处是删除分类 HTML部分结束-->

<!-- --------------------------------华丽分割线-------------------------------------------------  -->

<!-- 此处是更新分类 HTML部分开始-->
<table border=0 cellspacing=1 align=center class=form>
	<tr>
<th colspan="2">更新分类</th>
	</tr>
	<form action="" method="post" >
    <tr>
    <td colspan="2" align="center" height='30'>

  <select name="p_id">   <!-- 列表的名称为P_ID -->
    <option value="0">更新分类</option> <!-- 不做选择的话，默认更新id=0的记录，即什么也不更新-->
    
<?php
    //无限极分类按照bpath字段进行排序即可得到正常层级关系
    $query=mysql_query("SELECT id, name, p_id, path, concat( path, '-', id ) AS bpath
    FROM ".$tb_prefix."newsclass
    ORDER BY bpath
    ");
    while ($row=mysql_fetch_array($query)) //循环显示查询出来的分类名称
    {
      $path_arr[$row[id]]=$row[path];//将字段path的值称赋给一个数组，下标为该分类的id值
   
      echo "<option value=\"$row[id]\">"; //选择项的值为该条记录的id值
      //循环输出每一个分类前面的空格，空格数量由bpath中的数字个数决定；
      //这样字段的层级关系就明显了
    
         for ($i=0;$i<count(explode('-', $row[bpath]));$i++) 
         {
            echo '&nbsp;&nbsp;&nbsp;';
         }
      echo "┗".$row[name];
	  echo  "</option>";   
	 
   } 
?>
 </select>
    <input type="text" name="name" value="" /> <!-- 此处是填写更新的分类名称的文本表单 -->
    <input type="submit" name="update_class" value="更新分类"/> <!-- 此处是提交表单按钮name="update_class"哦 -->
    </td>
    </form>
 </tr>
	</table>
 <!-- 此处是更新分类 HTML部分结束-->

 </BODY>
 </HTML>
	
<?php  
/////////////////////////////////////////////////////////////////////////////////////////
                                  //添加分类
/////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST[into_class])&&$_POST[name]!=""){  //判断是否提交表单数据
$f_path=$_POST[p_id];       //把该条记录提交的id的值赋给$f_path
if ($_POST[p_id]==0){   //判断如果提交的$_POST[p_id]值为0，及默认选项，它value值为0
	//插入一条记录，其pid为0，path也为0，及顶级分类
	mysql_query("INSERT INTO `$db_name`.`".$tb_prefix."newsclass` (`id`, `p_id`, `name`,`path`) 
            VALUES (NULL, '$_POST[p_id]', '$_POST[name]', '$_POST[p_id]') ");  
	$db->Get_admin_msg("admin_news_class.php","已经成功添加分类");
}
//如果提交的$_POST[p_id]值不为0
//插入一条记录，其pid为本条记录的id，即本条记录是其父类，path为$path_arr[$f_path]-$_POST[p_id]，即
//path为本条记录的path连接一个‘-’再连接本条记录的id，符合无限极分类的规则
else{
     mysql_query("INSERT INTO `$db_name`.`".$tb_prefix."newsclass` (`id`, `p_id`, `name`,`path`)
            VALUES (NULL, '$_POST[p_id]', '$_POST[name]', '$path_arr[$f_path]-$_POST[p_id]') ");
     $db->Get_admin_msg("admin_news_class.php","已经成功添加分类");
     }
}
/////////////////////////////////////////////////////////////////////////////////////////
                                  //删除分类
/////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST[del_class])&&$_POST[p_id]!="0"){
	$db->query("DELETE FROM `".$tb_prefix."newsclass` WHERE `id` = '$_POST[p_id]' LIMIT 1;");
	$db->Get_admin_msg("admin_news_class.php","删除成功");
}
/////////////////////////////////////////////////////////////////////////////////////////
                                  //更新分类
/////////////////////////////////////////////////////////////////////////////////////////
	
if(isset($_POST[update_class])&&$_POST[name]!=""){
	$db->query("update `".$tb_prefix."newsclass` set `name`='$_POST[name]' WHERE `id` = '$_POST[p_id]' LIMIT 1;");
	$db->Get_admin_msg("admin_news_class.php","更新成功");
}

?>
	
	
	


