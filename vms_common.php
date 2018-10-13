<?php
function vms_leave_page()
{
	//將session清空
	unset($_SESSION['username']) ;
	echo '<meta http-equiv=REFRESH CONTENT=1;url="index.php">' ;
}

function vms_menu_page()
{
	echo "<a href=\"vms_logout.php\">登出</a>&nbsp;&nbsp;&nbsp;\n" ;
	echo "<a href=\"vms_man.php\">義工管理</a>&nbsp;&nbsp;&nbsp;\n" ;
	echo "<a href=\"vms_query\">查詢</a>&nbsp;&nbsp;&nbsp;\n" ;
}

function vms_checkLogin()
{
	if($_SESSION['username'] == null)
	{
		vms_leave_page() ;
		exit ;
	}
}

?>
