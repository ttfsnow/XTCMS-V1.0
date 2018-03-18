<?php
include_once ('admin.global.inc.php');//包换公共文件
$r=$db->Get_user_shell_check($uid, $shell);//检测用户session信息

if(isset($_POST[update_news])){  
	//如果提交表单则更新本条信息
	$updatesql="UPDATE `$db_name`.`".$tb_prefix."newscontent` SET `title` = '$_POST[title]',
              `author` = '$_POST[author]',
              `content` = '$_POST[content]' WHERE `".$tb_prefix."newscontent`.`id` =$_GET[id] LIMIT 1";
     $db->query($updatesql);
	$db->Get_admin_msg("admin_news_list.php","修改成功");
}

if(!empty($_GET[id])){
	//如果点击修改，则查询出这条新闻的信息
	$sql="select * from ".$tb_prefix."newscontent where id ='$_GET[id]'";
    $query=mysql_query($sql);
    $row_news=mysql_fetch_array($query);
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
    <TH>后台 >> 编辑新闻</TH></TR></TBODY></TABLE><BR>

	<table border=0 cellspacing=1 align=center class=form>
	<tr>
		<th colspan="2">编辑新闻</th>
	</tr>
	<form action="" method="post" onsubmit="syncTextarea()" >
    <tr>
   <td width=80>新闻分类</td>
  <td>
  <select name="cid">
    <option value="0">添加大类</option>
    <?php
     //无限极分类按照bpath字段进行排序即可得到正常层级关系
    $query=mysql_query("SELECT id, name, p_id, path, concat( path, '-', id ) AS bpath
    FROM ".$tb_prefix."newsclass
    ORDER BY bpath
    ");
    while ($row=mysql_fetch_array($query)) //循环显示查询出来的分类名称
    {  
      //每查询一条分类信息，就用该条新闻信息中cid（所属分类id）进行比较，如果该条信息所属分类id和遍历出来的分类id即$row[id]
      //相等（有且只有一个相等），则该条分类被选中，否则都为null
      $selected=$row_news[cid]==$row[id] ? "selected" : NULL;
      echo "<option value=\"$row[id]\"  $selected>"; //选择项的值为该条记录的id值
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
  <input type="text" name="title" size=50 value="<?php echo $row_news[title]?>">
  </select>
    </td>
    </tr>
       <tr>
   <td width=80>新闻作者</td>
  <td>
  <input type="text" name="author" size=20 value="<?php echo $row_news[author]?>">
    </td>
    </tr>
       <tr>
   <td width=80>新闻关键字</td>
  <td>
  <input type="text" name="keyword" size=80 value="<?php echo $row_news[keyword]?>">
    </td>
    </tr>
       <tr>
   <td width=80>新闻内容</td>
  <td>
  <textarea id="edited" name="content" style="width:95%;height:280px;"><?php echo $row_news[content]?></textarea>
	<script language="javascript" type="text/javascript" src="edit/whizzywig.js"></script>
	<script type="text/javascript">buttonPath = "edit/images/";makeWhizzyWig("edited", "all");</script>
    </td>
    </tr>
    <tr>
   <td width=80></td>
  <td>
  <input type="submit" name="update_news" style="height:30px;" value="修改新闻">
    </td>
    </tr>
     </form>
	</table>
<br>

	</BODY></HTML>
