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
	echo "<a href=\"vms_class.php\">學員資料管理</a>&nbsp;&nbsp;&nbsp;\n" ;
	echo "<a href=\"vms_man.php\">義工簽到及工作群組管理</a>&nbsp;&nbsp;&nbsp;\n" ;
	echo "<a href=\"vms_query.php\">統計</a>&nbsp;&nbsp;&nbsp;\n" ;
}

function vms_checkLogin()
{
	if($_SESSION['username'] == null)
	{
		vms_leave_page() ;
		exit ;
	}
}

function print_page_start($t,$js)
{
	$p = '<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>' . 
$t . 
'</title>
<link rel="stylesheet" href="./jq/jquery-ui.css">
<script src="./jq/jquery-1.12.4.js"></script>
<script src="./jq/jquery-ui.js"></script>' .
$js .
'</head>' ;
	echo $p ;
}

?>
