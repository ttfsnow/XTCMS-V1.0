<?php
class action extends mysql {

	/**
	 * 用户权限判断($uid, $shell, $m_id)
	 */
   
	public function Get_user_shell($uid, $shell) {//传入用户session信息
		//判断数据表中的字段uid是否等于session[uid]的值及是否存在这个用户名，并生成这条结果集赋给$query
		$query = $this->select(ADMIN, '*', '`uid` = \'' . $uid . '\'');//用户表名：admin
		//判断是否存在这条结果集
		$us = is_array($row = $this->fetch_array($query));
		//如果存在符合用户名的记录则判断$shell == md5($row[username] . $row[password] . "TKBK")  
		//不等于则$shell为false等于则为真
		$shell = $us ? $shell == md5($row[username] . $row[password] . "TKBK") : FALSE;
		//如果验证成功则返回$row数组（该条记录）否则返回null
		return $shell ? $row : NULL;
	} //end shell

	public function Get_user_shell_check($uid, $shell, $m_id = 9) { //传入用户session信息
                //$uid = $_SESSION[uid]; $shell = $_SESSION[shell];全局包含文件已经赋值
		if ($row=$this->Get_user_shell($uid, $shell)) { //判断用户的session信息是否验证成功
			if ($row[m_id] <= $m_id) {  //再判断用户权限字段，是否有这个权限
				return $row;            //如果有权限则返回该
			} else {
				echo "你无权限操作！";
				exit ();
			} //end m_id
		} else { //如果用户session信息验证失败，则提示 用户先登录，并跳转到用户登录页面
		  $this->Get_admin_msg('index.php','请先登陆');
		}
	} //end shell
	//========================================


	/**
	 * 用户登陆超时时间(秒)
	 */
	public function Get_user_ontime($long = '3600') { 
		//指定用户登录超时时间，即在该用户多长时间未进行任何操作后自动删除该用户
		//如果该用户有新的操作，即重新计时
		$new_time = mktime();
		$onlinetime = $_SESSION[ontime];
		echo $new_time - $onlinetime;
		if ($new_time - $onlinetime > $long) {
			echo "登录超时";
			session_destroy();
			exit ();
		} else {
			$_SESSION[ontime] = mktime();
		}
	}

	/**
	 * 用户登陆
	 */
	public function Get_user_login($username, $password) { //获取登陆表单提交的用户名和密码
		$username = str_replace(" ", "", $username);       //去除输入用户输入的空格
		//查询该用户信息并将查询记录返回结果集$query
		$query = $this->select(ADMIN, '*', '`username` = \'' . $username . '\'');//查询用户数据表，注意表名称和数据库一直
		$us = is_array($row = $this->fetch_array($query));//判断该用户的记录是否存在，返回bool值us
		$ps = $us ? md5($password) == $row[password] : FALSE;//如果us为真则判断密码是否和数据库中密码一致，返回bool值ps
		if ($ps) {       //如果用户名和密码验证正确，则给$session全局数组赋值
			$_SESSION[uid] = $row[uid];
			$_SESSION[shell] = md5($row[username] . $row[password] . "TKBK");
			$_SESSION[ontime] = mktime();
			$this->Get_admin_msg('main.php','登陆成功！');  //并提示登录成功，跳转到指定页面（用户后台主页面）
		} else {
			$this->Get_admin_msg('index.php','密码或用户错误！'); //否则验证失败则提示错误信息，并返回指定页面（用户登录页面）
			session_destroy();                                    //销毁所有session的值
		}
	}
	 /**
	  * 用户退出登陆
	  */
	public function Get_user_out() {    //用户退出的方法，直接销毁session值
		session_destroy();
		$this->Get_admin_msg('index.php','退出成功！');
	}

   /**
    * 后台通用信息提示方法，可以提示并跳转到指定url页面
    */
	public function Get_admin_msg($url, $show = '操作已成功！') {//提示并跳转到指定url页面
		$msg = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml"><head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<link rel="stylesheet" href="css/common.css" type="text/css" />
				<meta http-equiv="refresh" content="2; URL=' . $url . '" />
				<title>管理区域</title>
				</head>
				<body>
				<div id="man_zone">
				  <table width="30%" border="1" align="center"  cellpadding="3" cellspacing="0" class="table" style="margin-top:100px;">
				    <tr>
				      <th align="center" style="background:#cef">信息提示</th>
				    </tr>
				    <tr>
				      <td><p>' . $show . '<br />
				      2秒后返回指定页面！<br />
				      如果浏览器无法跳转，<a href="' . $url . '">请点击此处</a>。</p></td>
				    </tr>
				  </table>
				</div>
				</body>
				</html>';
		echo $msg;
		exit ();
	}

	//========================
} //end class
?>



