<?php
include_once ('admin.global.inc.php');//包换公共类文件
$r=$db->Get_user_shell_check($uid, $shell);//判断用户session信息

//判断如果提交表单，并且标题和选择的分类id都不为0（新闻分类id不可能为0，因为从1开始自增）则进行添加新闻
if(isset($_POST[into_news])&&$_POST[title]!=""&&$_POST[c_id]!="0"){
     $db->query("INSERT INTO `xt_newscontent` (`id`, `cid`, `title`, `author`, `date_time`,`keyword`,`content`) " .
     		"VALUES (NULL, '$_POST[c_id]', '$_POST[title]', '$_POST[author]', '".mktime()."','$_POST[keywrod]','$_POST[content]')");
  
	$db->Get_admin_msg("admin_news_add.php","添加成功");
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
    <TH>后台 >> 添加新闻</TH></TR></TBODY></TABLE><BR>

	<table border=0 cellspacing=1 align=center class=form>
	<tr>
		<th colspan="2">添加新闻</th>
	</tr>
	<!-- onsubmit="syncTextarea()用于提交js编辑器的内容 -->
	<form action="" method="post" onSubmit="syncTextarea()" > 
    <tr>
   <td width=80>新闻分类</td>
  <td>
    <select name="c_id">   <!--c_id为新闻所属分类的id  -->
    <option value="0">选择分类</option> <!-- 不做选择的话，默认项为顶级分类，值为0 -->
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
    </td></tr>
   <tr>
   <td width=80>新闻标题</td>
  <td>
  <input type="text" name="title" size=50>
  </select>
    </td>
    </tr>
       <tr>
   <td width=80>新闻作者</td>
  <td>
  <input type="text" name="author" size=20>
    </td>
    </tr>
       <tr>
   <td width=80>新闻关键字</td>
  <td>
  <input type="text" name="keywrod" size=80>
    </td>
    </tr>
       <tr>
   <td width=80>新闻内容</td>
  <td>
  <textarea id="edited" name="content" style="width:95%;height:280px;"></textarea>
   <!-- js在线编辑器调用开始 -->
   <script language="javascript" type="text/javascript" src="edit/whizzywig.js"></script>
   <script type="text/javascript">buttonPath = "edit/images/";makeWhizzyWig("edited", "all");</script>
      <!-- js在线编辑器调用结束 -->
    </td>
    </tr>
    <tr>
   <td width=80></td>
  <td>
  <input type="submit" name="into_news" style="height:30px;" value="添加新闻">
    </td>
    </tr>
     </form>
	</table>
<br>

	</BODY></HTML>
